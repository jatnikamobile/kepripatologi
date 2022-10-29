<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MasterInstansi extends CI_Controller {

	protected $csrf;
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('akses_level')) redirect('/Login');
		$this->csrf = array(
			'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash()
		);
		$this->load->model("Master_instansi","mi");
	}

	public function index()
	{
		$instansi = $this->mi->get_instansi();
		$parse = array (
			'title'	    => 'Master Instansi',
			'main_menu' => 'masterinstansi',
            'content'   => 'content/master_instansi/index',
            'instansi' => $instansi,
			'csrf'	    => $this->csrf,
		);
		$this->load->view('layouts/wrapper', $parse);
	}

	public function show_tarif()
	{
		$kode = $this->input->post('KdInstansi');
		$unit = $this->mi->get_data_unit($kode);
		$parse = array (
			'unit'=> $unit,
			'kode'=> $kode,
			'csrf'		 => $this->csrf
		);
		$this->load->view('content/master_instansi/detail', $parse);
	}

	public function insert()
	{
		$data = $this->input->post();
		$post = $this->mi->instansi_unit_post($data);
		$this->output
	    	->set_content_type('json')
	    	->set_output(json_encode($post));
	}

	public function insert_instansi()
	{
		$data = $this->input->post();
		$post = $this->mi->instansi_post($data);
		$this->output
	    	->set_content_type('json')
	    	->set_output(json_encode($post));
	}

	public function update_instansi()
	{
		$kdIns = $this->input->post('kd_instansi');
		$user = $this->input->post('user_instansi');
		$pass = $this->input->post('pass_instansi');
		$tampil_laporan = $this->input->post('tampil_laporan');
		$post = $this->mi->update_pass($pass, $kdIns, $user, $tampil_laporan);
		$this->output
	    	->set_content_type('json')
	    	->set_output(json_encode($post));
	}

	public function delete()
	{
		$kdunit = $this->input->post('kdunit');
		$post = $this->mi->instansi_delete($kdunit);
		$this->output
	    	->set_content_type('json')
	    	->set_output(json_encode($post));
	}


}
