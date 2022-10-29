<?php
// defined('BASEPATH') OR exit('No direct script access allowed');

class Registrasi extends CI_Controller {

	// protected $csrf;
	public function __construct()
	{
		parent::__construct();
		//if (!$this->session->has_userdata('akses_level')) redirect('/Login');
		$this->csrf = array(
			'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash()
		);
		$this->load->model("Master_model","mm");
		$this->load->model("Register_model","rm");
	}

	public function index()
	{
		$kategori = $this->mm->get_ktg_pasien();
		$instansi = $this->mm->get_instansi();
		$unit = $this->mm->get_instansi_unit();
		$negara = $this->mm->get_negara();
		$regno = $this->input->get('regno');
		$parse = array (
			'title'	    => 'Daftar Pasien',
			'main_menu' => 'registrasi',
            'content'   => 'content/register/index',
            'kategori'	=> $kategori,
            'instansi'	=> $instansi,
            'unit'	=> $unit,
            'regno'		=> $regno,
            'negara'		=> $negara,
            'role'	=> 0,
			'csrf'	    => $this->csrf,
		);
		$this->load->view('layouts/wrapper', $parse);
	}

	public function index_reg()
	{
		$kategori = $this->mm->get_ktg_pasien();
		$instansi = $this->mm->get_instansi();
		$unit = $this->mm->get_instansi_unit();
		$regno = $this->input->get('regno');
		$parse = array (
			'title'	    => 'Daftar Pasien',
			'main_menu' => 'registrasi',
            'content'   => 'content/register/index',
            'kategori'	=> $kategori,
            'instansi'	=> $instansi,
            'unit'	=> $unit,
            'regno'		=> $regno,
            'role'	=> '1',
			'csrf'	    => $this->csrf,
		);
		$this->load->view('layouts/wrapper', $parse);
	}
	public function index_instansi()
	{
		$kategori = $this->mm->get_ktg_pasien();
		$instansi = $this->mm->get_instansi();
		$unit = $this->mm->get_instansi_unit();
		$tindakan_micro = $this->mm->get_tindakan_micro();
		$regno = $this->input->get('regno');
		$parse = array (
			'title'	    => 'Daftar Pasien',
			'main_menu' => 'registrasi_instansi',
            'content'   => 'content/register/index_instansi',
            'kategori'	=> $kategori,
            'instansi'	=> $instansi,
            'tindakan_micro'	=> $tindakan_micro,
            'unit'	=> $unit,
            'regno'		=> $regno,
			'csrf'	    => $this->csrf,
		);
		$this->load->view('layouts/wrapper', $parse);
	}

	public function edit_instansi()
	{
		$kategori = $this->mm->get_ktg_pasien();
		$instansi = $this->mm->get_instansi();
		$unit = $this->mm->get_instansi_unit();
		$tindakan_micro = $this->mm->get_tindakan_micro();
		$regno = $this->input->get('regno');
		$parse = array (
			'title'	    => 'Daftar Pasien',
			'main_menu' => 'registrasi_instansi',
            'content'   => 'content/register/view_instansi',
            'kategori'	=> $kategori,
            'instansi'	=> $instansi,
            'unit'	=> $unit,
            'regno'		=> $regno,
			'csrf'	    => $this->csrf,
		);
		$this->load->view('layouts/wrapper', $parse);
	}

	public function bill_instansi()
	{
		$instansi = $this->mm->get_instansi();
		$unit = $this->mm->get_instansi_unit();
		$tindakan_micro = $this->mm->get_tindakan_micro();
		$regno = $this->input->get('regno');
		$parse = array (
			'title'	    => 'Daftar Pasien',
			'main_menu' => 'registrasi_instansi',
            'content'   => 'content/register/edit_instansi',
            'instansi'	=> $instansi,
            'unit'	=> $unit,
            'regno'		=> $regno,
            'tindakan_micro'		=> $tindakan_micro,
			'csrf'	    => $this->csrf,
		);
		$this->load->view('layouts/wrapper', $parse);
	}

	public function detail_instansi()
	{
		$instansi = $this->mm->get_instansi();
		$regno = $this->input->get('regno');
		$file = $this->rm->get_file_instansi($regno);
		$parse = array (
			'title'	    => 'Daftar Pasien',
			'main_menu' => 'registrasi_instansi',
            'content'   => 'content/register/detail_instansi',
            'instansi'	=> $instansi,
            'data'	=> $file,
            'regno_instansi'		=> $regno,
			'csrf'	    => $this->csrf,
		);
		$this->load->view('layouts/wrapper', $parse);
	}

	public function show_data(){
		$regno_instansi = $this->input->post('regno');
		$hasil = $this->mm->get_list_per_instansi($regno_instansi);
        $no=1;
        $jumlah_unit=0;
        $line2 = array();
        foreach ($hasil as $value) {
            $row2['no'] = $no;
            $row2['regno'] = $value->Regno;
            $row2['nama'] = $value->Firstname;
            $row2['nik'] = $value->nikktp;
            $row2['tgllahir'] = date("d/m/Y", strtotime($value->Bod));
            $row2['nohp'] = $value->phone;
            $no++;
            $line2[] = $row2;
        }
        $line['data'] = $line2;            
        echo json_encode($line);
	}

