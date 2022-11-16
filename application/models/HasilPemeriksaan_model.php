<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HasilPemeriksaan_model extends MY_Model {

	protected $sv;
	function __construct(){
		parent::__construct();
        $this->sv = $this->load->database('server',true);
        $this->db = $this->load->database('default',true);
        $this->load->model("Master_lab","ml");
	}

	public function get_head_hasil_pemeriksaan($notran)
	{
		$data = $this->sv->select('head.*,register.nikktp as Nik, headbilling.TglSampel, headbilling.AsalSampel, headbilling.Verifikasi, headbilling.Setujui , register.Firstname, register.KdSex, register.KdTuju, register.KdCbayar, kategori.NmKategori, register.Bod, headbilling.KdDoc, headbilling.NmDoc, headbilling.KdBangsal, bangsal.NmBangsal, kelas.NMkelas, poli.NMPoli, dokter.NmDoc as dokterPemeriksa, master.Address, headbilling.TglSampel, headbilling.kewarganegaraan, headbilling.AsalSampel, g.NmGroup, headbilling.Jumlah as Tarif')
			->from('HasilPatologi head')
			->join('Register register', 'head.Regno = register.Regno', 'INNER')
			->join('MasterPS master', 'register.Medrec = master.Medrec', 'LEFT')
			->join('HeadBilPatologi headbilling', 'head.NoTran = headbilling.NoTran', 'LEFT')
			->join("TBLBangsal bangsal", "headbilling.KdBangsal = bangsal.KdBangsal", "LEFT")
			->join("TBLKelas kelas", "headbilling.KdKelas = kelas.KdKelas", "LEFT")
			->join("POLItpp poli", "headbilling.KdPoli = poli.KDPoli", "LEFT")
			->join("FtDokter dokter", "headbilling.KdDokter = dokter.KdDoc", "LEFT")
			->join("TblKategoriPsn kategori", "headbilling.Kategori = kategori.KdKategori", "LEFT")
			->join('fGroupPatologi g', 'head.KdGroup = g.KDGroup', 'LEFT')
			// ->where('head.NoTran', $notran)->get()->row();
			->where('head.NoTran', $notran)->get()->result();
		return $data;
	}

	public function get_bangsal()
	{
		return $this->sv->select("*")
			->from('TBLBangsal')
			->order_by('NmBangsal', 'ASC')
			->get()->result();
	}
	public function get_fprofile()
	{
		return $this->sv->select("*")
			->from('fProfile')
			->get()->row();
	}

	public function get_dokter_kepala()
	{
		return $this->sv->select("*")
			->from('FtDokter')
			->where('jabatan', 'Kepala Lab')
			->get()->row();
	}

	public function get_pil_hasil()
	{
		return $this->sv->select("*")
			->from('TBLHasilMicro')
			->get()->result();
	}

	public function get_detail_hasil_pemeriksaan($notran)
	{
		$data = $this->sv->select("detail.*, fp.KdGroup")
			->from('HasilPatologi detail')
			->join('fPemeriksaanPatologi AS fp', 'fp.KDDetail=detail.KDDetail', 'LEFT')
			->where('detail.NoTran', $notran)
			->order_by('detail.KDDetail', 'ASC')
			->get()->result();

		return $data;
	}

	public function get_group($kdtransaksi)
	{
		$result = [];
		$data = $this->sv->select('KDGroup, NmGroup')->order_by('KDGroup', 'ASC')->get('fGroupPatologi')->result();
		foreach ($data as $group) {
			$result[] = $this->get_detail_hasil_by_group($group->KDGroup, $kdtransaksi);
		}
		return $result;
	}

	public function get_detail_hasil_by_group($kdgroup = '', $notran)
	{
		$filter = [];
		$data = $this->sv->select('detail.*')->from('HasilPatologi detail')
			->where('detail.NoTran', $notran)->get()->result();
		if (!empty($data)) {
			foreach ($data as $l) {
				$kdgroup = substr($l->KdGroup, 0, 2);
				$filter[] = $l;
			}
		}
		$parse = array(
			'kdgroup' => $kdgroup,
			'data' => $data,
			'filter' => $filter
		);
		return $parse;
	}

	public function update_hasil($data)
	{
		foreach ($data['hasil'] as $key => $list) {
			$update_detail['kddetail'] = $list['kddetail'] ?? '';
			$update_detail['Hasil_KetKlinik'] = $list['Hasil_KetKlinik'] ?? '';
			$update_detail['Hasil_PemMakro'] = $list['Hasil_PemMakro'] ?? '';
			$update_detail['Hasil_PemMikro'] = $list['Hasil_PemMikro'] ?? '';
			$update_detail['Hasil_Kesimpulan'] = $list['Hasil_Kesimpulan'] ?? '';
			$update_detail['Hasil_Anjuran'] = $list['Hasil_Anjuran'] ?? '';
			$update_detail['Hasil_Datawal'] = $list['Hasil_Datawal'] ?? '';
			$update_detail['Hasil_Imuno'] = $list['Hasil_Imuno'] ?? '';
			$update_detail['Hasil_pemImuno'] = $list['Hasil_pemImuno'] ?? '';
			$update_detail['tglhasil'] = date('Y-m-d');
			$update_detail['jamhasil'] = date('Y-m-d H:i:s');
			$this->sv->where('KDDetail', $list['kddetail'])
				->where('NoTran', $data['NoTran'])
				->update('HasilPatologi', $update_detail);
		}
		$update_billing = array(
			'TglSampel' => $data['tgl_sample'],
			'AsalSampel' => $data['asal_sample'],
			'TglHasil' => $data['Tgl_hasil'].' '.$data['Jam_hasil'],
			'JamHasil' => date('Y-m-d H:i:s')
		);

		$post_update_billing = $this->sv->where('NoTran', $data['NoTran'])->update('HeadBilPatologi', $update_billing);
		$parse = array(
			'message' => 'Berhasil input hasil',
			// 'update' => $post_update_hasil,
			// 'update_billing' => $post_update_billing
		);
		return $parse;
	}

	public function get_list_hasil_pemeriksaan_page($filter_options)
	{
		$this->db_interface =& $this->sv;

		extract($filter_options);

		$sql1 = "SELECT * FROM HasilPatologi AS dh WHERE dh.NoTran=h.NoTran AND COALESCE(CONVERT(VARCHAR, dh.TglHasil), '') != ''";
		$sql2 = "SELECT * FROM HasilPatologi AS dh WHERE dh.NoTran=h.NoTran AND COALESCE(CONVERT(VARCHAR, dh.TglHasil), '') = ''";

		$select = [
			'h.*',
			'hb.TglHasil as hasilbil',
			'hb.TotalBiaya',
			'hb.Tanggal',
			'bsl.NmBangsal',
			'pol.NMPoli',
			'kls.NMKelas',
			'kat.NmKategori',
			'pas.Address',
			'hb.kewarganegaraan',
			'reg.Catatan AS CatatanRegistrasi',
			"CASE WHEN EXISTS($sql1) THEN 1 ELSE 0 END AS HasFilledIn",
			"CASE WHEN EXISTS($sql2) THEN 1 ELSE 0 END AS HasNotFilled",
		];

		$from = [
			'HasilPatologi AS h',
			'LEFT JOIN Register AS reg ON h.Regno = reg.Regno',
			'LEFT JOIN MasterPS AS pas ON h.MedRec = pas.MedRec',
			'LEFT JOIN HeadBilPatologi AS hb ON hb.NoTran = h.Notran',
			'LEFT JOIN TBLBangsal AS bsl ON hb.KdBangsal = bsl.KdBangsal',
			'LEFT JOIN TBLKelas AS kls ON hb.KdKelas = kls.KdKelas',
			'LEFT JOIN POLItpp AS pol ON hb.KdPoli = pol.KDPoli',
			'LEFT JOIN TblKategoriPsn AS kat ON hb.Kategori = kat.KdKategori',
		];

		$where = $this->db->compile_binds('CAST(Regdate AS DATE) BETWEEN ? AND ?', [date('Y-m-d', strtotime($from_date)),date('Y-m-d', strtotime($to_date))]);

		// Filter belum diisi
		if($status_hasil == 1)
		{
			$where .= ' AND HasFilledIn = 0 AND HasNotFilled = 1';
		}
		// Filter belum lengkap
		elseif($status_hasil == 2)
		{
			$where .= ' AND HasFilledIn = 1 AND HasNotFilled = 1';
		}
		// Filter sudah lengkap
		elseif($status_hasil == 3)
		{
			$where .= ' AND HasFilledIn = 1 AND HasNotFilled = 0';
		}

		if(!empty($term))
		{
			$builded_term = "LIKE '%".$this->db->escape_like_str($term)."%' ESCAPE '!'";
			$where .= " AND (MedRec $builded_term
				OR NMPoli $builded_term
				OR NmBangsal $builded_term
				OR Regno $builded_term
				OR Firstname $builded_term
				OR NoLab $builded_term
			)";
		}elseif (!empty($ruangan)){
			$builded_term = "LIKE '%".$this->db->escape_like_str($ruangan)."%' ESCAPE '!'";
			$where .= " AND (MedRec $builded_term
				OR NMPoli $builded_term
				OR NmBangsal $builded_term
				OR Regno $builded_term
				OR Firstname $builded_term
				OR NoLab $builded_term
			)";
		}

		return $this->raw_query_pagination($select, $from, $where, 'NoTran ASC');
	}

	public function get_list_hasil_pemeriksaan_page2($filter_options)
	{
		$this->db_interface =& $this->sv;

		extract($filter_options);

		$where ='';

		if($status_hasil == 1)
		{
			$where = ' AND HasFilledIn = 0 AND HasNotFilled = 1';
		}
		// Filter belum lengkap
		elseif($status_hasil == 2)
		{
			$where = ' AND HasFilledIn = 1 AND HasNotFilled = 1';
		}
		// Filter sudah lengkap
		elseif($status_hasil == 3)
		{
			$where = ' AND HasFilledIn = 1 AND HasNotFilled = 0';
		}

			$sql = 'SELECT * from HasilPatologi
				where  CAST(TglHasil AS DATE) BETWEEN ? and ? '.$where.' ';			
			$result = $this->sv->query($sql, array( $from_date, $to_date))->result();

		return $result;
	}

	public function get_list_hasil_pemeriksaan($filter_options = [])
	{
		$this->sv
			->select([
				'head.*',
				'headbilling.TglHasil as hasilbil',
				'headbilling.TotalBiaya',
				'bangsal.NmBangsal',
				'poli.NMPoli',
				'kelas.NMKelas',
				'kategori.NmKategori',
				'mps.Address',
				'r.Catatan AS CatatanRegistrasi',
			])
			->select('ROW_NUMBER() OVER (ORDER BY head.NoTran ASC) AS row_number', FALSE);

		$sql = "SELECT * FROM HasilPatologi AS dh WHERE dh.NoTran=head.NoTran AND dh.KdInput != 4 AND COALESCE(CONVERT(VARCHAR, dh.Hasil), '') = ''";

		$this->sv->select("CASE WHEN EXISTS($sql) THEN 1 ELSE 0 END AS BelumLengkap");

		$data = $this->generic_pagination(50, $filter_options);

		return $data;
	}

	protected function get_list_hasil_pemeriksaan_query_scope($term, $filter_options)
	{
		extract($filter_options);

		$this->sv
			->from("HasilPatologi AS head")
			->join("Register AS r", "head.Regno = r.Regno", "LEFT")
			->join("MasterPS AS mps", "head.MedRec = mps.MedRec", "LEFT")
			->join("HeadBilPatologi AS headbilling", "headbilling.NoTran = head.Notran", "LEFT")
			->join("TBLBangsal AS bangsal", "headbilling.KdBangsal = bangsal.KdBangsal", "LEFT")
			->join("TBLKelas AS kelas", "headbilling.KdKelas = kelas.KdKelas", "LEFT")
			->join("POLItpp AS poli", "headbilling.KdPoli = poli.KDPoli", "LEFT")
			->join("TblKategoriPsn AS kategori", "headbilling.Kategori = kategori.KdKategori", "LEFT")
			->where("headbilling.Tanggal >=", $from_date.' 00:00:00')
			->where("headbilling.Tanggal <=", $to_date.' 23:59:59');

		// Filter belum diisi
		if($filter_type == 1)
		{
			$sql = "SELECT * FROM HasilPatologi AS dh WHERE dh.NoTran=head.NoTran AND dh.KdInput != 4 AND COALESCE(CONVERT(VARCHAR, dh.Hasil), '') != ''";
			$this->sv->where("NOT EXISTS($sql)", NULL, FALSE);
		}
		// Filter belum lengkap
		elseif($filter_type == 2)
		{
			$sql1 = "SELECT * FROM HasilPatologi AS dh WHERE dh.NoTran=head.NoTran AND dh.KdInput != 4 AND COALESCE(CONVERT(VARCHAR, dh.Hasil), '') != ''";
			$sql2 = "SELECT * FROM HasilPatologi AS dh WHERE dh.NoTran=head.NoTran AND dh.KdInput != 4 AND COALESCE(CONVERT(VARCHAR, dh.Hasil), '') = ''";
			$this->sv->where("EXISTS($sql1) AND EXISTS($sql2)", NULL, FALSE);
		}
		// Filter sudah lengkap
		elseif($filter_type == 3)
		{
			$sql = "SELECT * FROM HasilPatologi AS dh WHERE dh.NoTran=head.NoTran AND dh.KdInput != 4 AND COALESCE(CONVERT(VARCHAR, dh.Hasil), '') = ''";
			$this->sv->where("NOT EXISTS($sql)", NULL, FALSE);
		}

		if(!empty($term))
		{
			$this->sv->group_start()
				->or_like('head.MedRec', $term)
				->or_like('poli.NMPoli', $term)
				->or_like('bangsal.NmBangsal', $term)
				->or_like('head.Regno', $term)
				->or_like('r.Firstname', $term)
				->or_like('head.NoLab', $term)
				->group_end();
		}
	}

	public function count_pemeriksaan_hasil($date1 = '', $date2 = '', $medrec = '')
	{
		$data = $this->sv->select("head.*, headbilling.TglHasil as hasilbil, headbilling.TotalBiaya, bangsal.NmBangsal, poli.NMPoli, kelas.NMKelas, kategori.NmKategori")->from("HasilPatologi head")
		->join("HeadBilPatologi headbilling", "headbilling.NoTran = head.Notran", "LEFT")
		->join("TBLBangsal bangsal", "headbilling.KdBangsal = bangsal.KdBangsal", "LEFT")
		->join("TBLKelas kelas", "headbilling.KdKelas = kelas.KdKelas", "LEFT")
		->join("POLItpp poli", "headbilling.KdPoli = poli.KDPoli", "LEFT")
		->join("TblKategoriPsn kategori", "headbilling.Kategori = kategori.KdKategori", "LEFT")
		->where("headbilling.Tanggal >=", $date1.' 00:00:00')
		->where("headbilling.Tanggal <=", $date2.' 23:59:59')
		->like("head.Medrec", $medrec)->get()->num_rows();

		return $data;
	}

	public function search_group_print($notran, $custom_detail = NULL)
	{
		$result = [];
		$this->sv->select('detail.KdGroup, g.NmGroup, h.Tarif')
			->from('HasilPatologi detail')
			->join('fGroupPatologi g', 'substring(detail.KdGroup, 1, 2) = g.KDGroup', 'LEFT')
			->join('fTarifPatologi h', 'h.KDDetail = detail.KDDetail', 'LEFT')
			->group_by('detail.KdGroup')->group_by('g.NmGroup')->group_by('h.Tarif')
			->where('detail.NoTran', $notran);

		if(!empty($custom_detail))
		{
			$this->sv->where_in('detail.KDDetail + \'#\' + CONVERT(VARCHAR, detail.Tanggal, 120)', $custom_detail);
		}

		$data = $this->sv->get()->result();

		foreach ($data as $d) {
			$result[] = $this->search_detail_print($d->KdGroup, $d->NmGroup, $notran, $custom_detail);
		}
		return $result;
	}

	public function search_detail_print($kdgroup, $nmgroup, $notran, $custom_detail = NULL)
	{
		/*$this->sv->select([
			'detail.*', 
		])*/
		$this->sv->select("detail.*, CONCAT('','') as Hasil, CONCAT('','') as KdInput")
		->from('HasilPatologi detail')
		->join('fPemeriksaanPatologi AS pl', 'detail.KDDetail=pl.KDDetail', 'LEFT')
		->where('detail.NoTran', $notran)
		->where('detail.KdGroup', $kdgroup)
		->order_by('detail.KDDetail ASC');

		if(!empty($custom_detail))
		{
			$this->sv->where_in('detail.KDDetail + \'#\' + CONVERT(VARCHAR, detail.Tanggal, 120)', $custom_detail);
		}

		$detail = $this->sv->get()->result();

		$parse = array(
			'kdgroup' => $kdgroup,
			'nmgroup' => $nmgroup,
			'detail' => $detail
		);
		return $parse;
	}

	public function search_pemeriksaan($kdpemeriksaan = '')
	{
		if (strlen($kdpemeriksaan) > 5) {
			$pemeriksaan = $this->sv->select('*')->from('DetailPemeriksaan')->where('KodeDetail', $kdpemeriksaan)->get()->row();
			// if (empty($pemeriksaan)) {
			// 	$pemeriksaan = $this->sv->select('*')->from('fPemeriksaanPatologi')->where('KDDetail', $kdpemeriksaan)->get()->row();
			// }
		} else {
			$pemeriksaan = $this->sv->select('*')->from('fPemeriksaanPatologi')->where('KDDetail', $kdpemeriksaan)->get()->row();
			// if (empty($pemeriksaan)) {
			// 	$pemeriksaan = $this->sv->select('*')->from('DetailPemeriksaan')->where('KodeDetail', $kdpemeriksaan)->get()->row();
			// }
		}
		return $pemeriksaan;
	}

	public function histori_pemeriksaan($medrec, $nm_pemeriksaan)
	{
		$datenow = date("Y-m-d");
		$sixmonth = date("Y-m-d", strtotime("-6 months"));
		$data = $this->sv->select('detail.*')->from('HasilPatologi detail')
		->where('detail.Medrec', $medrec)
		->where('detail.NMDetail', $nm_pemeriksaan)
		->where("CAST(detail.Tanggal AS DATE) >=", $sixmonth)
		->where("CAST(detail.Tanggal AS DATE) <=", $datenow)
		->get()->result();

		return $data;
	}

	public function api_histori_pemeriksaan_pasien($medrec, $kdmappinghistori)
	{
		$datenow = date("Y-m-d", strtotime("-1 days"));
		$sixmonth = date("Y-m-d", strtotime("-6 months"));
		$histori = $this->db->select('pemeriksaan.id_pem, pemeriksaan.nm_pem, pemeriksaan.satuan, pemeriksaan.nilai_rujukan, labhasil.tglmsk, labhasil.hasil, labhasil.norm')->from('lab_hasilpemeriksaan labhasil')
		->join('lab_pemeriksaan pemeriksaan', 'labhasil.id_pem = pemeriksaan.id_pem')
		->where('labhasil.norm', $medrec)
		->where('labhasil.id_pem', $kdmappinghistori)
		->where("labhasil.tglmsk <=", $datenow)
		->where("labhasil.tglmsk >=", $sixmonth)
		->get()->result();

		return $histori;
	}

	public function create_pemeriksaan_baru_hasil($data)
	{
		$input_detail = 0;
		$input_detail_hasil = 0;
		$tarif_satuan = $this->sv->select('tarif.KDTarif, tarif.Sarana, tarif.Pelayanan, tarif.Tarif, tarif.KDDetail, pemeriksaan.KdGroup, grouplab.NmGroup, pemeriksaan.NMDetail, pemeriksaan.NilaiNormalPria, pemeriksaan.NilaiNormalWanita, pemeriksaan.Satuan, detailpemeriksaan.KodeDetail, detailpemeriksaan.NamaDetail, detailpemeriksaan.NilaiNormalPria as detailpemeriksaanNilaiNormalPria, detailpemeriksaan.NilaiNormalWanita as detailpemeriksaanNilaiNormalWanita, detailpemeriksaan.Satuan as detailpemeriksaanSatuan')
			->from('fTarifPatologi tarif')
			->join('fPemeriksaanPatologi pemeriksaan', 'tarif.KDDetail = pemeriksaan.KDDetail')
			->join('DetailPemeriksaan detailpemeriksaan', 'tarif.KDDetail = detailpemeriksaan.KDDetail', 'LEFT')
			->join('fGroupPatologi grouplab', 'pemeriksaan.KdGroup = grouplab.KDGroup')
			->where('pemeriksaan.KdMapping', $data['kdmapping'])->limit(1)->get()->row();

		$parse['alur'] = '1';
		// var_dump($tarif_satuan);die();
		$pasien = $this->sv->select('*')->from('Register')->where('Regno', $data['Regno'])->get()->row();
		$dokter = $this->sv->select('*')->from('FtDokter')->where('KdDoc', $data['KdPengirim'])->get()->row();

		$post_detail_billing = array(
			'NoTran' => $data['notran'],
			'Tanggal' => date('Y-m-d'),
			'Regno' => $data['regno'],
			'MedRec' => $pasien->Medrec,
			'KdPemeriksaan' => $tarif_satuan->KDDetail,
			'KdTarif' => $tarif_satuan->KDTarif,
			'NmTarif' => $tarif_satuan->NMDetail,
			'Sarana' => $tarif_satuan->Sarana,
			'Pelayanan' => $tarif_satuan->Pelayanan,
			'JumlahBiaya' => $tarif_satuan->Tarif,
			'nCover' => '0',
			'Shift' => '1',
			'ValidUser' => $this->session->userdata('username').' '.date('d/m/Y H:i:s'),
			'KdDokter' => ''
		);

		$post_detail_hasil = array(
			'NoTran' => $data['notran'],
			'Tanggal' => date('Y-m-d H:i:s'),
			'NoLab' => $data['kdlab'],
			'Regno' => $data['regno'],
			'Medrec' => $pasien->Medrec,
			'KdGroup' => $tarif_satuan->KDDetail,
			'KDDetail' => $tarif_satuan->KDDetail,
			'NMDetail' => $tarif_satuan->NMDetail,
			'Satuan' => $tarif_satuan->Satuan,
			'NilaiNormal' => $pasien->KdSex == 'L' ? $tarif_satuan->NilaiNormalPria : $tarif_satuan->NilaiNormalWanita,
			'keyno' => $data['notran'].$tarif_satuan->KDDetail.'0000'
		);
		$parse['alur2'] = '2';
		// $cek_detail_billing = $this->sv->select('*')->from('DetailBilPatologi')->where('Regno', $data['Regno'])->where('KdTarif', $tarif_satuan->KDTarif)->get()->row();

		$parse['alur3'] = '3';
		$save_detail_billing = $this->sv->set($post_detail_billing)->insert('DetailBilPatologi');
		$parse['message_detail_billing'] = 'Masuk Detial Billing';
		$save_detail_hasil = $this->sv->set($post_detail_hasil)->insert('HasilPatologi');
		$parse['message_detail_hasil'] = 'Masuk Detial Hasil';
		$input_detail++;

		if ($save_detail_billing) {
			$parse['alur4'] = '4';
			// Paket Lab
			$tarif_paket = $this->sv->select('tarif.KDTarif, tarif.Sarana, tarif.Pelayanan, tarif.Tarif, tarif.KDDetail, pemeriksaan.KdGroup, grouplab.NmGroup, pemeriksaan.NMDetail, pemeriksaan.NilaiNormalPria, pemeriksaan.NilaiNormalWanita, pemeriksaan.Satuan, detailpemeriksaan.KodeDetail, detailpemeriksaan.NamaDetail, detailpemeriksaan.NilaiNormalPria as detailpemeriksaanNilaiNormalPria, detailpemeriksaan.NilaiNormalWanita as detailpemeriksaanNilaiNormalWanita, detailpemeriksaan.Satuan as detailpemeriksaanSatuan')
				->from('fTarifPatologi tarif')
				->join('fPemeriksaanPatologi pemeriksaan', 'tarif.KDDetail = pemeriksaan.KDDetail')
				->join('DetailPemeriksaan detailpemeriksaan', 'tarif.KDDetail = detailpemeriksaan.KDDetail', 'LEFT')
				->join('fGroupPatologi grouplab', 'pemeriksaan.KdGroup = grouplab.KDGroup')
				->where('tarif.KDTarif', $tarif_satuan->KDTarif)->get()->result();
			foreach ($tarif_paket as $key => $list_paket) {
				if ($list_paket->NamaDetail != '') {
					$post_detail_hasil_paket = array(
						'NoTran' => $data['notran'],
						'Tanggal' => date('Y-m-d H:i:s'),
						'Regno' => $data['regno'],
						'Medrec' => $pasien->Medrec,
						'KdGroup' => $list_paket->KdGroup,
						'KDDetail' => $list_paket->KodeDetail,
						'NMDetail' => $list_paket->NamaDetail
					);
					$save_detail_hasil_billing = $this->sv->set($post_detail_hasil_paket)->where('NoTran', $data['notran'])->update('HasilPatologi');
					$parse['message_paket'] = 'Masuk paket';
					$input_detail_hasil++;
					$parse['message'] = 'Data berhasil masuk';
				}
			}
		}

		return $parse;
	}

	public function generic_pagination($per_page = NULL, ...$params)
	{
		[$one, $caller] = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);

		if(!method_exists($this, $method = $caller['function'].'_query_scope'))
		{
			throw new Exception("Missing $method method in ".$caller['class'].' class');
		}

		extract($this->input->get(['term', 'page']));

		$page = $page ?: 1;

		$this->$method($term, ...$params);

		if(is_null($per_page)) $per_page = 50;

		$from_row = ($page - 1) * $per_page + 1;
		$to_row = $from_row + $per_page;

		$raw_query  = "WITH __result__ AS (".$this->sv->get_compiled_select().") ";
		$raw_query .= "SELECT * FROM __result__ WHERE row_number BETWEEN ? AND ?;";

		$data = $this->sv->query($raw_query, [$from_row, $to_row])->result();
		$next_page = count($data) === (1 + $per_page) ? ($page + 1) : FALSE;
		$previous_page = $page > 1 ? ($page - 1) : FALSE;

		if($next_page !== FALSE) array_pop($data);

		$this->sv->select('COUNT(0) AS count');
		$this->$method($term, ...$params);

		$count = $this->sv->get()->row('count');

		$current_page = $page;

		$limit = 10;

		$first_page = 1;
		$last_page = ceil($count / $per_page);

		$paging = [ $page ];

		$limit = $limit > $last_page ? $last_page : $limit;

		for ($i = 1; $i <= $limit && $i <= $count; $i++)
		{
			if(count($paging) < $limit && ($prev = $page - $i) >= $first_page)
			{
				array_unshift($paging, $prev);
			}

			if(count($paging) < $limit && ($next = $page + $i) <= $last_page)
			{
				array_push($paging, $next);
			}
		}

		return (Object) compact(
			'data', 'next_page', 'previous_page', 'count', 'current_page', 'paging', 'first_page', 'last_page'
		);
	}
}
