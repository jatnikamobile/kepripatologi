<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

	protected $csrf;
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('akses_level')) redirect('/Login');
		$this->csrf = array(
			'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash()
		);
		$this->load->model("model_laporan");
	}

	public function index()
	{
		$parse = array (
			'title'	    => 'Laporan Per Instansi',
			'main_menu' => 'laporan',
            'content'   => 'content/laporan/index',
            'instansi' => $this->model_laporan->get_instansi(),
            'hasil' => $this->model_laporan->get_pil_hasil(),
			'csrf'	    => $this->csrf,
		);
		$this->load->view('layouts/wrapper', $parse);
	}

	private function _dateFormat($date){
		$d = explode('-', $date);
		return $d[2].'-'.$d[1].'-'.$d[0];
	}

	public function getSampleData(){
		$data = [
			'Sample 1',
			'Sample 2',
			'Sample 3'
		];

		echo json_encode(array('data'=>$data));
	}
	public function getDataTable() {
		$line  = array();
		$line2 = array();
		$row  = array();

		$tgl_awal= date('Y-m-d 00:i:s', strtotime($this->input->post('tgl_awal')));
		$tgl_akhir= date('Y-m-d 00:i:s', strtotime($this->input->post('tgl_akhir')));
		if($this->session->userdata('grup') == 'INSTANSI'){
			$instansi=$this->session->userdata('kdInstansi');
		}else{
			$instansi=$this->input->post('instansi');
		}
		$fil_hasil=$this->input->post('hasil');
		$hasil = $this->model_laporan->get_data($tgl_awal, $tgl_akhir, $instansi,$fil_hasil);
		/*echo json_encode($hasil);*/
		$i=1;
		foreach ($hasil as $value) {
			$row['no'] = $i++;
			$row['rm'] = $value->MedRec;
			$row['nolab'] = $value->NoTran;
			$row['nikktp'] = $value->nikktp.' -';
			$row['nama'] = $value->Firstname;
			$row['jenkel'] = $value->Sex;
			$row['tgl_lahir'] = $value->TglLahir;
			$row['umur'] = $value->UmurThn;
			$row['tgl_sampel'] = $value->TglSampel ? date("d-m-Y", strtotime($value->TglSampel)) : '';
			$row['tanggal_periksa'] = $value->Tanggal ? date("d-m-Y", strtotime($value->Tanggal)) : ''; 
			$row['jenis_sampel'] = $value->AsalSampel;
			$row['tindakan'] = $value->NMDetail;
			$row['pengirim'] = $value->pemeriksa;
			$row['telp'] = $value->phone;
			$row['pengambil_sampel'] = $value->Pengambil_sampel;
			$row['verifikator'] = $value->Verifikasi;
			$row['setujui'] = $value->Setujui;
			$row['instansi'] = $value->NmInstansi;
			$row['keterangan'] = $value->Catatan;
			if ($value->hasil == 'Terdeteksi (Positif)') {
				$row['hasil'] = '<span style="background: red">'.$value->hasil.'</span>' ;
			}else{
				$row['hasil'] = $value->hasil ;
			}
			if ($value->hasil != '') {
				$row['print'] = '<input type="button" name="selesai" onclick="print(\''.$value->NoTran.'\')" class="btn btn-primary" value="Print Hasil"><input type="button" name="selesait" onclick="print_eng(\''.$value->NoTran.'\')" class="btn btn-primary" value="Print Eng. Ver">' ;
			}else{
				$row['print'] = '<button type="button" name="print" class="btn btn-primary btn-block" id="print" disabled>Print Hasil</button>' ;
			}

			$line2[] = $row;
		}
			

		$line['data'] = $line2;

		echo json_encode($line);
	}

	public function print_hasil_pemeriksaan()
	{
		$this->load->library('ciqrcode');
		$Notran=$this->input->get('notran');
		// echo '<pre>'; print_r($Notran); exit();
		$infoCovid19 = "hide";
		$pengesahan = "qr";
		$custom_detail = "";
		$head = $this->model_laporan->get_head_hasil_pemeriksaan($Notran);
		$fdokter = $this->model_laporan->get_dokter_kepala();
		$fprofile = $this->model_laporan->get_fprofile();
		$tgl_ttd = $this->input->get('tanggal_ttd');

		$config['cacheable']    = true; 
        $config['cachedir']     = './assets/';
        $config['errorlog']     = './assets/'; 
        $config['imagedir']     = './assets/qr/';
        $config['quality']      = true;
        $config['size']         = '1024'; 
        $config['black']        = array(224,255,255);
        $config['white']        = array(70,130,180);
        $this->ciqrcode->initialize($config);
 		$date=date("d-F-Y", strtotime($head[0]->Tglhasil));
 		$lab=$head[0]->Nolab;
 		$nmdoc = isset($fdokter) ? $fdokter->NmDoc : '-';
 		$korps = isset($fdokter) ? $fdokter->korps_ttd : '-';
        $image_name=$lab.'.png'; //buat name dari qr code sesuai dengan nim
 		$dataqr="RSAU, PATOLOGI ANATOMI,Dokter:".$nmdoc.",".$korps.",".$head[0]->Firstname.",".$head[0]->MedRec.",".$head[0]->Sex.",".$date."";
        $params['data'] = $dataqr; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name;
		$this->ciqrcode->generate($params);
		// echo "<pre>"; print_r($infoCovid19); die();
		$detail = $this->model_laporan->search_group_print($Notran, $custom_detail);
		$parse = array(
			'head' => $head,
			'detail' => $detail,
			'fdokter' => $fdokter,
			'fprofile' => $fprofile,
			'infocvd19' => $infoCovid19,
			'pengesahan' => $pengesahan,
			'qr' => $image_name,
			'tgl_ttd' => $tgl_ttd,
		);

		$this->load->view('content/hasil_pemeriksaan/print_hasil_pemeriksaan', $parse);
		
	}

	public function print_hasil_pemeriksaan_eng()
	{
		$this->load->library('ciqrcode');
		$Notran=$this->input->get('notran');
		// echo '<pre>'; print_r($Notran); exit();
		$infoCovid19 = "hide";
		$pengesahan = "qr";
		$custom_detail = "";
		$head = $this->model_laporan->get_head_hasil_pemeriksaan($Notran);
		$fdokter = $this->model_laporan->get_dokter_kepala();
		$fprofile = $this->model_laporan->get_fprofile();
		$tgl_ttd = $this->input->get('tanggal_ttd');

		$config['cacheable']    = true; 
        $config['cachedir']     = './assets/';
        $config['errorlog']     = './assets/'; 
        $config['imagedir']     = './assets/qr/';
        $config['quality']      = true;
        $config['size']         = '1024'; 
        $config['black']        = array(224,255,255);
        $config['white']        = array(70,130,180);
        $this->ciqrcode->initialize($config);
 		$date=date("d-F-Y", strtotime($head->Tglhasil));
 		$lab=$head->Nolab;
        $image_name=$lab.'.png'; //buat name dari qr code sesuai dengan nim
 		$dataqr="RSAU, PATOLOGI ANATOMI,Dokter:".$fdokter->NmDoc.",".$fdokter->korps_ttd.",".$head->Firstname.",".$head->MedRec.",".$head->Sex.",".$date."";
        $params['data'] = $dataqr; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name;
		$this->ciqrcode->generate($params);
		// echo "<pre>"; print_r($infoCovid19); die();
		$detail = $this->model_laporan->search_group_print($Notran, $custom_detail);
		$parse = array(
			'head' => $head,
			'detail' => $detail,
			'fdokter' => $fdokter,
			'fprofile' => $fprofile,
			'infocvd19' => $infoCovid19,
			'pengesahan' => $pengesahan,
			'qr' => $image_name,
			'tgl_ttd' => $tgl_ttd,
		);

		$this->load->view('content/hasil_pemeriksaan/print_hasil_pemeriksaan_eng', $parse);
		
	}

}
