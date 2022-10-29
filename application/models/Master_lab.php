<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_lab extends CI_Model {

	protected $sv;
	function __construct(){
		parent::__construct();
		$this->sv = $this->load->database('server',true);
	}

	public function group_lab()
	{
		$stat = $this->sv->get('fGroupPatologi');
		return $stat->result();
	}

	public function hirarki_lab()
	{
		$stat = $this->sv->get('fGroupPatologi');
		$parents =  $stat->result();
		if($parents){
			foreach ($parents as $parent){
				$parent->pemeriksas = $this->sv->where('KdGroup', $parent->KDGroup)->get('fPemeriksaanPatologi')->result();
				if($parent->pemeriksas){
					foreach ($parent->pemeriksas as $pemeriksa){
						$pemeriksa->details = 	$this->sv->where('KDDetail', $pemeriksa->KDDetail)->get('DetailPemeriksaan')->result();
					}
				}
			}
		}
		return $parents;
	}

	public function pemeriksaan_lab($kdgroup='')
	{
		if ($kdgroup!='') {
			$this->sv->where('KdGroup', $kdgroup);
		}
		$stat = $this->sv->get('fPemeriksaanPatologi');
		return $stat->result();
	}

	public function pembanding_lab($kddetail='')
	{
		if ($kddetail!='') {
			$this->sv->where('KDDetail', $kddetail);
		}
		$stat = $this->sv->get('DetailPemeriksaan');
		return $stat->result();
	}

	public function lab_group_post($data)
	{
		$cek = $this->sv->order_by('id','DESC')->limit(1)->get('fGroupPatologi')->row();
		$cek = $cek->KDGroup+1;
		$input = $this->sv->insert('fGroupPatologi',['KDGroup'=> $cek, 'id'=> $cek, 'NmGroup'=>$data['NmGroup']]);
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

	public function lab_group_update($data)
	{
		$up = $this->sv->where('KDGroup',$data['id'])->update("fGroupPatologi",[
            'NmGroup' => $data['NmGroup']
        ]);
        if ($up) {
			$parse = array(
				'cek' => $up,
				'message' => 'Berhasil diubah'
			);
		} else{
			$parse = array(
				'cek' => $up,
				'message' => 'Gagal diubah'
			);
		}
		return $parse;
	}

	public function pemeriksaan_post($data)
	{
		$listing = $this->sv->where('KdGroup', $data['kdgroup'])->order_by('KDDetail','DESC')->limit(1)->get('fPemeriksaanPatologi')->row();
		$index = "001";
		if (!empty($listing)) {
			$listing = $listing->KDDetail;
			$listing = substr($listing, strlen($data['kdgroup']));
			$listing++;
			if (strlen($listing) == 1) {
				$listing = "00".$listing;
			} elseif (strlen($listing) == 2) {
				$listing = "0".$listing;
			}
		} else{
			$listing = $index;
		}

		$input = $this->sv->insert('fPemeriksaanPatologi',[
			'KDDetail' => $data['kdgroup'].''.$listing,
			'KdGroup' => $data['kdgroup'],
			'NMDetail' => $data['detail'],
			'Satuan' => $data['satuan'],
			'KdInput' => $data['kdinput']
		]);
		if ($input) {
			$parse = array(
				'no' => $data['kdgroup'].''.$listing,
				'kode' => $data['kdgroup'],
				'status' => true,
				'message' => 'Berhasil menambahkan data'
			);
		} else {
			$parse = array(
				'no' => $data['kdgroup'].''.$listing,
				'kode' => $data['kdgroup'],
				'status' => false,
				'message' => 'Gagal menambahkan data'
			);
		}
		return $parse;
	}

	public function pemeriksaan_update($data)
	{
		$up = $this->sv->where('KDDetail',$data['id'])->update("fPemeriksaanPatologi",[
            'NMDetail' => $data['detail'],
            'Satuan' => $data['satuan'],
			'KdInput' => $data['kdinput']
        ]);
        if ($up) {
			$parse = array(
				'cek' => $up,
				'kode' => $data['kdgroup'],
				'message' => 'Berhasil diubah'
			);
		} else{
			$parse = array(
				'cek' => $up,
				'kode' => $data['kdgroup'],
				'message' => 'Gagal diubah'
			);
		}
		return $parse;
	}

	public function pembanding_post($data)
	{
		$index = "001";
		$listing = $this->sv->where('KDDetail', $data['kddetail'])->order_by('KodeDetail','DESC')->limit(1)->get('DetailPemeriksaan')->row();
		if (!empty($listing)) {
			$listing = $listing->KodeDetail;
			$listing = substr($listing, strlen($data['kddetail']));
			$listing++;
			if (strlen($listing) == 1) {
				$listing = "00".$listing;
			} elseif (strlen($listing) == 2) {
				$listing = "0".$listing;
			}
		} else{
			$listing = $index;
		}

		$input = $this->sv->insert('DetailPemeriksaan',[
			'KodeDetail' => $data['kddetail'].$listing,
			'KDDetail' => $data['kddetail'],
			'NamaDetail' => $data['detail'],
			'Satuan' => $data['satuan'],
			'KdInput' => $data['kdinput']
		]);
		if ($input) {
			$parse = array(
				'no' => $data['kddetail'].''.$listing,
				'kode' => $data['kddetail'],
				'status' => true,
				'message' => 'Berhasil menambahkan data'
			);
		} else {
			$parse = array(
				'no' => $data['kddetail'].''.$listing,
				'kode' => $data['kddetail'],
				'status' => false,
				'message' => 'Gagal menambahkan data'
			);
		}
		return $parse;
	}

	public function pembanding_update($data)
	{
		$up = $this->sv->where('KodeDetail',$data['id'])->update("DetailPemeriksaan",[
            'NamaDetail' => $data['nmdetail'],
            'Satuan' => $data['satuan'],
			'KdInput' => $data['kdinput']
        ]);
        if ($up) {
			$parse = array(
				'cek' => $up,
				'kode' => $data['id'],
				'message' => 'Berhasil diubah'
			);
		} else{
			$parse = array(
				'cek' => $up,
				'kode' => $data['id'],
				'message' => 'Gagal diubah'
			);
		}
		return $parse;
	}

	public function kelas($q, $limit, $offset)
	{
		$this->sv->select(['k.KDKelas', 'k.NMKelas', 'r.NmBangsal']);
		$this->sv->from('TBLKelas k')->join('TBLBangsal r', 'right(k.KDKelas,2) = r.KdBangsal');
		$this->sv->or_like('NMKelas', $q)
				->or_like('NmBangsal', $q);

		$this->sv->select("ROW_NUMBER() OVER (ORDER BY KDKelas) AS '__row_num__'");
		$sql  = "; WITH __result_cte__ AS (".$this->sv->get_compiled_select().")";
		$sql .= " SELECT * FROM __result_cte__ WHERE  __row_num__ BETWEEN ? AND ?;";

		$data = $this->sv->query($sql, [$offset + 1, $offset + $limit + 1])->result();

		$has_next = count($data) == (1 + $limit);
		if($has_next) {
			array_pop($data);
		}
		array_push($data, (object) array('KDKelas'=>'rj','NMKelas'=>'rawat_jalan','NmBangsal'=>'rawat_jalan') );

		return (Object) [
			'data'            => $data,
			'has_next'        => $has_next,
			'has_previous'    => $offset > 0,
			'next_offset'     => $offset + $limit,
			'previous_offset' => $offset - $limit,
		];
	}

	public function pemeriksaan_select2( $q, $limit, $offset) {
		$this->sv->select([
			'KdGroup',
			'NMDetail'
		]);

		$this->sv->from('fPemeriksaanPatologi');
			$this->sv
				->or_like('KdGroup', $q)
				->or_like('NMDetail', $q);

		$this->sv->select("ROW_NUMBER() OVER (ORDER BY KdGroup) AS '__row_num__'");
		$sql  = "; WITH __result_cte__ AS (".$this->sv->get_compiled_select().")";
		$sql .= " SELECT * FROM __result_cte__ WHERE  __row_num__ BETWEEN ? AND ?;";

		$data = $this->sv->query($sql, [$offset + 1, $offset + $limit + 1])->result();

		$has_next = count($data) == (1 + $limit);
		if($has_next) {
			array_pop($data);
		}

		return (Object) [
			'data'            => $data,
			'has_next'        => $has_next,
			'has_previous'    => $offset > 0,
			'next_offset'     => $offset + $limit,
			'previous_offset' => $offset - $limit,
		];
	}
}