	public function getUnitInstansi(){
        $id = $this->input->post('id');
        $data  = '<option value="0">- Pilih Unit -</option>';
        $hasil = $this->mm->getUnitInstansi($id);
        foreach ($hasil as $value) {
            $data .= "<option value='".$value->KdUnit."'>".$value->NmUnit."</option>";
        }         
        echo json_encode(['success' => 1, 'data' => $data]);
    }

    public function getTarifTindakan(){
        $id = $this->input->post('id');
        $hasil = $this->mm->getTarifTindakan($id);
        // print_r($hasil);
        // echo json_encode($hasil);
        echo json_encode(['success' => 1, 'tarif' => $hasil->Tarif]);
    }

	public function list_pasien()
	{
		$parse = array (
			'title'	    => 'List Pasien',
			'main_menu' => 'listpasien',
            'content'   => 'content/register/list_pasien',
			'csrf'	    => $this->csrf,
		);
		$this->load->view('layouts/wrapper', $parse);
	}

	public function delete_peserta()
	{
		$regno = $this->input->get('regno');
		$hasil = $this->rm->deletePeserta($regno);
		redirect('list_pasien/index');
	}

	public function list_pasien_penunjang_klinik()
	{
		$date1 = $this->input->post('date1') ?? Date('Y-m-d');
		$date2 = $this->input->post('date2') ?? Date('Y-m-d');
		$medrec = $this->input->post('medrec');
		$list_pasien = $this->rm->list_pasien($date1, $date2, $medrec);
		$parse = array(
			'list' => $list_pasien,
			'status' => true
		);
		$this->load->view('content/register/table_registrasi', $parse);
	}

	public function pasien_by_rm()
	{
		$data = $this->input->post('medrec');
    	$up = $this->rm->get_pasien_by_rm($data);
    	$this->output
	    	->set_content_type('json')
	    	->set_output(json_encode($up));
	}

	public function change_kategori()
	{
		$data = $this->input->post();
    	$up = $this->rm->update_kategori($data);
    	$this->output
	    	->set_content_type('json')
	    	->set_output(json_encode($up));
	}

	public function post()
	{
		$data = $this->input->post();
    	$up = $this->rm->post_new($data);
    	// $update = $this->rm->update_registrasi($up['Regno']);
    	$this->output
	    	->set_content_type('json')
	    	->set_output(json_encode($up));
	}
	public function post_instansi()
	{
		$data = $this->input->post();
    	$up = $this->rm->post_instansi($data);
		// $result = $this->bpm->tambah_detail_billing($data);
    	$this->output
	    	->set_content_type('json')
	    	->set_output(json_encode($up));
	}

	public function update_instansi()
	{
		$data = $this->input->post();
    	$up = $this->rm->update_instansi($data);
		// $result = $this->bpm->tambah_detail_billing($data);
    	$this->output
	    	->set_content_type('json')
	    	->set_output(json_encode($up));
	}

	public function print_sep()
	{
		$data = $this->input->get('Regno');
		$data_pasien = $this->rm->get_pasien_by_regno($data);
		// var_dump($data_pasien);die();
		$this->load->view('content/register/lembar_sep', $data_pasien);
	}

	public function search_regno()
	{
		$data = $this->rm->get_pasien_by_regno($this->input->get('regno'));
		$this->output
	    	->set_content_type('json')
	    	->set_output(json_encode($data));
	}

	public function search_detail_instansi()
	{
		$data = $this->rm->get_detail_by_regno($this->input->get('regno'));
		$this->output
	    	->set_content_type('json')
	    	->set_output(json_encode($data));
	}

	public function do_upload()
	{
		$title = $this->input->post(); 
		$target_dir = "./assets/images/bukti_bayar_instansi/";
		$target_file = $target_dir . basename($_FILES["Pict"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$check = getimagesize($_FILES["Pict"]["tmp_name"]);
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["Pict"]["tmp_name"]);
		    if($check !== false) {
		        echo "File is an image - " . $check["mime"] . ".";
		        $uploadOk = 1;
		    } else {
		        echo "File is not an image.";
		        $uploadOk = 0;
		    }
		}

		if (file_exists($target_file)) {
		    echo "Sorry, file already exists.";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "pdf" ) {
		    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES["Pict"]["tmp_name"], $target_dir.$title['title'].'.'.$imageFileType)) {
		        echo "The file ". basename( $_FILES["Pict"]["name"]). " has been uploaded.".'<br>'.$target_dir;
		        $this->rm->update_photo($title['title'].'.'.$imageFileType, $title['title']);
		    } else {
		        echo "Sorry, there was an error uploading your file.";
		    }
		}
		redirect('Registrasi/detail_instansi?regno='.$title['title']);
	}
}