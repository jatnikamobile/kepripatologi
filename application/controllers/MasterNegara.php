<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MasterNegara extends CI_Controller {

	protected $csrf;
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('akses_level')) redirect('/Login');
		$this->csrf = array(
			'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash()
		);
		$this->load->model("Master_model","mi");
	}

	public function index()
	{
		$negara = $this->mi->get_negara();
		$parse = array (
			'title'	    => 'Master Instansi',
			'main_menu' => 'masterinstansi',
            'content'   => 'content/master_negara/index',
            'negara' => $negara,
			'csrf'	    => $this->csrf,
		);
		$this->load->view('layouts/wrapper', $parse);
	}

	public function insert_negara()
	{
		$data = $this->input->post();
		$post = $this->mi->negara_post($data);
		$this->output
	    	->set_content_type('json')
	    	->set_output(json_encode($post));
	}

	public function delete()
	{
		$id_negara = $this->input->post('id_negara');
		$post = $this->mi->negara_delete($id_negara);
		$this->output
	    	->set_content_type('json')
	    	->set_output(json_encode($post));
	}


}
