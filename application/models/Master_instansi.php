<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_instansi extends CI_Model {
	
	protected $sv;
	function __construct(){
		parent::__construct();
        $this->sv = $this->load->database('server',true);
	}

	public function get_instansi($kode='')
	{
		if ($kode!='') {
			$this->sv->where('KdInstansi', $kode);
		}
		$this->sv->select('TBLInstansi.*, DBpass.NamaUser as username_instansi, DBpass.Password as password_instansi, DBpass.TmplLaporan');
		$stat = $this->sv->from('TBLInstansi')->join('DBpass', 'TBLInstansi.KdInstansi = DBpass.KdInstansi', 'left')->get();
		return $stat->result();	
	}

	public function get_data_unit($id='')
	{
		if ($id!='') {
			$this->sv->where('KdInstansi', $id);
		}
		$stat = $this->sv->get('TBLUnitInstansi');
		return $stat->result();
	}

	public function instansi_unit_post($data)
	{
		$cek = $this->sv->order_by('KdUnit','DESC')->limit(1)->get('TBLUnitInstansi')->row();
		$cek = $cek->KdUnit+1;
		$input = $this->sv->insert('TBLUnitInstansi',['KdUnit'=> $cek, 'kdInstansi'=> $data['kdInstansi'], 'NmUnit'=>$data['unit']]);
		if ($input) {
			$parse = array(
				'cek' => $cek,
				'insert' => $input,
				'message' => 'Berhasil ditambahkan'
			);
		} else{
			$parse = array(
				'cek' => $cek,
				'insert' => $input,
				'message' => 'Gagal ditambahkan'
			);
		}
		return $parse;
	}
	public function instansi_post($data)
	{
		$cek = $this->sv->order_by('KdInstansi','DESC')->limit(1)->get('TBLInstansi')->row();
		$cek = $cek->KdInstansi+1;
		$input = $this->sv->insert('TBLInstansi',['KdInstansi'=> $cek, 'NmInstansi'=>$data['instansi']]);
		$tambah = $this->sv->insert('DBpass',['KdInstansi'=> $cek, 'DisplayName'=>$data['instansi'], 'NamaUser'=>strtoupper(str_replace(' ', '_',$data['instansi'])),'Password'=>'1234', 'TRGroup'=> 'INSTANSI', 'oLevel'=> 0,'KdPoli'=> 0, 'TmplLaporan'=> 0]);
		if ($input) {
			$parse = array(
				'cek' => $cek,
				'insert' => $input,
				'message' => 'Berhasil ditambahkan'
			);
		} else{
			$parse = array(
				'cek' => $cek,
				'insert' => $input,
				'message' => 'Gagal ditambahkan'
			);
		}
		return $parse;
	}
	public function update_pass($pass,$kd, $user, $tampil_laporan)
	{
		$this->sv->where('kdInstansi', $kd);
		$this->sv->where('NamaUser', $user);
		$update = $this->sv->update('DBpass', array('Password' => $pass, 'TmplLaporan' => $tampil_laporan));
		if ($update) {
			$parse = array(
				'update' => $update,
				'message' => 'Berhasil diupdate'
			);
		} else{
			$parse = array(
				'update' => $update,
				'message' => 'Gagal diupdate'
			);
		}
		return $parse;
	}

	public function instansi_delete($KdUnit)
	{
	
		$delete = $this->sv->delete('TBLUnitInstansi', array('KdUnit' => $KdUnit));
		if ($delete) {
			$parse = array(
				'delete' => $delete,
				'message' => 'Berhasil dihapus'
			);
		} else{
			$parse = array(
				'delete' => $delete,
				'message' => 'Gagal dihapus'
			);
		}
		return $parse;
	}

}