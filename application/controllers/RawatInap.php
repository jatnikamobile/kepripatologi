<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RawatInap extends CI_Controller {

	protected $csrf;
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('akses_level')) redirect('/Login');
		$this->csrf = array(
			'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash()
		);
        $this->load->model("RawatInap_model","rim");
        $this->load->model("Master_model","mm");

    }

    public function ajax_pasien_dirawat()
    {
		$kdbangsal = $this->session->userdata('kd_bangsal');
		$tanggal = $this->input->post("tanggal") ?: '';
        $medrec = $this->input->post("rm_nama") ?: '';
        $regno = $this->input->post("regno") ?: '';
        $nama = $this->input->post("rm_nama") ?: '';
        $dokter = $this->input->post("dokter") ?: '';

		// echo '<pre>'; print_r($order); exit();

		$list = $this->rim->list_pasien($tanggal, $medrec, $nama, $regno, $kdbangsal, $dokter);
		$no   = $_POST['start'];
		$data = []; 
        foreach($list as $l){
			$row  	= array();
			
				$no++;
				$row[] = $no;
				$row[] = date('d-m-Y',strtotime($l->Regdate));
				$row[] = $l->Regno;
				$row[] = $l->Medrec;
				$row[] = $l->Firstname;
				$row[] = $l->NmDoc;
				$row[] = $l->NmBangsal;
				$row[] = $l->NmKelas;
				$row[] = $l->NoKamar.'-'.$l->NoTTidur;
				$row[] = $l->NmKategori;
				
				// =============================
				$data[] = $row;
			// ===============================
        }

        $output 	= array(
            "draw"				=> $_POST['draw'],
            "recordsFiltered"	=> $this->rim->count_filtered_list_pasien($tanggal, $medrec, $nama, $regno, $kdbangsal, $dokter),
            "recordsTotal"		=> $this->rim->count_all_list_pasien(),
            // "totalFromPage"     => $this->cl->formatAngka($totalPage,2,2),
            // "totalFromData"     => $this->cl->formatAngka($totalFromData->TotalTagihan,2,2),
            "data"				=> $data
		);
        echo json_encode($output);
	}

}