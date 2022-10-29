<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register_model extends MY_Model {

	protected $sv;
	function __construct(){
		parent::__construct();
		$this->sv = $this->load->database('server',true);
		$this->load->model("BillingPemeriksaan_model","bpm");
	}

	public function get_list_pasien($filter_options)
	{
		$this->db_interface =& $this->sv;

		extract($filter_options);

		$query ='';
		//jika yg login instansi maka list yang muncul hanya list peserta instansi nya
		if($this->session->userdata('grup') == 'INSTANSI')
		{
			$query =' AND inst.KdInstansi = '.$this->session->userdata('kdInstansi').' ';
		}

		$from = [
			'Register AS r',
			'LEFT JOIN MasterPS AS ps ON r.Medrec=ps.Medrec',
			'LEFT JOIN FPPRI AS ri ON r.Regno=ri.Regno',
			'LEFT JOIN FPulang AS fp ON ri.Regno=fp.Regno',
			'LEFT JOIN POLItpp AS pol ON r.KdPoli=pol.KdPoli',
			'LEFT JOIN TBLBangsal AS bsl ON ri.KdBangsal=bsl.KdBangsal',
			'LEFT JOIN TBLKelas AS kls ON ri.KdKelas=kls.KdKelas',
			'LEFT JOIN TblKategoriPsn AS kat ON r.Kategori=kat.KdKategori',
			'LEFT JOIN TBLUnitInstansi AS inst ON r.unitInstansi=inst.KdUnit',
			'LEFT JOIN TBLInstansi AS I ON I.KdInstansi=inst.KdInstansi',
			'where (r.KdPoli = 40)'.$query 
		];


		$select = [
			'r.Regno',
			'r.Medrec',
			'r.Firstname',
			'r.Catatan',
			'r.Regdate',
			'r.KdTuju',
			'ps.Address',
			'ps.Bod',
			'r.Kategori', 
			'kat.NmKategori',
			'r.KdPoli', 
			'pol.NmPoli',
			'ri.KdBangsal', 
			'bsl.NmBangsal',
			'ri.KdKelas', 
			'kls.NmKelas', 
			'r.unitInstansi', 
			'I.NmInstansi', 
			'inst.KdInstansi'
		];

		$select[] = "(SELECT TOP 1 NoTran FROM HeadBilPatologi WHERE r.Regno=Regno AND CAST(Tanggal AS DATE)=CAST(GETDATE() AS DATE)) AS NoTran";

		$select[] = "CASE WHEN fp.Regno IS NOT NULL THEN 1 ELSE 0 END AS SudahPulang";
		$select[] = "
			CASE
				WHEN ri.Regno IS NOT NULL THEN 'R. Inap'
				WHEN r.KdPoli='24' THEN 'IGD'
				ELSE 'R. Jalan'
			END AS Instalasi
		";

		$where = '1=1';

		if($instalasi != 4)
		{
			$where .= $this->sv->compile_binds(' AND CAST(Regdate AS DATE) BETWEEN ? AND ?', [
				$from_date->format('Y-m-d'),
				$to_date->format('Y-m-d')
			]);
		}
		

		if($instalasi == 1)
		{
			$where .= " AND Instalasi='R. Jalan' AND KdTuju='PK'";
			if(!empty($poli))
			{
				$where .= $this->sv->compile_binds(' AND KdPoli=?', [$poli]);
			}
		}
		elseif($instalasi == 2 || $instalasi == 4)
		{
			$where .= " AND Instalasi='R. Inap'";
			if(!empty($ruangan))
			{
				$where .= $this->sv->compile_binds(' AND KdBangsal=?', [$ruangan]);
			}

			if($instalasi == 4)
			{
				$where .= ' AND SudahPulang=0';
			}
		}
		elseif($instalasi == 3)
		{
			$where .= " AND Instalasi='IGD'";
		}

		if(!empty($term))
		{
			$builded_term = "LIKE '%".$this->db->escape_like_str($term)."%' ESCAPE '!'";
			$where .= " AND (Regno $builded_term
				OR Medrec $builded_term
				OR Firstname $builded_term
				OR NmPoli $builded_term
				OR NmBangsal $builded_term
				OR Address $builded_term
				OR NmInstansi $builded_term
				OR Catatan $builded_term
			)";
		}

		return $this->raw_query_pagination($select, $from, $where, $instalasi == 4 ? 'Regno DESC' : 'Regno ASC');
	}

	public function get_list_instansi($filter_options)
	{
		$this->db_interface =& $this->sv;

		extract($filter_options);

		$query ='';
		//jika yg login instansi maka list yang muncul hanya list peserta instansi nya
		if($this->session->userdata('grup') == 'INSTANSI')
		{
			$query =' AND inst.KdInstansi = '.$this->session->userdata('kdInstansi').' ';
		}

		$from = [
			'Register_instansi AS r',
			'LEFT JOIN TBLUnitInstansi AS inst ON r.unitInstansi=inst.KdUnit',
			'LEFT JOIN fPemeriksaanPatologi AS lab ON r.KdDetail_tindakan=lab.KDDetail',
			'where r.Cetak_kwitansi is null'.$query 
		];


		$select = [
			'r.*', 'inst.NmUnit', 'lab.NMDetail'
		];

		$where = '1=1';

		return $this->raw_query_pagination($select, $from, $where, 'r.No_register' ? 'No_register DESC' : 'No_register ASC');
	}

	public function get_all_list_pasien($filter_options)
	{
		$this->db_interface =& $this->sv;

		extract($filter_options);
		$query ='';
		//jika yg login instansi maka list yang muncul hanya list peserta instansi nya
		if($this->session->userdata('grup') == 'INSTANSI')
		{
			$query =' AND inst.KdInstansi = '.$this->session->userdata('kdInstansi').' ';
		}

		$from = [
			'Register AS r',
			'LEFT JOIN MasterPS AS ps ON r.Medrec=ps.Medrec',
			'LEFT JOIN FPPRI AS ri ON r.Regno=ri.Regno',
			'LEFT JOIN FPulang AS fp ON ri.Regno=fp.Regno',
			'LEFT JOIN POLItpp AS pol ON r.KdPoli=pol.KdPoli',
			'LEFT JOIN TBLBangsal AS bsl ON ri.KdBangsal=bsl.KdBangsal',
			'LEFT JOIN TBLKelas AS kls ON ri.KdKelas=kls.KdKelas',
			'LEFT JOIN TblKategoriPsn AS kat ON r.Kategori=kat.KdKategori',
			'LEFT JOIN TBLUnitInstansi AS inst ON r.unitInstansi=inst.KdUnit',
			'where r.KdPoli = 38'.$query
		];

		$select = [
			'r.Regno',
			'r.Medrec',
			'r.Firstname',
			'r.Catatan',
			'r.Regdate',
			'r.KdTuju',
			'ps.Address',
			'ps.Bod',
			'r.Kategori', 'kat.NmKategori',
			'r.KdPoli', 'pol.NmPoli',
			'ri.KdBangsal', 'bsl.NmBangsal',
			'ri.KdKelas', 'kls.NmKelas','r.unitInstansi', 'inst.KdInstansi',
		];

		$select[] = "(SELECT TOP 1 NoTran FROM HeadBilPatologi WHERE r.Regno=Regno AND CAST(Tanggal AS DATE)=CAST(GETDATE() AS DATE)) AS NoTran";

		$select[] = "CASE WHEN fp.Regno IS NOT NULL THEN 1 ELSE 0 END AS SudahPulang";
		$select[] = "
			CASE
				WHEN ri.Regno IS NOT NULL THEN 'R. Inap'
				WHEN r.KdPoli='24' THEN 'IGD'
				ELSE 'R. Jalan'
			END AS Instalasi
		";

		$where = '1=1';

		if($instalasi != 4)
		{
			$where .= $this->sv->compile_binds(' AND CAST(Regdate AS DATE) BETWEEN ? AND ?', [
				$from_date->format('Y-m-d'),
				$to_date->format('Y-m-d')
			]);
		}

		if($instalasi == 1)
		{
			$where .= " AND Instalasi='R. Jalan' AND KdTuju='PK'";
			if(!empty($poli))
			{
				$where .= $this->sv->compile_binds(' AND KdPoli=?', [$poli]);
			}
		}
		elseif($instalasi == 2 || $instalasi == 4)
		{
			$where .= " AND Instalasi='R. Inap'";
			if(!empty($ruangan))
			{
				$where .= $this->sv->compile_binds(' AND KdBangsal=?', [$ruangan]);
			}

			if($instalasi == 4)
			{
				$where .= ' AND SudahPulang=0';
			}
		}
		elseif($instalasi == 3)
		{
			$where .= " AND Instalasi='IGD'";
		}

		if(!empty($term))
		{
			$builded_term = "LIKE '%".$this->db->escape_like_str($term)."%' ESCAPE '!'";
			$where .= " AND (Regno $builded_term
				OR Medrec $builded_term
				OR Firstname $builded_term
				OR NmPoli $builded_term
				OR NmBangsal $builded_term
				OR Address $builded_term
				OR Catatan $builded_term
			)";
		}
		$this->per_page = 500;
		return $this->raw_query_pagination($select, $from, $where, $instalasi == 4 ? 'Regno DESC' : 'Regno ASC');
	}

	public function list_pasien($date1 = '', $date2 = '', $medrec = '')
	{
		$list_lab = $this->sv->select("Register.Regno, Register.Medrec, Register.Firstname, Register.Regdate, Register.Regtime, Register.KdSex, Register.Sex, Register.NomorUrut, Register.KdJaminan, TBLJaminan.NMJaminan, Register.NmRujukan, Register.NoPeserta, Register.AtasNama, Register.NmKelas, Register.KdTuju, Register.KdPoli, Register.KdKelas, TBLKelas.NMKelas, Register.KdIcd, TBLICD10.DIAGNOSA, Register.NoSep, Register.Keterangan, TBLTpengobatan.NMTuju, POLItpp.NMPoli, Register.KdDoc, FtDokter.NmDoc, Register.Kategori, TblKategoriPsn.NmKategori, Register.ValidUser, Register.Bod, Register.phone, Register.kdcob, Register.KdBangsal, TBLBangsal.NmBangsal, Register.KdCBayar, TBLcarabayar.NMCbayar, Register.Prolanis, Register.StatPeserta, Register.NmRefPeserta, Register.Catatan")->from("Register")
			->join("TBLJaminan", "Register.KdJaminan = TBLJaminan.KDJaminan", "LEFT")
			->join("TBLICD10", "Register.KdICD = TBLICD10.KDICD", "LEFT")
			->join("TBLKelas", "Register.KdKelas = TBLKelas.KdKelas", "LEFT")
			->join("TBLBangsal", "Register.KdBangsal = TBLBangsal.KdBangsal", "LEFT")
			->join("TblKategoriPsn", "Register.Kategori = TblKategoriPsn.KdKategori", "LEFT")
			->join("TBLTpengobatan", "Register.KdTuju = TBLTpengobatan.KDTuju", "LEFT")
			->join("POLItpp", "Register.KdPoli = POLItpp.KDPoli", "LEFT")
			->join("FtDokter", "Register.KdDoc = FtDokter.KdDoc", "LEFT")
			->join("TBLcarabayar", "Register.KdCBayar = TBLcarabayar.KDCbayar", "LEFT")
			->where("Register.KdTuju", "PK")
			->where("Register.Regdate >=", $date1.' 00:00:00')
			->where("Register.Regdate <=", $date2.' 23:59:59');
			$where_lab = "(Register.Medrec LIKE '%$medrec%' OR Register.Firstname LIKE '%$medrec%' OR POLItpp.NMPoli LIKE '%$medrec%' OR TBLBangsal.NmBangsal LIKE '%$medrec%' OR FtDokter.NmDoc LIKE '%$medrec%' OR Register.Regno LIKE '%$medrec%')";
        	$list_lab = $list_lab->where($where_lab)->get()->result();

		$list_ugd = $this->sv->select("Register.Regno, Register.Medrec, Register.Firstname, Register.Regdate, Register.Regtime, Register.KdSex, Register.Sex, Register.NomorUrut, Register.KdJaminan, TBLJaminan.NMJaminan, Register.NmRujukan, Register.NoPeserta, Register.AtasNama, Register.NmKelas, Register.KdTuju, Register.KdPoli, Register.KdKelas, TBLKelas.NMKelas, Register.KdIcd, TBLICD10.DIAGNOSA, Register.NoSep, Register.Keterangan, TBLTpengobatan.NMTuju, POLItpp.NMPoli, Register.KdDoc, FtDokter.NmDoc, Register.Kategori, TblKategoriPsn.NmKategori, Register.ValidUser, Register.Bod, Register.phone, Register.kdcob, Register.KdBangsal, TBLBangsal.NmBangsal, Register.KdCBayar, TBLcarabayar.NMCbayar, Register.Prolanis, Register.StatPeserta, Register.NmRefPeserta, Register.Catatan")->from("Register")
			->join("TBLJaminan", "Register.KdJaminan = TBLJaminan.KDJaminan", "LEFT")
			->join("TBLICD10", "Register.KdICD = TBLICD10.KDICD", "LEFT")
			->join("TBLKelas", "Register.KdKelas = TBLKelas.KdKelas", "LEFT")
			->join("TBLBangsal", "Register.KdBangsal = TBLBangsal.KdBangsal", "LEFT")
			->join("TblKategoriPsn", "Register.Kategori = TblKategoriPsn.KdKategori", "LEFT")
			->join("TBLTpengobatan", "Register.KdTuju = TBLTpengobatan.KDTuju", "LEFT")
			->join("POLItpp", "Register.KdPoli = POLItpp.KDPoli", "LEFT")
			->join("FtDokter", "Register.KdDoc = FtDokter.KdDoc", "LEFT")
			->join("TBLcarabayar", "Register.KdCBayar = TBLcarabayar.KDCbayar", "LEFT")
			->where("Register.KdPoli", "24")
			->where("Register.Regdate >=", $date1.' 00:00:00')
			->where("Register.Regdate <=", $date2.' 23:59:59');
			$where_ugd = "(Register.Medrec LIKE '%$medrec%' OR Register.Firstname LIKE '%$medrec%' OR POLItpp.NMPoli LIKE '%$medrec%' OR TBLBangsal.NmBangsal LIKE '%$medrec%' OR FtDokter.NmDoc LIKE '%$medrec%' OR Register.Regno LIKE '%$medrec%')";
        	$list_ugd = $list_ugd->where($where_ugd)->get()->result();

		$list_rawat_inap = $this->sv->select("ri.Regno, ri.Medrec, ri.Firstname, ri.KdKelas, TBLKelas.NMKelas, ri.KdBangsal, TBLBangsal.NmBangsal, ri.KdCBayar, TBLcarabayar.NMCbayar, ri.nosep, ri.ValidUser, TblKategoriPsn.NmKategori")->from("FPPRI ri")
			->join("TBLKelas", "ri.KdKelas = TBLKelas.KdKelas", "LEFT")
			->join("TBLBangsal", "ri.KdBangsal = TBLBangsal.KdBangsal", "LEFT")
			->join("TBLcarabayar", "ri.KdCBayar = TBLcarabayar.KDCbayar", "LEFT")
			->join("TblKategoriPsn", "ri.Kategori = TblKategoriPsn.KdKategori", "LEFT")
			->where("ri.Regdate >=", $date1.' 00:00:00')
			->where("ri.Regdate <=", $date2.' 23:59:59');
			$where_ranap = "(ri.Medrec LIKE '%$medrec%' OR ri.Firstname LIKE '%$medrec%' OR TBLBangsal.NmBangsal LIKE '%$medrec%' OR ri.Regno LIKE '%$medrec%')";
        	$list_rawat_inap = $list_rawat_inap->where($where_ranap)->get()->result();

		$parse = array(
			'lab' => $list_lab,
			'ugd' => $list_ugd,
			'rawat_inap' => $list_rawat_inap
		);
		return $parse;
	}

	public function get_pasien_by_rm($medrec)
	{
		$pasien = $this->sv->select('r.*, k.NmKategori, Register.Kunjungan')->from('MasterPS r')
					->join('TblKategoriPsn k', 'r.Kategori = k.KdKategori')
					->join('Register', 'r.Medrec = Register.Medrec', 'LEFT')
					->where('r.Medrec', $medrec)->get()->row();
		if ($pasien) {
			$parse = array(
				'status' => true,
				'data' => $pasien);
		} else {
			$parse = array(
				'status' => false,
				'data' => $pasien);
		}

		return $parse;
	}

	public function deletePeserta($regno){
		$cek = $this->sv->select('regno_instansi')->where('Regno', $regno)->get('Register')->row()->regno_instansi;
		if(!empty($cek)){
			$jumlah_peserta = $this->sv->select('jumlah_peserta')->where('No_register', $cek)->get('Register_instansi')->row()->jumlah_peserta;
			$jumlah_peserta = $jumlah_peserta - 1;
			$update = $this->sv->set('jumlah_peserta', $jumlah_peserta)->where('No_register', $cek)->update('Register_instansi');	
		}
		$delete = $this->sv->where('Regno', $regno)->delete('Register');
		$delete2 = $this->sv->where('Regno', $regno)->delete('HeadBilPatologi');
		return $delete;
	}

	public function get_pasien_by_regno($regno)
	{
		$pasien = $this->sv->select("Register.Regno, Register.Medrec, Register.Firstname, MasterPS.TglDaftar, Register.Regdate, Register.Regtime, Register.KdSex, Register.Sex, Register.Kunjungan, Register.NomorUrut, Register.nikktp, Register.NoKontrol, Register.NoRujuk, Register.KdJaminan, TBLJaminan.NMJaminan, Register.NmRujukan, Register.NoPeserta, Register.AtasNama, Register.NmKelas, Register.KdTuju, Register.KdPoli, FPPRI.KdKelas, Register.TglRujuk, TBLKelas.NMKelas, Register.KdIcd, TBLICD10.DIAGNOSA, Register.NoSep, Register.NotifSep, Register.Keterangan, TBLTpengobatan.NMTuju, POLItpp.NMPoli, Register.KdDoc, FtDokter.NmDoc, Register.Kategori, TblKategoriPsn.NmKategori, Register.ValidUser, Register.Bod, Register.phone, Register.kdcob, FPPRI.KdBangsal, TBLBangsal.NmBangsal, Register.KdCBayar, TBLcarabayar.NMCbayar, Register.Prolanis, Register.StatPeserta, Register.NmRefPeserta, Register.Catatan, fCetakSEP.Nomor, HeadBilPatologi.NoTran, HeadBilPatologi.NoLab, HeadBilPatologi.KdDokter, DokterPemeriksa.NmDoc as NmDokterPemeriksa, HeadBilPatologi.KdDoc as KdDokterPengirim, HeadBilPatologi.NmDoc as NmDokterPengirim", "LEFT")->from("Register")
			->join("FPPRI", "Register.Regno = FPPRI.Regno", "LEFT")
			->join("MasterPS", "Register.Medrec = MasterPS.Medrec", "LEFT")
			->join("TBLJaminan", "Register.KdJaminan = TBLJaminan.KDJaminan", "LEFT")
			->join("TBLICD10", "Register.KdICD = TBLICD10.KDICD", "LEFT")
			->join("TBLKelas", "FPPRI.KdKelas = TBLKelas.KdKelas", "LEFT")
			->join("TBLBangsal", "FPPRI.KdBangsal = TBLBangsal.KdBangsal", "LEFT")
			->join("TblKategoriPsn", "Register.Kategori = TblKategoriPsn.KdKategori", "LEFT")
			->join("TBLTpengobatan", "Register.KdTuju = TBLTpengobatan.KDTuju", "LEFT")
			->join("POLItpp", "Register.KdPoli = POLItpp.KDPoli", "LEFT")
			->join("FtDokter", "Register.KdDoc = FtDokter.KdDoc", "LEFT")
			->join("TBLcarabayar", "Register.KdCBayar = TBLcarabayar.KDCbayar", "LEFT")
			->join("fCetakSEP", "Register.Regno = fCetakSEP.Regno", "LEFT")
			->join("HeadBilPatologi", "Register.Regno = HeadBilPatologi.Regno", "LEFT")
			->join("FtDokter DokterPemeriksa", "HeadBilPatologi.KdDokter = DokterPemeriksa.KdDoc", "LEFT")
			->where("Register.Regno", $regno)->get()->row();
		if (!empty($pasien)) {
			if ($pasien->NoLab == '') {
				if ($pasien->KdBangsal != '') {
					$notran = $this->bpm->create_new_no('RI');
				} elseif ($pasien->KdPoli == '24') {
					$notran = $this->bpm->create_new_no('UGD');
				} else {
					$notran = $this->bpm->create_new_no('RJ');
				}
			}
			$parse = array(
				'data' => $pasien,
				'NomorPatologi' => $notran['NomorLab'] ?? $pasien->NoLab,
				'NoTransaksi' => $notran['NomorTransaksi'] ?? $pasien->NoTran,
				'status' => true
			);
		} else {
			$parse = array(
				'data' => [],
				'status' => false
			);
		}
		return $parse;
	}

	public function get_detail_by_regno($regno){
		$pasien = $this->sv->select('r.*, b.NmUnit')->from('Register_instansi r')
					->join('TBLUnitInstansi b', 'r.unitInstansi = b.KdUnit', 'LEFT')
					->where('r.No_register', $regno)->get()->row();
		return $pasien;
	}

	public function update_kategori($data)
	{
		$value = array(
			'Kategori' => $data['Kategori'],
			'NmUnit' => $data['NmUnit'],
			'GroupUnit' => $data['GroupUnit'],
			'AskesNo' => $data['AskesNo']);
		$update = $this->sv->set($value)->where('Medrec', $data['Medrec'])->update('MasterPS');
		if ($update) {
			$parse = array(
				'status' => true,
				'message' => 'Berhasil diupdate');
		} else {
			$parse = array(
				'status' => false,
				'message' => 'Gagal terupdate');
		}

		return $parse;
	}

	public function post_new($data)
	{
		if (strlen($data['Regno']) == 0 || $data['Regno'] == '') {
			$no_regno = $this->sv->select('*')->get('fregno')->row();
			$new_regno = $no_regno->NREGNO + 1;
			$value = array(
				'NREGNO' => $new_regno
			);
			$update = $this->sv->set($value)->where('NREGNO', $no_regno->NREGNO)->update('fregno');

			if (strlen($new_regno) == 1) {
				$new_regno = '0000000'.$new_regno;
			} elseif (strlen($new_regno) == 2) {
				$new_regno = '000000'.$new_regno;
			} elseif (strlen($new_regno) == 3) {
				$new_regno = '00000'.$new_regno;
			} elseif (strlen($new_regno) == 4) {
				$new_regno = '0000'.$new_regno;
			} elseif (strlen($new_regno) == 5) {
				$new_regno = '000'.$new_regno;
			} elseif (strlen($new_regno) == 6) {
				$new_regno = '00'.$new_regno;
			} elseif (strlen($new_regno) == 7) {
				$new_regno = '0'.$new_regno;
			}

			$check_nomor_lab = $this->sv->select('*')->from('Register')
							->where('KdTuju', 'PK')
							->where('StatusReg', '3')
							->where('Regdate >=', $data['Regdate'].' 00:00:00')
							->where('Regdate <=', $data['Regdate'].' 23:59:59')
							->order_by('NomorUrut', 'DESC')->get()->row();
			if (empty($check_nomor_lab)) {
				$nomor_urut = '1';
			} else {
				$nomor_urut = $check_nomor_lab->NomorUrut + 1;
			}

			$date = $data['Regdate'].' '.$data['Regtime'];
			$value_register = array(
				'regno' => $new_regno,
				'medrec' => $data['Medrec'],
				'firstname' => $data['Firstname'],
				'regdate' => $data['Regdate'],
				'regtime' => $date,
				'kdcbayar' => $data['KdCbayar'],
				'kdjaminan' => $data['Penjamin'],
				'kdperusahaan' => '',
				'nopeserta' => $data['noKartu'],
				'kdtuju' => 'PK',
				'kdpoli' => $data['KdPoli'],
				'kdbangsal' => '',
				'kdkelas' => '',
				'nottidur' => '',
				'kddoc' => $data['DocRS'],
				'kunjungan' => $data['Medrec'] == '' ? 'Lama' : 'Baru',
				'validuser' => $this->session->userdata('username').' '.date('d-m-Y H:i:s'),
				'sex' => $data['KdSex'] == 'L' ? 'Laki-laki' : 'Perempuan',
				'umurthn' => $data['UmurThn'],
				'umurbln' => $data['UmurBln'],
				'umurhari' => $data['UmurHari'],
				'bod' => $data['Bod'],
				'nomorurut' => $nomor_urut,
				'statusreg' => '3',
				'kategori' => $data['KategoriPasien'],
				'nosep' => $data['NoSep'],
				'kdicd' => $data['DiagAw'],
				'kdsex' => $data['KdSex'],
				'groupunit' => $data['GroupUnit'],
				'kdicdbpjs' => $data['DiagAw'],
				'bodbpjs' => $data['Bod'],
				'pisat' => $data['pisat'],
				'keterangan' => '',
				'catatan' => $data['catatan'],
				'tglrujuk' => $data['RegRujuk'],
				'nokontrol' => $data['nokontrol'],
				'norujuk' => $data['NoRujuk'],
				'kdrujukan' => $data['Ppk'],
				'nmrujukan' => $data['noPpk'],
				'kdrefpeserta' => $data['kodePeserta'],
				'nmrefpeserta' => $data['Peserta'],
				'nmkelas' => $data['JatKelas'],
				'notifsep' => $data['NotifSep'],
				'kdkasus' => '',
				'lokasikasus' => '',
				'kddpjp' => $data['KdDPJP'],
				'nikktp' => $data['NoIden'],
				'statpeserta' => $data['statusPeserta'],
				'kdstatpeserta' => '0',
				'perjanjian' => '',
				'asalrujuk' => $data['Faskes'],
				'phone' => $data['Notelp'],
				'kdcob' => $data['Cob'],
				'prolanis' => $data['Prolanis'],
				'idregold' => '',
				'kewarganegaraan' => $data['kewarganegaraan'],
				'nmcob' => '',
				'kdjaminanbpjs' => ''
			);

			$insert_register = $this->sv->insert('Register', $value_register);

			if ($insert_register) {
				$parse = array(
					'NomorUrut' => $nomor_urut,
					'Regno' => $new_regno,
					'Firstname' => $data['Firstname'],
					'NoSep' => $data['NoSep'],
					'message' => 'Berhasil menambahkan data!'
				);
			}
		} else {
			$check_reg_pasien = $this->sv->select('*')->from('Register')->where('Regno', $data['Regno'])->get()->row();

			$date = $data['Regdate'].' '.$data['Regtime'];
			$value_register = array(
				'regno' => $data['Regno'],
				'medrec' => $data['Medrec'],
				'firstname' => $data['Firstname'],
				'regdate' => $data['Regdate'],
				'regtime' => $date,
				'kdcbayar' => $data['KdCbayar'],
				'kdjaminan' => $data['Penjamin'],
				'kdperusahaan' => '',
				'nopeserta' => $data['noKartu'],
				'kdtuju' => 'PK',
				'kdpoli' => $data['KdPoli'],
				'kdbangsal' => '',
				'kdkelas' => '',
				'nottidur' => '',
				'kddoc' => $data['DocRS'],
				'kunjungan' => $data['Medrec'] == '' ? 'Lama' : 'Baru',
				'validuser' => $this->session->userdata('username').' '.date('d-m-Y H:i:s'),
				'sex' => $data['KdSex'] == 'L' ? 'Laki-laki' : 'Perempuan',
				'umurthn' => $data['UmurThn'],
				'umurbln' => $data['UmurBln'],
				'umurhari' => $data['UmurHari'],
				'bod' => $data['Bod'],
				'nomorurut' => $data['NomorUrut'],
				'statusreg' => '3',
				'kategori' => $data['KategoriPasien'],
				'nosep' => $data['NoSep'],
				'kdicd' => $data['DiagAw'],
				'kdsex' => $data['KdSex'],
				'groupunit' => $data['GroupUnit'],
				'kdicdbpjs' => $data['DiagAw'],
				'bodbpjs' => $data['Bod'],
				'pisat' => $data['pisat'],
				'keterangan' => '',
				'catatan' => $data['catatan'],
				'tglrujuk' => $data['RegRujuk'],
				'nokontrol' => $data['nokontrol'],
				'norujuk' => $data['NoRujuk'],
				'kdrujukan' => $data['Ppk'],
				'nmrujukan' => $data['noPpk'],
				'kdrefpeserta' => $data['kodePeserta'],
				'nmrefpeserta' => $data['Peserta'],
				'nmkelas' => $data['JatKelas'],
				'notifsep' => $data['NotifSep'],
				'unitInstansi' => $data['unitInstansi'],
				'kdkasus' => '',
				'lokasikasus' => '',
				'kddpjp' => $data['KdDPJP'],
				'nikktp' => $data['NoIden'],
				'statpeserta' => $data['statusPeserta'],
				'kdstatpeserta' => '0',
				'perjanjian' => '',
				'asalrujuk' => $data['Faskes'],
				'phone' => $data['Notelp'],
				'kdcob' => $data['Cob'],
				'prolanis' => $data['Prolanis'],
				'kewarganegaraan' => $data['kewarganegaraan'],
				'idregold' => '',
				'nmcob' => '',
				'kdjaminanbpjs' => ''
			);

			$updated = $this->sv->set($value_register)->where('Regno', $data['Regno'])->update('Register');
			if ($updated) {
				$parse = array(
					'NomorUrut' => $check_reg_pasien->NomorUrut,
					'Regno' => $check_reg_pasien->Regno,
					'Firstname' => $check_reg_pasien->Firstname,
					'NoSep' => $check_reg_pasien->NoSep,
					'message' => 'Berhasil merubah data!'
				);
			}
		}

		return $parse;
	}
	public function post_instansi($data)
	{
		if (strlen($data['Regno']) == 0 || $data['Regno'] == '') {
			$no_regno = $this->sv->select('*')->get('fregno')->row();
			$new_regno = $no_regno->NREGNO + 1;
			$value = array(
				'NREGNO' => $new_regno
			);
			$update = $this->sv->set($value)->where('NREGNO', $no_regno->NREGNO)->update('fregno');

			if (strlen($new_regno) == 1) {
				$new_regno = '0000000'.$new_regno;
			} elseif (strlen($new_regno) == 2) {
				$new_regno = '000000'.$new_regno;
			} elseif (strlen($new_regno) == 3) {
				$new_regno = '00000'.$new_regno;
			} elseif (strlen($new_regno) == 4) {
				$new_regno = '0000'.$new_regno;
			} elseif (strlen($new_regno) == 5) {
				$new_regno = '000'.$new_regno;
			} elseif (strlen($new_regno) == 6) {
				$new_regno = '00'.$new_regno;
			} elseif (strlen($new_regno) == 7) {
				$new_regno = '0'.$new_regno;
			}

			$check_nomor_lab = $this->sv->select('*')->from('Register_instansi')
							->where('KdTuju', 'PK')
							->where('Regdate >=', $data['Regdate'].' 00:00:00')
							->where('Regdate <=', $data['Regdate'].' 23:59:59')
							->order_by('NomorUrut', 'DESC')->get()->row();
			if (empty($check_nomor_lab)) {
				$nomor_urut = '1';
			} else {
				$nomor_urut = $check_nomor_lab->NomorUrut + 1;
			}

			$NmInstansi = $this->sv->select('NmInstansi')->from('TBLInstansi')
							->where('KdInstansi', $data['instansi'])->get()->row()->NmInstansi;


			$datess = $data['Regdate'];
			$regno_instansi = $new_regno;
			$value_register = array(
				'No_register' => $new_regno,
				'Nama_perusahaan' => $NmInstansi,
				'KdInstansi' => $data['instansi'],
				'Regdate' => $data['Regdate'],
				'kdtuju' => 'PK',
				'kdpoli' => 38,
				'Diskon_instansi' => isset($data['diskon_instansi']) ? $data['diskon_instansi'] : 0,
				'Tipe_diskon' => isset($data['tipe_diskon']) ? $data['tipe_diskon'] : 0,
				'KdDetail_tindakan' => $data['tindakan'],
				'validuser' => $this->session->userdata('username').' '.date('d-m-Y H:i:s'),
				'NomorUrut' => $nomor_urut,
				'jumlah_peserta' => $data['jumlah_peserta'],
				'unitInstansi' => isset($data['unit']) ? $data['unit'] : ''
			);

			$insert_register = $this->sv->insert('Register_instansi', $value_register);

			for ($i=0; $i < sizeof($data['nama_peserta']); $i++) { 
				  $no_regno = $this->sv->select('*')->get('fregno')->row();
				  $new_regno = $no_regno->NREGNO + 1;
				  $value = array(
				    'NREGNO' => $new_regno
				  );
				  $update = $this->sv->set($value)->where('NREGNO', $no_regno->NREGNO)->update('fregno');

				  if (strlen($new_regno) == 1) {
				    $new_regno = '0000000'.$new_regno;
				  } elseif (strlen($new_regno) == 2) {
				    $new_regno = '000000'.$new_regno;
				  } elseif (strlen($new_regno) == 3) {
				    $new_regno = '00000'.$new_regno;
				  } elseif (strlen($new_regno) == 4) {
				    $new_regno = '0000'.$new_regno;
				  } elseif (strlen($new_regno) == 5) {
				    $new_regno = '000'.$new_regno;
				  } elseif (strlen($new_regno) == 6) {
				    $new_regno = '00'.$new_regno;
				  } elseif (strlen($new_regno) == 7) {
				    $new_regno = '0'.$new_regno;
				  }
				  
				   $date = new DateTime($data['tglLahir_peserta'][$i]);
				   $now = new DateTime();
				   $interval = $now->diff($date);

				   if ($data['jenis_kelamin'][$i] == 'Perempuan') {
				    	$sex = 'P';
				    }else{
				    	$sex = 'L';
				    }

				  $value_daftar = array(
				    'regno' => $new_regno,
				    'medrec' => '',
				    'firstname' => $data['nama_peserta'][$i],
				    'regdate' => $data['Regdate'],
				    'regtime' => date('Y-m-d H:i:s'),
				    'kdtuju' => 'PK',
				    'kdpoli' => 38,
				    'KdCbayar' => '01',
				    'Catatan' => 'PATOLOGI',
				    'nikktp' => $data['nik_peserta'][$i],
				    'Phone' => $data['no_telp'][$i],
				    'idregold' => 0,
				    'AsalRujuk' => 1,
				    'Kategori' => 1,
				    'kunjungan' => 'Baru',
				    'validuser' => $this->session->userdata('username').' '.date('d-m-Y H:i:s'),
				    'sex' => $data['jenis_kelamin'][$i],
				    'KdSex' => $sex,
				    'umurthn' => $interval->y,
				    'umurbln' => $interval->m,
				    'umurhari' => $interval->i,
				    'bod' => date('Y-m-d', strtotime($data['tglLahir_peserta'][$i])),
				    'nomorurut' => $nomor_urut,
				    'statusreg' => '3',
				    'unitInstansi' => isset($data['unit']) ? $data['unit'] : '',
				    'kdstatpeserta' => '0',
				    'regno_instansi' => $regno_instansi
				  );

				$insert_daftar = $this->sv->insert('Register', $value_daftar);
				$headbil = array(
					'no_tran' =>'' ,
					'regno' => $new_regno ,
					'dok_pengirim' =>'' ,
					'dok_pemeriksa' =>'' ,
					'verif' =>'' ,
					'setujui' =>'' ,
					'jenis_sampel' =>'' ,
					'tgl_sampel' =>'' ,
					'tgl_selesai' =>null,
					'jam_selesai' =>null,
					'tgl_transaksi' =>date('Y-m-d H:i:s'),
					'jam_transaksi' =>date('Y-m-d H:i:s') ,
					'status' => '',
					'jenis_pemeriksaan' => '' 
				);
				$no_tran = $this->simpan_head_billing($headbil);
  			    $params=array(
				  	'no_tran' => $no_tran ,'kode_tindakan' => $data['tindakan']);
					$simpan_tindakan = $this->tambah_detail_billing($params);
			}
				

			if ($insert_register) {
				$parse = array(
					'NomorUrut' => $nomor_urut,
					'Regno' => $new_regno,
					'tindakan' => $simpan_tindakan,
					'Firstname' => $NmInstansi,
					'message' => 'Berhasil menambahkan data!'
				);
			}
		} else {
			$check_reg_pasien = $this->sv->select('*')->from('Register')->where('Regno', $data['Regno'])->get()->row();

			$date = $data['Regdate'].' '.$data['Regtime'];
			$value_register = array(
				'firstname' => $data['Firstname'],
				'validuser' => $this->session->userdata('username').' '.date('d-m-Y H:i:s'),
				'sex' => $data['KdSex'] == 'L' ? 'Laki-laki' : 'Perempuan',
				'umurthn' => $data['UmurThn'],
				'umurbln' => $data['UmurBln'],
				'umurhari' => $data['UmurHari'],
				'bod' => $data['Bod'],
				'nomorurut' => $data['NomorUrut'],
				'kdsex' => $data['KdSex'],
				'keterangan' => '',
				'catatan' => $data['catatan'],
				'nikktp' => $data['NoIden'],
				'phone' => $data['Notelp'],
			);

			$updated = $this->sv->set($value_register)->where('Regno', $data['Regno'])->update('Register');
			if ($updated) {
				$parse = array(
					'NomorUrut' => $check_reg_pasien->NomorUrut,
					'Regno' => $check_reg_pasien->Regno,
					'Firstname' => $check_reg_pasien->Firstname,
					'NoSep' => $check_reg_pasien->NoSep,
					'message' => 'Berhasil merubah data!'
				);
			}
		}

		return $parse;
	}

	public function update_instansi($data){
		$value = array(
				'Tipe_diskon' => $data['tipe_diskon'],
				'Diskon_instansi' => $data['diskon_instansi']
			);
		$update = $this->sv->set($value)->where('No_register', $data['Regno'])->update('Register_instansi');
		return $update;
	}

	public function tambah_detail_billing($params)
	{
		extract($params);

		$head = $this->sv
			->select(['Regno', 'MedRec', 'KdDokter'])
			->where('NoTran', $no_tran)
			->get('HeadBilPatologi')->row_array();

		if(empty($head)) return FALSE;
		$rajal = 'rj';

		$register = $this->sv->where('r.Regno', $head['Regno'])
			->from('Register AS r')
			->join('FPPRI AS ri', 'r.Regno=ri.Regno', 'LEFT')
			->select(['r.Regno', 'ri.KdBangsal', 'ri.KdKelas', 'r.KdSex'])
			->get()->row();

		$this->sv
			->select([
				't.KdTarif',
				'p.NMDetail AS NmTarif',
				't.KDDetail AS KdPemeriksaan',
				't.Sarana',
				't.Pelayanan',
				't.Tarif AS JumlahBiaya'
			])
			->where('t.KDDetail', $kode_tindakan)
			->from('fTarifPatologi AS t')
			->join('fPemeriksaanPatologi AS p', 't.KDDetail=p.KDDetail');
		$this->sv->where('t.KdKelas ', $rajal );

		if(!empty($register->KdKelas))
		{
			$this->sv->where('t.KdKelas', $register->KdKelas);
		}

		$detail_tarif = $this->sv->limit(1)->get()->row_array();
		// echo '<pre>'; print_r($detail_tarif); exit();

		if(empty($detail_tarif)) return FALSE;

		$data = array_merge($head, $detail_tarif, [
			'NoTran'        => $no_tran,
			'Tanggal'       => date('Y-m-d H:i:s'),
			'Shift'         => $this->session->userdata('shift'),
			'ValidUser'     => $this->session->userdata('username').' '.date('d/m/Y H:i:s'),
			'TotalBiaya'    => $detail_tarif['Sarana'] + $detail_tarif['Pelayanan'] + $detail_tarif['JumlahBiaya'],
			'is_posted'     => 0,
		]);

		$this->sv->trans_start();

		$detail_exists = $this->sv
			->select('1 AS exists')
			->where('NoTran', $no_tran)
			->where('KdPemeriksaan', $kode_tindakan)
			->limit(1)
			->get('DetailBilPatologi')
			->row('exists');

		if($detail_exists) return FALSE;

		$this->sv->insert('DetailBilPatologi', $data);

		$no_lab = $this->sv
			->select('NoLab')
			->where('NoTran', $no_tran)
			->get('HeadBilPatologi')
			->row('NoLab');

		$this->sv
			->where('KDDetail', $kode_tindakan)
			->select(['KdGroup', 'KDDetail', 'NMDetail', 'Satuan', 'KdInput']);

		if($register->KdSex == 'L')
		{
			$this->sv->select($t_select = ['NNAwalPria AS nhasila', 'NNAkhirPria AS nhasilb', 'NilaiNormalPria AS NilaiNormal']);
		}
		else
		{
			$this->sv->select($t_select = ['NNAwalWanita AS nhasila', 'NNAkhirWanita AS nhasilb', 'NilaiNormalWanita AS NilaiNormal']);
		}

		$pemeriksaan = $this->sv->get('fPemeriksaanPatologi')->row_array();

		$this->sv
			->where('KDDetail', $kode_tindakan)
			->select([
				"'".$pemeriksaan['KdGroup']."' AS KdGroup",
				'KodeDetail AS KDDetail',
				'NamaDetail AS NMDetail',
				'Satuan',
				'KdInput'
			])
			->select($t_select);

		$pemeriksaan_list = array_merge([$pemeriksaan], $this->sv->get('DetailPemeriksaan')->result_array());

		foreach ($pemeriksaan_list as $item)
		{
			$data_hasil = array_merge($item, [
				'NoTran'    => $no_tran,
				'Tanggal'   => date('Y-m-d H:i:s'),
				'NoLab'     => $no_lab,
				'Regno'     => $head['Regno'],
				'Medrec'    => $head['MedRec'],
				'keyno'     => $no_tran.$item['KDDetail'].date('His'),
				'ValidUser' => $data['ValidUser'],
			]);

			$this->sv->insert('HasilPatologi', $data_hasil);
		}

		$new_total = $this->sv->query("SELECT SUM(JumlahBiaya) AS Total FROM DetailBilPatologi WHERE NoTran=?", [$no_tran])->row('Total');

		$this->sv->where('NoTran', $no_tran)->update('HeadBilPatologi', ['Jumlah' => $new_total, 'TotalBiaya' => $new_total]);

		$success = $this->sv->trans_complete();

		$list_detail = $this->sv
			->select([
				'd.NoTran',
				'd.Tanggal',
				'd.KdPemeriksaan',
				'd.KdTarif',
				'd.NmTarif',
				'd.Sarana',
				'd.Pelayanan',
				'd.JumlahBiaya',
			])
			->from('DetailBilPatologi AS d')
			->where('d.NoTran', $no_tran)
			->where('d.KdPemeriksaan', $kode_tindakan)
			->get()->result();

		return $success ? TRUE : FALSE;
	}

	public function simpan_head_billing($params)
	{
		extract($params);

		$register = $this->sv->where('r.Regno', $regno)
			->where('r.Deleted', NULL)
			->from('Register AS r')
			->join('FPPRI AS fp', 'r.Regno=fp.Regno', 'LEFT')
			->join('MasterPS AS ps', 'r.MedRec=ps.MedRec', 'LEFT')
			->join('FtDokter AS dr', 'r.KdDoc=dr.KdDoc', 'LEFT')
			->select([
				'r.Regno',
				'r.RegDate',
				'r.MedRec',
				'r.Firstname',
				'r.Sex',
				'fp.KdBangsal',
				'fp.KdKelas',
				'r.KdPoli',
				'r.KdCbayar',
				'r.KdJaminan',
				'r.Kategori',
				'r.Catatan',
				'r.Bod',
				'r.KdDoc',
				'dr.NmDoc',
			])
			->get()->row_array();

		$doc = $this->sv->select(['KdDoc', 'NmDoc'])->where('KdDoc', $dok_pengirim)->get('FtDokter')->row_array() ?? [];

		$usia = date_diff(date_create($tgl_transaksi), date_create($register['Bod']));
		unset($register['Bod']);

		$properties = array_merge($register, $doc, [
			'NoTran'     => $no_tran,
			'Tanggal'    => $tgl_transaksi,
			'Jam'        => date('Y-m-d H:i:s', strtotime($jam_transaksi)),
			'TglSelesai' => empty($tgl_selesai) ? $tgl_selesai : NULL,
			'JamSelesai' => empty($jam_selesai) ? date('Y-m-d H:i:s', strtotime($jam_transaksi)) : NULL,
			'UmurThn'    => $usia->y,
			'UmurBln'    => $usia->m,
			'UmurHari'   => $usia->d,
			'Shift'      => $this->session->userdata('shift'),
			'ValidUser'  => $this->session->userdata('username').' '.date('d/m/Y H:i:s'),
			'nStatus'    => $status,
			'nJenis'     => $jenis_pemeriksaan,
			'KdDokter'   => $dok_pemeriksa,
			'Verifikasi'   => $verif,
			'Setujui'   => $setujui,
			'AsalSampel'   => $jenis_sampel,
			'TglSampel'    => $tgl_sampel,
			'Tanda'      => 0,
		]);

		$this->sv->trans_start();

		
		$no = 'MLAB'.date('my', strtotime($tgl_transaksi));

		if(empty($no_tran))
		{
			// $last_no_tran = $this->sv->where('NoTran like', '%'.$no.'____%')
			// 	->limit(1)
			// 	->order_by('NoTran', 'DESC')
			// 	->get('HeadBilPatologi')->row('NoTran');


			// $properties['NoTran'] = 'LAB'
			// 	.date('my', strtotime($tgl_transaksi))
			// 	.str_pad(1 + intval(substr($last_no_tran, 7)), 4, '0', STR_PAD_LEFT);

			$date2 = date('my', strtotime($tgl_transaksi));
			$defaultNomorTransaksi = 1;
			$notransaksi = 'LAB'.$date2;

			$cek_nomor_transaksi = $this->sv->select('*')->from('NoTransaksi')->where('NTCode', $notransaksi)->get()->row();
			// echo '<pre>'; print_r($cek_nomor_transaksi); die();

			if (!empty($cek_nomor_transaksi)) {
				$defaultNomorTransaksi = $cek_nomor_transaksi->Nomor+1;
				$this->sv->set('Nomor', $defaultNomorTransaksi)->where('NTCode', $notransaksi)->update('NoTransaksi');
			} else {
				$this->sv->set('NTCode', $notransaksi)->set('Nomor', $defaultNomorTransaksi)->set('NoBukti', '1')->set('NOJurnal', '1')->insert('NoTransaksi');
			}

			if (strlen($defaultNomorTransaksi) == 1) {
				$defaultNomorTransaksi = '00'.$defaultNomorTransaksi;
			} elseif (strlen($defaultNomorTransaksi) == 2) {
				$defaultNomorTransaksi = '0'.$defaultNomorTransaksi;
			} elseif (strlen($defaultNomorTransaksi) == 3) {
				$defaultNomorTransaksi = $defaultNomorTransaksi;
			}

			$properties['NoTran'] = $notransaksi.$defaultNomorTransaksi;

			// $kode_tuju = !empty($register['KdBangsal']) ? 'RI' : (
			// 	$register['KdPoli'] == '24' ? 'IGD' : (
			// 		$register['KdPoli'] == '21' ? 'MCU' : (
			// 			$register['KdCbayar'] == '01' ? 'PS' : 'RJ'
			// 		)
			// 	)
			// );
			$kode_tuju = 'LM';
			$no_laborat = $kode_tuju.date('my');

			// echo '<pre>'; print_r($last_no_tran); die();
			$nomor_lab = $this->sv->where('NoLaborat', $no_laborat)->get('NomorPatologi')->row('Nomor');
			if(empty($nomor_lab))
			{
				$this->sv->insert('NomorPatologi', ['Nomor' => 1, 'NoLaborat' => $no_laborat]);
			}
			else
			{
				$this->sv->where('NoLaborat', $no_laborat)->update('NomorPatologi', ['Nomor' => $nomor_lab + 1]);
			}

			$properties['NoLab'] = $kode_tuju.str_pad(intval($nomor_lab) + 1, 4, '0', STR_PAD_LEFT);

			$this->sv->insert('HeadBilPatologi', array_merge($properties, [
				'Jumlah'     => 0,
				'TotalBiaya' => 0,
			]));
		}
		else
		{
			$this->sv->where('NoTran', $no_tran)->update('HeadBilPatologi', $properties);
		}

		$head_hasil_exists = $this->sv->select('1 AS exists')->where('NoTran', $properties['NoTran'])->get('HasilPatologi')->row('exists');

		if(!$head_hasil_exists)
		{
			$this->sv->insert('HasilPatologi', [
				'Notran'     => $properties['NoTran'],
				'Regno'      => $properties['Regno'],
				'RegDate'    => $properties['RegDate'],
				'MedRec'     => $properties['MedRec'],
				'Firstname'  => $properties['Firstname'],
				'Sex'        => $properties['Sex'],
				'Umurthn'    => $properties['UmurThn'].'-'.$properties['UmurBln'].'-'.$properties['UmurHari'],

				'ValidUser'  => $properties['ValidUser'],
				'KdDoc'      => $properties['KdDokter']
			]);
		}
		// TODO: VALIDASI DETAIL

		$result = $this->sv->trans_complete();

		return $properties['NoTran'];
	}

	public function post($data)
	{
		$exec = $this->stpnet_AddNewRegistrasiBPJS_REGxhos(
		 	$data['Regno'],
			$data['Medrec'],
			$data['Firstname'],
			$data['Regdate'],
			$data['Regtime'],
			$data['KdCbayar'],
			$data['Penjamin'],
			'',
			$data['noKartu'],
			$data['KdTuju'],
			$data['KdPoli'],
			'',
			'',
			'',
			$data['DocRS'],
			$data['Kunjungan'],
			'',
			'',
			$data['UmurThn'],
			$data['UmurBln'],
			$data['UmurHari'],
			$data['Bod'],
			$data['NomorUrut'],
			'',
			$data['KategoriPasien'],
			$data['NoSep'],
			$data['DiagAw'],
			$data['KdSex'],
			$data['GroupUnit'],
			$data['DiagAw'],
			$data['Bod'],
			$data['pisat'],
			'',
			$data['catatan'],
			$data['RegRujuk'],
			$data['nokontrol'],
			$data['NoRujuk'],
			$data['Ppk'],
			$data['noPpk'],
			$data['kodePeserta'],
			$data['Peserta'],
			$data['JatKelas'],
			$data['NotifSep'],
			'',
			'',
			$data['KdDPJP'],
			$data['NoIden'],
			$data['statusPeserta'],
			$data['statusPeserta'],
			'',
			$data['Faskes'],
			$data['Notelp'],
			$data['Cob'],
			$data['Prolanis'],
			$data['idregold'],
			'',
			$data['Penjamin'],
			'',
			''
		);
		$data_pasien = $this->sv->select('Regno, Firstname, NomorUrut, NoSep')->from('Register')->where('Medrec', $data['Medrec'])->where('KdPoli', $data['KdPoli'])->where('Regdate', $data['Regdate'])->get()->row();

		if (!empty($data_pasien)) {

			$parse = array(
				'NomorUrut' => $data_pasien->NomorUrut,
				'Regno' => $data_pasien->Regno,
				'Firstname' => $data_pasien->Firstname,
				'NoSep' => $data_pasien->NoSep,
				'message' => 'Berhasil menambahkan data!'
			);
		}
		return $parse;
	}

	public function update_registrasi($regno)
	{
		$value = array(
			'KdTuju' => 'PK',
			'StatusReg' => '3'
		);
		$update = $this->sv->set($value)->where('Regno', $regno)->update('Register');
		return $update;
	}

	public function stpnet_AddNewRegistrasiBPJS_REGxhos($regno = '', $medrec = '', $firstname = '', $regdate = '', $regtime = '', $kdcbayar = '', $kdjaminan = '', $kdperusahaan = '', $nopeserta = '', $kdtuju = '', $kdpoli = '', $kdbangsal = '', $kdkelas = '', $nottidur = '', $kddoc = '', $kunjungan = '', $validuser = '', $sex = '', $umurthn = '', $umurbln = '', $umurhari = '', $bod = '', $nomorurut = '', $statusreg = '', $kategori = '', $nosep = '', $kdicd = '', $kdsex = '', $groupunit = '', $kdicdbpjs = '', $bodbpjs = '', $pisat = '', $keterangan = '', $catatan = '', $tglrujuk = '', $nokontrol = '', $norujuk = '', $kdrujukan = '', $nmrujukan = '', $kdrefpeserta = '', $nmrefpeserta = '', $nmkelas = '', $notifsep = '', $kdkasus = '', $lokasikasus = '', $kddpjp = '', $nikktp = '', $statpeserta = '', $kdstatpeserta = '', $perjanjian = '', $asalrujuk = '', $phone = '', $kdcob = '', $prolanis = '', $idregold = '', $nmcob = '', $kdjaminanbpjs = '', $regnumber = '', $sequalNum = '')
	{

		$sp = "spwe_AddNewRegistrasiBPJS_REGxhos @regno = ?, @medrec = ?, @firstname = ?, @regdate = ?, @regtime = ?, @kdcbayar = ?, @kdjaminan = ?, @kdperusahaan = ?, @nopeserta = ?, @kdtuju = ?, @kdpoli = ?, @kdbangsal = ?, @kdkelas = ?, @nottidur = ?, @kddoc = ?, @kunjungan = ?, @validuser = ?, @sex = ?, @umurthn = ?, @umurbln = ?, @umurhari = ?, @bod = ?, @nomorurut = ?, @statusreg = ?, @kategori = ?, @nosep = ?, @kdicd = ?, @kdsex = ?, @groupunit = ?, @kdicdbpjs = ?, @bodbpjs = ?, @pisat = ?, @keterangan = ?, @catatan = ?, @tglrujuk = ?, @nokontrol = ?, @norujuk = ?, @kdrujukan = ?, @nmrujukan = ?, @kdrefpeserta = ?, @nmrefpeserta = ?, @nmkelas = ?, @notifsep = ?, @kdkasus = ?, @lokasikasus = ?, @kddpjp = ?, @nikktp = ?, @statpeserta = ?, @kdstatpeserta = ?, @perjanjian = ?, @asalrujuk = ?, @phone = ?, @kdcob = ?, @prolanis = ?, @idregold = ?, @nmcob = ?, @kdjaminanbpjs = ?, @regnumber = ?, @sequalNum = ?";

		// $sex = $sex == 'L' ? 'Laki-laki' : 'Perempuan';
		$date = $regdate.' '.$regtime;
		$params = array(
			'regno' => $regno,
			'medrec' => $medrec,
			'firstname' => $firstname,
			'regdate' => $regdate,
			'regtime' => $date,
			'kdcbayar' => $kdcbayar,
			'kdjaminan' => $kdjaminan,
			'kdperusahaan' => '',
			'nopeserta' => $nopeserta,
			'kdtuju' => $kdtuju,
			'kdpoli' => $kdpoli,
			'kdbangsal' => '',
			'kdkelas' => '',
			'nottidur' => '',
			'kddoc' => $kddoc,
			'kunjungan' => $kunjungan,
			'validuser' => $this->session->userdata('username'),
			'sex' => $kdsex == 'L' ? 'Laki-laki' : 'Perempuan',
			'umurthn' => $umurthn,
			'umurbln' => $umurbln,
			'umurhari' => $umurhari,
			'bod' => $bod,
			'nomorurut' => $nomorurut,
			'statusreg' => '1',
			'kategori' => $kategori,
			'nosep' => $nosep,
			'kdicd' => $kdicd,
			'kdsex' => $kdsex,
			'groupunit' => $groupunit,
			'kdicdbpjs' => $kdicdbpjs,
			'bodbpjs' => $bodbpjs,
			'pisat' => $pisat,
			'keterangan' => $keterangan,
			'catatan' => $catatan,
			'tglrujuk' => $tglrujuk,
			'nokontrol' => $nokontrol,
			'norujuk' => $norujuk,
			'kdrujukan' => $kdrujukan,
			'nmrujukan' => $nmrujukan,
			'kdrefpeserta' => $kdrefpeserta,
			'nmrefpeserta' => $nmrefpeserta,
			'nmkelas' => $nmkelas,
			'notifsep' => $notifsep,
			'kdkasus' => $kdkasus,
			'lokasikasus' => '',
			'kddpjp' => $kddpjp,
			'nikktp' => $nikktp,
			'statpeserta' => $statpeserta,
			'kdstatpeserta' => '0',
			'perjanjian' => $perjanjian,
			'asalrujuk' => $asalrujuk,
			'phone' => $phone,
			'kdcob' => $kdcob,
			'prolanis' => $prolanis,
			'idregold' => $idregold,
			'nmcob' => $nmcob,
			'kdjaminanbpjs' => $kdjaminanbpjs,
			'regnumber' => '',
			'sequalNum' => ''
		);

		$result = $this->sv->query($sp,$params);
		return $result->row();
	}

	public function get_all_instansi_kirim(){
		$instansi=$this->sv->select("TBLInstansi.KdInstansi, TBLInstansi.NmInstansi")->from("TBLInstansi");
        return $instansi->get()->result();
	}

	public function update_photo($filename, $notran)
	{
		$data_update = array(
			'file_photo' => $filename,
			'tgl_upload' => date("Y-m-d H:i:s")
		);
		$update = $this->sv->where('No_register', $notran)->update('Register_instansi', $data_update);
		if ($update) {
			$parse = array(
				'status' => true,
				'message' => 'Berhasil menambahkan Foto'
			);
		} else {
			$parse = array(
				'status' => false,
				'message' => 'Gagal menambahkan Foto'
			);
		}

		return $parse;
	}

	public function get_file_instansi($regno='')
	{
		return $this->sv->select('hasil.*')
			->from('Register_instansi hasil')
			->where('hasil.No_register', $regno)->get()->row();
	}
}
