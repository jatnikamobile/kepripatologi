<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billing extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("BillingPemeriksaan_model","bpm");
	}

	public function index()
	{
		$params = $this->input_sanitizer->method('get')
			->string('term')
			->date('from_date', ['d/m/Y', 'Y-m-d'])
			->date('to_date', ['d/m/Y', 'Y-m-d'])
			->value('array');

		$result = $this->bpm->get_list_billing_pemeriksaan_page($params);

		$parse = array (
			'title'	    => 'Billing Pemeriksaan',
			'main_menu' => 'billinglab',
            'content'   => 'content/billing/list',
			'page_hasil'=> $result,
			'input'     => $params,
		);

		$this->load->view('layouts/wrapper', $parse);
	}

	public function index__table_part()
	{
		$params = $this->input_sanitizer->method('get')
			->string('term')
			->date('from_date', ['d/m/Y', 'Y-m-d'])
			->date('to_date', ['d/m/Y', 'Y-m-d'])
			->value('array');

		$result = $this->bpm->get_list_billing_pemeriksaan_page($params);

		$base_view = 'content/billing/list';

		$result = [
			'html_table_rows' => $this->load->view($base_view.'.table-rows.php', ['data' => $result->data], TRUE),
			'html_pagination' => $this->load->view($base_view.'.pagination.php', array_merge((Array) $result->pagination, ['input' => $params]), TRUE),
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}

	public function baru($regno = NULL)
	{
		$register = $this->bpm->get_billing_pasien_by_regno($regno);

		$list_group_tindakan = $this->bpm->get_group_pemeriksaan();
		$list_cara_bayar = $this->bpm->list_cara_bayar();
		$tindakan_order = (object)array("KdPemeriksaan"=>'');
		$parse = array (
			'title'	         => 'Billing Pemeriksaan',
			'main_menu'      => 'billinglab',
            'content'        => 'content/billing/form',
            'register'       => $register,
			'tindakan_order' => $tindakan_order,
            'group_tindakan' => $list_group_tindakan,
			'cara_bayar'	 => $list_cara_bayar
		);

		$this->load->view('layouts/wrapper', $parse);
	}

	public function edit($no_trans = NULL)
	{
		$billing = $this->bpm->get_billing_pasien_by_no_trans($no_trans);
		$tindakan_order = $this->bpm->get_tindakan_order_pasien($no_trans);
		$list_cara_bayar = $this->bpm->list_cara_bayar();
	if(empty($tindakan_order)){
		$tindakan_order = (object)array("KdPemeriksaan"=>'');
	}// $tindakan_order = (object)array("KdPemeriksaan"=>'');
		if(empty($no_trans)){
		 return show_404();
		}else if(empty($billing)){
			$billing = $this->bpm->get_billing_order_pasien_by_no_trans($no_trans);
		}
		$register = $this->bpm->get_billing_pasien_by_regno($billing->Regno);

		$list_group_tindakan = $this->bpm->get_group_pemeriksaan();

		$parse = array (
			'title'	         => 'Billing Pemeriksaan',
			'main_menu'      => 'billinglab',
            'content'        => 'content/billing/form',
            'register'       => $register,
            'billing'        => $billing,
            'tindakan_order' => $tindakan_order,
            'group_tindakan' => $list_group_tindakan,
			'cara_bayar' 	 => $list_cara_bayar
		);

		$this->load->view('layouts/wrapper', $parse);
	}

	public function type1($no_trans = NULL)
	{
		if(empty($no_trans)) return show_404();

		$billing = $this->bpm->get_billing_pasien_by_no_trans($no_trans);
		// echo '<pre>'; print_r($billing); die();
		if(empty($no_trans)) return show_404();

		$register = $this->bpm->get_billing_pasien_by_regno($billing->Regno);

		$list_group_tindakan = $this->bpm->get_group_pemeriksaan();

		$parse = array (
			'title'	         => 'Billing Pemeriksaan',
			'main_menu'      => 'billinglab',
			'content'        => 'content/billing/type1',
			'register'       => $register,
			'billing'        => $billing,
			'group_tindakan' => $list_group_tindakan,
		);
		$this->load->view('layouts/print', $parse);
	}

	public function type2($no_trans = NULL)
	{
		if(empty($no_trans)) return show_404();

		$billing = $this->bpm->get_billing_pasien_by_no_trans($no_trans);
		if(empty($no_trans)) return show_404();

		$register = $this->bpm->get_billing_pasien_by_regno($billing->Regno);

		$list_group_tindakan = $this->bpm->get_group_pemeriksaan();

		$parse = array (
			'title'	         => 'Billing Pemeriksaan',
			'main_menu'      => 'billinglab',
			'content'        => 'content/billing/type2',
			'register'       => $register,
			'billing'        => $billing,
			'group_tindakan' => $list_group_tindakan,
		);
		$this->load->view('layouts/print', $parse);
	}
	// public function form($no_trans = NULL)
	// {

	// }

	// protected function form_post($no_trans)
	// {

	// }

	public function get_pasien($regno = NULL)
	{

	}

	public function get_list_transaksi($regno = NULL)
	{

	}

	/* ocha */
	public function update_qty(){
		$regno = $this->input->get('regno');
		$notran = $this->input->get('notran');
		$kdtarif = $this->input->get('kdtarif');
		$qty = $this->input->get('qty');

		$output = $this->bpm->update_qty_transaksi($regno, $notran, $kdtarif, $qty);

		echo json_encode($output);
	}
	/* ---- */
}
