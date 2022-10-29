<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BillingPemeriksaan extends CI_Controller {

	protected $csrf;
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('akses_level')) redirect('/Login');
		$this->csrf = array(
			'name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash()
		);
		$this->load->model("Master_model","mm");
		$this->load->model("Master_lab","ml");
		$this->load->model("Register_model","rm");
		$this->load->model("BillingPemeriksaan_model","bpm");
	}

	public function index()
	{
		$parse = array (
			'title'	    => 'Billing Pemeriksaan',
			'main_menu' => 'billinglab',
            'content'   => 'content/billing_pemeriksaan/index',
            'regno'		=> $this->input->get('Regno'),
			'csrf'	    => $this->csrf,
		);

		$this->load->view('layouts/wrapper', $parse);
	}

	public function pasien_by_regno()
	{
		$data = $this->input->post('regno');
    	$up = $this->rm->get_pasien_by_rm($data);
    	$this->output
	    	->set_content_type('json')
	    	->set_output(json_encode($up));
	}

	public function show_detail()
	{

		$parse = array(
			'title'	    => 'Billing Pemeriksaan',
			'main_menu' => 'billinglab',
            'content'   => 'content/billing_pemeriksaan/billing_pemeriksaan_detail',
			'csrf'	    => $this->csrf
		);
		$this->load->view('layouts/wrapper', $parse);
	}

	public function list_billing()
	{
		$date1 = $this->input->post('date1') ?? Date('Y-m-d');
		$date2 = $this->input->post('date2') ?? Date('Y-m-d');
		$data = $this->bpm->list_billing_pemeriksaan($date1, $date2);

		$parse = array(
			'date1' => $date1,
			'date2' => $date2,
			'list' => $data
		);
		$this->load->view('content/billing_pemeriksaan/list_billing', $parse);	
	}

	public function show_group_pemeriksaan_lab()
	{
		$kdgroup = $this->input->post('kdgroup');
		$kdgroup == '' ? $list = $this->bpm->group_lab() : $list = $this->bpm->pemeriksaan_lab($kdgroup);

		$parse = array(
			'list' => $list,
			'status' => $kdgroup == '' ? true : false
		);
		$this->load->view('content/nilai_normal/group_lab', $parse);
	}

	public function check_tarif_pemeriksaan()
	{
		$params = $this->input->post();
		$data = $this->bpm->create_new_pemeriksaan($params);
		$this->output
	    	->set_content_type('json')
	    	->set_output(json_encode($data));
	}

	public function check_tarif_pemeriksaan_by_kdmapping()
	{
		$kdmapping = $this->input->post('kdmapping');
		$data = $this->bpm->tarif_pemeriksaan_by_kdmapping($kdmapping);
		$this->output
	    	->set_content_type('json')
	    	->set_output(json_encode($data));
	}

	public function get_pasien_by_regno()
	{
		$data = $this->input->post('regno');
		$data_pasien = $this->rm->get_pasien_by_regno($data);
		$this->output
	    	->set_content_type('json')
	    	->set_output(json_encode($data_pasien));
	}

	public function detail_billing_pasien()
	{
		$detail = $this->bpm->get_billing_detail($this->input->get('notran'));

		$parse = array(
			'status' => true,
			'notran' => $this->input->get('notran'),
			'detail' => $detail
		);
		$this->load->view('content/billing_pemeriksaan/table_billing_pemeriksaan', $parse);
	}

	public function post_transaksi()
	{
		$data = $this->input->post();
    	$up = $this->bpm->create_billing_pemeriksaan($data);
		$this->output
	    	->set_content_type('json')
	    	->set_output(json_encode($up));
	}

	public function delete_transaksi()
	{
		$notran = $this->input->post('notran');
		$up = $this->bpm->delete_billing_laboratorium($notran);
		$this->output
	    	->set_content_type('json')
	    	->set_output(json_encode($up));
	}

	public function delete_one_billing()
	{
		$params = $this->input->post();
		$delete = $this->bpm->delete_billing_laboratorium_one($params);
		$this->output
	    	->set_content_type('json')
	    	->set_output(json_encode($delete));
	}

	public function print_label_billing()
	{
		$notransaksi = $this->input->get('notransaksi');
		$cetak = $this->input->get('cetak') ?? '3';
		$data = $this->bpm->get_label_billing($notransaksi);
		$parse = array(
			'data' => $data,
			'looping' => $cetak
		);
		$this->load->view('content/billing_pemeriksaan/label_billing', $parse);
	}

	public function print_rincian_biaya_billing_pemeriksaan()
	{
		$notransaksi = $this->input->get('notransaksi');
		$head = $this->bpm->get_label_billing($notransaksi);
		$detail = $this->bpm->get_billing_detail($notransaksi);
		$parse = array(
			'head' => $head,
			'detail' => $detail
		);
		$this->load->view('content/billing_pemeriksaan/rincian_billing_pemeriksaan', $parse);
	}

	public function post_new_pemeriksaan()
	{
		$data = $this->input->post();
		$post = $this->bpm->create_new_pemeriksaan($data);
		$this->output
	    	->set_content_type('json')
	    	->set_output(json_encode($post));
	}

	public function update_total_biaya()
	{
		$data = $this->input->post();
		$post = $this->bpm->update_total_biaya($data);
		$this->output
	    	->set_content_type('json')
	    	->set_output(json_encode($post));	
	}

	public function update_dokter_pengirim()
	{
		$data = $this->input->post();
		$post = $this->bpm->update_dokter_pengirim($data);
		$this->output
	    	->set_content_type('json')
	    	->set_output(json_encode($post));	
	}
}