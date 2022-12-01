<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BillingPemeriksaan_model extends MY_Model {

	protected $sv;
	function __construct(){
		parent::__construct();
		$this->sv = $this->load->database('server',true);
	}

	public function get_billing_pasien_by_no_trans($no_trans, $list_order = NULL)
	{
		$this->sv->select([
				'h.NoTran',
				'h.Tanggal',
				'h.Jam',
				'h.NoLab',
				'h.NoLab',
				'h.TglHasil',
				'h.JamHasil',
				'h.TglSelesai',
				'h.JamSelesai',
				'h.TotalBiaya',
				'h.Jumlah',
				'h.Diskon',
				'h.Regno',
				'h.Medrec',
				'h.Firstname',
				'h.nStatus',
				'h.nJenis',
				'h.UmurThn',
				'h.UmurBln',
				'h.UmurHari',
				'r.KdCBayar', 'cb.NMCbayar',
				'h.KdJaminan', 'jm.NMJaminan',
				'h.KdPoli', 'pl.NMPoli',
				'h.KdBangsal', 'bl.NmBangsal',
				'h.KdKelas', 'kl.NmKelas',
				'h.Kategori', 'kr.NmKategori',
				'h.KdDoc',
				'h.NmDoc',
				'h.KdDokter', 'dr.NmDoc AS NmDokter', 'h.TglSampel', 'h.AsalSampel', 'h.Setujui', 'h.Verifikasi', 'h.Pengambil_sampel', 'h.Kd_ambil_sampel', 'h.Kd_setujui', 'h.Kd_verif'
			])
			->from('HeadBilPatologi AS h')
			->join('Register AS r', 'r.Regno=h.Regno', 'LEFT')
			->join('TBLcarabayar AS cb', 'r.KdCBayar=cb.KdCBayar', 'LEFT')
			->join('TBLJaminan AS jm', 'h.KdJaminan=jm.KdJaminan', 'LEFT')
			->join('POLItpp AS pl', 'h.KdPoli=pl.KdPoli', 'LEFT')
			->join('TBLBangsal AS bl', 'h.KdBangsal=bl.KdBangsal', 'LEFT')
			->join('TBLKelas AS kl', 'h.KdKelas=kl.KdKelas', 'LEFT')
			->join('TblKategoriPsn AS kr', 'h.Kategori=kr.KdKategori', 'LEFT')
			->join('FtDokter AS dr', 'h.KdDokter=dr.KdDoc', 'LEFT')
			->where('h.NoTran', $no_trans);
			// ->get()->row();

		if($list_order === TRUE)
		{
			$this->sv->where('h.Tanda !=', 0);
		}
		elseif($list_order === FALSE)
		{
			$this->sv->where('h.Tanda =', 0);
		}

		$billing = $this->sv->get()->row();

		if(empty($billing)) return NULL;

		$billing->usia = $billing->UmurThn.' tahun '.$billing->UmurBln.' bulan '.$billing->UmurHari.' hari';
		$billing->FormattedTglSelesai = $billing->TglSelesai ? date('d/m/Y', strtotime($billing->TglSelesai)) : NULL;
		$billing->FormattedJamSelesai = $billing->JamSelesai ? date('H:i:s', strtotime($billing->JamSelesai)) : NULL;
		$billing->FormattedTotalBiaya = number_format($billing->Jumlah, 0, ',', '.');
		$billing->FormattedJumlahBiaya = number_format($billing->TotalBiaya, 0, ',', '.');

		$billing->list_detail = $this->sv
			->select([
				'd.NoTran',
				'd.Tanggal',
				'd.KdPemeriksaan',
				'd.KdTarif',
				'd.NmTarif',
				'd.Sarana',
				'd.Pelayanan',
				'd.Qty',
				'd.JumlahBiaya',
				'FtDokter.NmDoc'
			])
			->from('DetailBilPatologi AS d')
			->join('FtDokter','FtDokter.KdDoc = d.KdDokter', 'left')
			->where('d.NoTran', $no_trans)
			->get()->result();
		return $billing;
	}

	public function get_billing_pasien_by_regno($regno)
	{
		$register = $this->sv->select([
				'r.Regno',
				'r.Medrec',
				'r.Firstname',
				'r.kewarganegaraan',
				'r.Regdate',
				'r.KdSex',
				'r.NmRujukan',
				'r.Bod',
				'r.KdDoc', 'dok.NmDoc',
				'r.KdJaminan', 'jm.NMJaminan',
				'r.KdPoli', 'pol.NMPoli',
				'ri.KdKelas', 'kls.NmKelas',
				'r.Kategori', 'kat.NmKategori',
				'ri.KdBangsal', 'bsl.NmBangsal',
				'r.KdCBayar', 'cb.NMCbayar',
				// 'r.Regtime',
				// 'r.NoPeserta',
				// 'r.AtasNama',
				// 'r.NmKelas',
				// 'pas.TglDaftar',
				// 'r.Kunjungan',
				// 'r.NomorUrut',
				// 'r.nikktp',
				// 'r.NoKontrol',
				// 'r.NoRujuk',
				// 'r.Sex',
				// 'r.KdTuju',
				// 'r.TglRujuk',
				// 'r.KdIcd',
				// 'icd10.DIAGNOSA',
				// 'r.NoSep',
				// 'r.NotifSep',
				// 'r.Keterangan',
				// 'pen.NMTuju',
				// 'r.ValidUser', 'r.phone',
				// 'r.kdcob', 'r.Prolanis', 'r.StatPeserta',
				// 'r.NmRefPeserta', 'r.Catatan', 'sep.Nomor', 'hb.NoTran', 'hb.NoLab', 'hb.KdDokter', 'dop.NmDoc as NmDokterPemeriksa',
				// 'hb.KdDoc as KdDokterPengirim', 'hb.NmDoc as NmDokterPengirim',
			])
			->from("Register AS r")
			->join("FPPRI AS ri", "r.Regno = ri.Regno", "LEFT")
			->join("MasterPS AS pas", "r.Medrec = pas.Medrec", "LEFT")
			->join("TBLJaminan AS jm", "r.KdJaminan = jm.KDJaminan", "LEFT")
			->join("TBLICD10 AS icd10", "r.KdICD = icd10.KDICD", "LEFT")
			->join("TBLKelas AS kls", "ri.KdKelas = kls.KdKelas", "LEFT")
			->join("TBLBangsal AS bsl", "ri.KdBangsal = bsl.KdBangsal", "LEFT")
			->join("TblKategoriPsn AS kat", "r.Kategori = kat.KdKategori", "LEFT")
			->join("POLItpp AS pol", "r.KdPoli = pol.KDPoli", "LEFT")
			->join("FtDokter AS dok", "r.KdDoc = dok.KdDoc", "LEFT")
			->join("TBLcarabayar AS cb", "r.KdCBayar = cb.KDCbayar", "LEFT")
			// ->join("TBLTpengobatan AS pen", "r.KdTuju = pen.KDTuju", "LEFT")
			// ->join("fCetakSEP AS sep", "r.Regno = sep.Regno", "LEFT")
			// ->join("HeadBilPatologi AS hb", "r.Regno = hb.Regno", "LEFT")
			// ->join("FtDokter AS dop", "hb.KdDokter = dop.KdDoc", "LEFT")
			->where("r.Regno", $regno)
			->where('r.Deleted', NULL)
			->get()->row();

		if(empty($register)) return NULL;

		$register->usia = date_diff(date_create(), date_create($register->Bod))->format('%y tahun %m bulan %d hari');
		$register->FormattedRegdate = date('d/m/Y', strtotime($register->Regdate));

		$no_tran_now = $this->sv->query(
			'SELECT TOP 1 NoTran FROM HeadBilPatologi WHERE Regno=? AND CAST(Tanggal AS DATE)=CAST(GETDATE() AS DATE)',
			[$register->Regno]
		)->row('NoTran');

		$register->TransaksiSekarang = $this->get_billing_pasien_by_no_trans($no_tran_now);

		$register->list_transaksi = $this->sv
			->select([
				'NoTran', 'Tanggal', 'Jam'
			])
			->from('HeadBilPatologi')
			->where('Regno', $regno)
			// ->where('COALESCE(Tanda, 0)=', 0)
			->get()->result();

		// echo '<pre>'; print_r($register); die();
		return $register;
	}

	public function hapus_detail_billing($no_trans, $kode_tarif)
	{
		$detail_bil = $this->sv
			->select(['NoTran', 'KdPemeriksaan', 'KdTarif'])
			->where('NoTran', $no_trans)
			->where('KdTarif', $kode_tarif)
			->get('DetailBilPatologi')->row();

		$this->sv->trans_start();

		$list_detail = [$detail_bil->KdPemeriksaan];

		$detail_pemeriksaan = $this->sv
			->select(['KodeDetail', 'KDDetail'])
			->where('KDDetail', $detail_bil->KdPemeriksaan)
			->get('DetailPemeriksaan')->result();

		if(!empty($detail_pemeriksaan))
		{
			$list_detail = array_merge($list_detail, array_map(function($i) { return $i->KodeDetail; }, $detail_pemeriksaan));
		}

		$this->sv->where('NoTran', $no_trans)->where_in('KDDetail', $list_detail)->delete('HasilPatologi');

		$this->sv
			->where('NoTran', $no_trans)
			->where('KdTarif', $kode_tarif)
			->delete('DetailBilPatologi');

		$new_total = $this->sv->query("SELECT SUM(JumlahBiaya) AS Total FROM DetailBilPatologi WHERE NoTran=?", [$no_trans])->row('Total');

		$this->sv->where('NoTran', $no_trans)->update('HeadBilPatologi', ['Jumlah' => $new_total, 'TotalBiaya' => $new_total]);

		$success = $this->sv->trans_complete();

		return ['success' => $success, 'new_total' => $new_total, 'formatted_total' => number_format($new_total, 0, ',', '.')];
	}

	public function hapus_billing($no_tran)
	{
		$this->sv->trans_start();

		$this->sv->where('NoTran', $no_tran)->delete('HasilPatologi');
		$this->sv->where('NoTran', $no_tran)->delete('DetailBilPatologi');
		$this->sv->where('NoTran', $no_tran)->delete('HeadBilPatologi');

		return $this->sv->trans_complete();
	}

	public function get_group_pemeriksaan()
	{
		return $this->sv->get('fGroupPatologi')->result();
	}

	public function get_detail_tindakan($kode_group)
	{
		return $this->sv
			->select(['KDDetail', 'KdGroup', 'NMDetail', 'KdInput'])
			->where('KdGroup', $kode_group)
			->get('fPemeriksaanPatologi')->result();
	}

	public function get_tindakan_order_pasien($notrans)
	{
		return $this->sv
			->select(['KdPemeriksaan'])
			->where('NoTran', $notrans)
			->get('DetailBilPatologi')->row();
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
				'ps.Bod',
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
			'kewarganegaraan'   => $kwn,
			'Shift'      => $this->session->userdata('shift'),
			'ValidUser'  => $this->session->userdata('username').' '.date('d/m/Y H:i:s'),
			'nStatus'    => $status,
			'nJenis'     => $jenis_pemeriksaan,
			'KdDokter'   => $dok_pemeriksa,
			'Tanda'      => 0,
		]);

		$this->sv->trans_start();

		
		$no = 'PA'.date('my', strtotime($tgl_transaksi));

		if(empty($no_tran))
		{
			$date2 = Date('my');
			$defaultNomorTransaksi = 1;
			$notransaksi = 'PA'.$date2;

			$cek_nomor_transaksi = $this->sv->select('*')->from('NoTransaksi')->where('NTCode', $notransaksi)->get()->row();
			if (!empty($cek_nomor_transaksi)) {
				$defaultNomorTransaksi = $cek_nomor_transaksi->Nomor+1;
				$this->sv->set('Nomor', $defaultNomorTransaksi)->where('NTCode', $notransaksi)->update('NoTransaksi');
			} else {
				$this->sv->set('NTCode', $notransaksi)->set('Nomor', $defaultNomorTransaksi)->set('NoBukti', '1')->set('NOJurnal', '1')->insert('NoTransaksi');
			}

			if (strlen($defaultNomorTransaksi) == 1) {
				$defaultNomorTransaksi = '000'.$defaultNomorTransaksi;
			} elseif (strlen($defaultNomorTransaksi) == 2) {
				$defaultNomorTransaksi = '00'.$defaultNomorTransaksi;
			} elseif (strlen($defaultNomorTransaksi) == 3) {
				$defaultNomorTransaksi = '0'.$defaultNomorTransaksi;
			}

			$properties['NoTran'] = $notransaksi.$defaultNomorTransaksi;

			$kode_tuju = !empty($register['KdBangsal']) ? 'RI' : (
				$register['KdPoli'] == '24' ? 'IGD' : (
					$register['KdPoli'] == '21' ? 'MCU' : (
						$register['KdCbayar'] == '01' ? 'PS' : 'RJ'
					)
				)
			);

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

			$this->sv->where('NoTran', $properties['NoTran'])->delete('HasilPatologi');
		}
		else
		{
			//cek data ada di HeadBilPatologi tidak ?
			$exists = $this->sv
			->select('1 AS exists')
			->where('NoTran', $no_tran)
			->get('HeadBilPatologi')->row('exists');

			if($exists) 
			{
				//berarti data memang benar dari lab 
				$this->sv->where('NoTran', $no_tran)->update('HeadBilPatologi', $properties);
			}else{
				//ubah flag di temp, bahwa data sudah masuk ke headbill 
				$flag = array('Tanda' => 0);
				$this->sv->where('NoTran', $no_tran)->update('HeadBilPatologiTEMP', $flag);
				//artinya data dari ORDER dan ambil dari temp table
				$data_temp = $this->sv
				->where('NoTran', $no_tran)
				->get('HeadBilPatologiTEMP')->row_array();
				$dataTemp = array_merge($data_temp, [
					'TglSelesai' => empty($tgl_selesai) ? $tgl_selesai : NULL,
					'JamSelesai' => empty($jam_selesai) ? date('Y-m-d H:i:s', strtotime($jam_transaksi)) : NULL,
					'Shift'      => $this->session->userdata('shift'),
					'ValidUser'  => $this->session->userdata('username').' '.date('d/m/Y H:i:s'),
					'nStatus'    => $status,
					'nJenis'     => $jenis_pemeriksaan,
					'KdDokter'   => $dok_pemeriksa,
					'Tanda'      => 0,
				]);
				$this->sv->insert('HeadBilPatologi',$dataTemp);
			}
		}

		$head_hasil_exists = $this->sv->select('1 AS exists')->where('NoTran', $properties['NoTran'])->get('HasilPatologi')->row('exists');

		// if(!$head_hasil_exists)
		// {
		// 	$this->sv->insert('HasilPatologi', [
		// 		'Notran'     => $properties['NoTran'],
		// 		'Regno'      => $properties['Regno'],
		// 		'RegDate'    => $properties['RegDate'],
		// 		'MedRec'     => $properties['MedRec'],
		// 		'Firstname'  => $properties['Firstname'],
		// 		'Sex'        => $properties['Sex'],
		// 		'Umurthn'    => $properties['UmurThn'].'-'.$properties['UmurBln'].'-'.$properties['UmurHari'],
		// 		'ValidUser'  => $properties['ValidUser'],
		// 		'KdDoc'      => $dok_pemeriksa
		// 	]);
		// }

		// TODO: VALIDASI DETAIL

		$result = $this->sv->trans_complete();

		return $result ? $properties : FALSE;
	}

	public function tambah_detail_billing($params)
	{
		extract($params);
		
		if(empty($no_tran) && (empty($kode_tindakan))) return FALSEA;

		if(empty($kode_tindakan)) return FALSEB;

		$head = $this->sv
			->select(['Regno', 'MedRec', 'KdDokter'])
			->where('NoTran', $no_tran)
			->get('HeadBilPatologi')->row_array();

		if(empty($head)) return FALSEC;

		$rajal = 'rj';

		$register = $this->sv->where('r.Regno', $head['Regno'])
			->from('Register AS r')
			->join('FPPRI AS ri', 'r.Regno=ri.Regno', 'LEFT')
			->select(['r.Regno','r.Firstname','r.Sex','r.UmurThn','r.UmurBln','r.UmurHari','r.RegDate', 'ri.KdBangsal', 'ri.KdKelas', 'r.KdSex'])
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

		if(!empty($register->KdKelas))
		{
			$this->sv->where('t.KdKelas', $register->KdKelas);
		}else{
			$this->sv->where('t.KdKelas ', $rajal );
		}
			// $this->sv->where('t.KdKelas ', $rajal );
		$detail_tarif = $this->sv->limit(1)->get()->row_array();
		// echo '<pre>'; print_r($detail_tarif); exit();

		if(empty($detail_tarif)) return FALSEt;

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
		$pemeriksaan = $this->sv->get('fPemeriksaanPatologi')->row_array();

			$data_hasil = [
				'NoTran'    => $no_tran,
				'Regno'     => $head['Regno'],
				'Medrec'    => $head['MedRec'],
				'KdGroup'    => $pemeriksaan['KdGroup'],
				'KDDetail'    => $kode_tindakan,
				'NMDetail'    => $pemeriksaan['NMDetail'],
				'Medrec'    => $head['MedRec'],
				'RegDate' => $register->RegDate,
				'Firstname' => $register->Firstname,
				'Sex' => $register->Sex,
				'UmurThn' => $register->UmurThn.'-'.$register->UmurBln.'-'.$register->UmurHari,
				'ValidUser' => $this->session->userdata('username').' '.date('d/m/Y H:i:s'),
				'KdDoc'      => $head['KdDokter']	
			];
		$this->sv->insert('HasilPatologi', $data_hasil);


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
				'd.Qty',
				'd.JumlahBiaya',
			])
			->from('DetailBilPatologi AS d')
			->where('d.NoTran', $no_tran)
			->where('d.KdPemeriksaan', $kode_tindakan)
			->get()->result();

		return $success ? [
			'list_detail' => $list_detail,
			'FormattedJumlahBiaya' => number_format($new_total, 0, ',', '.')
		] : FALSE;
	}

	public function get_billing_by_notran($no_tran)
	{
		$result = $this->sv
			->select('h.*')
			->select('p.Address')
			->select('pl.NMPoli')
			->select('bl.NmBangsal')
			->select('kl.NMkelas')
			->select('kp.NmKategori')
			->select('doc.NmDoc AS NmDokter')
			->from('HeadBilPatologi AS h')
			->join('MasterPS AS p', 'h.MedRec=p.MedRec', 'LEFT')
			->join('POLItpp AS pl', 'h.KdPoli=pl.KdPoli', 'LEFT')
			->join('TBLBangsal AS bl', 'h.KdBangsal=bl.KdBangsal', 'LEFT')
			->join("TBLKelas AS kl", "h.KdKelas=kl.KdKelas", "LEFT")
			->join("TblKategoriPsn AS kp", "h.Kategori=kp.KdKategori", "LEFT")
			->join("FtDokter AS doc", "h.KdDokter=doc.KdDoc", "LEFT")
			->join("TBLJaminan AS jm", "h.KdJaminan=jm.KdJaminan", "LEFT")
			->where('h.NoTran', $no_tran)
			->get()->row();

		if(empty($result)) return FALSE;

		$result->detail = $this->sv->where('NoTran', $no_tran)->get('DetailBilPatologi')->result();

		return $result;
	}

	public function get_pasien_by_rm($medrec)
	{
		$pasien = $this->sv->select('r.*, k.NmKategori')->from('MasterPS r')
					->join('TblKategoriPsn k', 'r.Kategori = k.KdKategori')
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

	public function group_lab()
	{
		$stat = $this->sv->get('fGroupPatologi');
		return $stat->result();
	}

	public function pemeriksaan_lab($kdgroup='')
	{
		if ($kdgroup!='') {
			$this->sv->where('KdGroup', $kdgroup);
		}
		$stat = $this->sv->get('fPemeriksaanPatologi');
		return $stat->result();
	}

	public function list_billing_pemeriksaan($date1 = '', $date2 = '')
	{
		$data = $this->sv->select("head.NoTran, head.Tanggal, head.NoLab, head.Regno, head.RegDate, head.MedRec, head.Firstname, head.Sex, Head.UmurThn, head.KdBangsal, bangsal.NmBangsal, head.KdKelas, kelas.NMkelas, head.KdPoli, poli.NMPoli, head.TotalBiaya, head.ValidUser, head.Kategori, kategori.NmKategori")->from('HeadBilPatologi head')
		->join("TBLBangsal bangsal", "head.KdBangsal = bangsal.KdBangsal", "LEFT")
		->join("TBLKelas kelas", "head.KdKelas = kelas.KdKelas", "LEFT")
		->join("POLItpp poli", "head.KdPoli = poli.KDPoli", "LEFT")
		->join("TblKategoriPsn kategori", "head.Kategori = kategori.KdKategori", "LEFT")
		->where("head.Tanggal >=", $date1.' 00:00:00')
		->where("head.Tanggal <=", $date2.' 23:59:59')->get()->result();

		return $data;
	}

	public function get_list_billing_pemeriksaan_page($filter_options)
	{
		$this->db_interface =& $this->sv;

		extract($filter_options);

		$select = [
			'head.NoTran',
			'head.Tanggal',
			'head.NoLab',
			'head.Regno',
			'head.RegDate',
			'head.MedRec',
			'head.Firstname',
			'head.Sex',
			'Head.UmurThn',
			'head.KdBangsal',
			'bangsal.NmBangsal',
			'head.KdKelas',
			'kelas.NMKelas',
			'head.KdPoli',
			'poli.NMPoli',
			'head.TotalBiaya',
			'head.Kategori',
			'kategori.NmKategori',
			'reg.Catatan AS CatatanRegistrasi',
			'pas.Address',
			'ins.NmInstansi', 'krj.JenisBayar', 'CASE WHEN lain.Keterangan is null THEN null ELSE '."'LUNAS'".' END as lainnya', 'lain.Keterangan', 'rins.Jenis_bayar'
		];

		$from = [
			'HeadBilPatologi head',
			'LEFT JOIN Register AS reg ON head.Regno = reg.Regno',
			'LEFT JOIN MasterPS AS pas ON head.MedRec = pas.Medrec',
			'LEFT JOIN TBLBangsal AS bangsal ON head.KdBangsal = bangsal.KdBangsal',
			'LEFT JOIN TBLKelas AS kelas ON head.KdKelas = kelas.KdKelas',
			'LEFT JOIN POLItpp AS poli ON head.KdPoli = poli.KDPoli',
			'LEFT JOIN TblKategoriPsn AS kategori ON head.Kategori = kategori.KdKategori',
			'LEFT JOIN TBLUnitInstansi AS uns ON reg.unitInstansi = uns.KdUnit',
			'LEFT JOIN TBLInstansi AS ins ON uns.KdInstansi = ins.KdInstansi',
			'LEFT JOIN KasirIrj AS krj ON krj.Regno = head.Regno',
			'LEFT JOIN PembayaranLayananLainnya AS lain ON lain.Nama = head.Firstname',
			'LEFT JOIN Register_instansi AS rins ON rins.No_register = reg.regno_instansi',
			'where head.KdPoli =38'
		];

		$where = $this->db->compile_binds('CAST(Tanggal AS DATE) BETWEEN ? AND ?', [$from_date->format('Y-m-d'), $to_date->format('Y-m-d')]);

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
		}

		return $this->raw_query_pagination($select, $from, $where, 'NoTran ASC');
	}

	public function tarif_pemeriksaan($kodedetail, $kdkelas)
	{
		$tarif = $this->sv->select("tarif.KDTarif, pemeriksaan.KDDetail, tarif.Sarana, tarif.Pelayanan, tarif.Tarif, tarif.JasaDokter, tarif.JasaDokter1, tarif.JasaPerawat, tarif.JasaPerawat1, tarif.JasaRumahSakit, tarif.JasaRumahSakit1, pemeriksaan.NMDetail")
			->from("fTarifPatologi tarif")
			->join('fPemeriksaanPatologi pemeriksaan', 'tarif.KDDetail = pemeriksaan.KDDetail')
			->where('pemeriksaan.KDDetail', $kodedetail);
		if ($kdkelas != '') {
			$tarif = $tarif->where('tarif.KdKelas', $kdkelas);
		}
		$tarif = $tarif->limit(1)->get()->row();
		if (!empty($tarif)) {
			$parse = array(
				'status' => true,
				'tarif' => $tarif
			);
		} else {
			$parse = array(
				'status' => false,
				'tarif' => []
			);
		}
		return $parse;
	}

	public function tarif_pemeriksaan_by_kdmapping($kdmapping)
	{
		$tarif = $this->sv->select("tarif.KDTarif, pemeriksaan.KDDetail, tarif.Sarana, tarif.Pelayanan, tarif.Tarif, tarif.JasaDokter, tarif.JasaDokter1, tarif.JasaPerawat, tarif.JasaPerawat1, tarif.JasaRumahSakit, tarif.JasaRumahSakit1, pemeriksaan.NMDetail")
			->from("fTarifPatologi tarif")
			->join('fPemeriksaanPatologi pemeriksaan', 'tarif.KDDetail = pemeriksaan.KDDetail')
			->where('pemeriksaan.KdMapping', $kdmapping)->limit(1)->get()->row();
		if (!empty($tarif)) {
			$parse = array(
				'data' => $tarif,
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

	public function get_billing_detail($kdtransaksi = '')
	{
		$detail = $this->sv->select("*")->from("DetailBilPatologi")->where('NoTran', $kdtransaksi)->order_by('Tanggal', 'ASC')->get()->result();
		return $detail;
	}

	public function get_label_billing($kdtransaksi = '')
	{
		$data = $this->sv->select("*, register.Bod, register.KdTuju, kategori.NmKategori, bangsal.NmBangsal, kelas.NMkelas, poli.NMPoli")->from("HeadBilPatologi")
			->join("Register register", "HeadBilPatologi.Regno = register.Regno")
			->join("TblKategoriPsn kategori", "HeadBilPatologi.Kategori = kategori.KdKategori")
			->join("TBLBangsal bangsal", "HeadBilPatologi.KdBangsal = bangsal.KdBangsal", "LEFT")
			->join("TBLKelas kelas", "HeadBilPatologi.KdKelas = kelas.KdKelas", "LEFT")
			->join("POLItpp poli", "HeadBilPatologi.KdPoli = poli.KDPoli", "LEFT")
			->where("NoTran", $kdtransaksi)->get()->row();
		return $data;
	}

	public function update_dokter_pengirim($data)
	{
		$check_notran = $this->sv->select('*')->from('HeadBilPatologi')->where('NoTran', $data['Notran'])->get()->row();
		if (!empty($check_notran)) {
			$search_dokter = $this->sv->select('NmDoc')->from('FtDokter')->where('KdDoc', $data['DokterPengirim'])->get()->row();
			$update = $this->sv->set('KdDoc', $data['DokterPengirim'])->set('NmDoc', $search_dokter->NmDoc)->set('KdDokter', $data['DokterPemeriksa'])->where('NoTran', $data['Notran'])->update('HeadBilPatologi');
			if ($update) {
				$parse = array(
					'status' => true,
					'message' => 'Dokter pengirim berhsail dirubah'
				);
			} else {
				$parse = array(
					'status' => false,
					'message' => 'Dokter pengirim gagal dirubah'
				);
			}
		} else {
			$parse = array(
					'status' => false,
					'message' => 'Dokter pengirim gagal dirubah'
				);
		}
		return $parse;
	}

	public function create_new_no($tujuan = '')
	{
		// Nomor Laboratorium
		$defaultNomorLab = 1;
		$date = Date('my');
		$index = "0000";
		$value = '';
		if ($tujuan == 'UGD') {
			$value = 'UGD';
			$tujuan = 'UGD'.$date;
		} elseif($tujuan == 'PA') {
			$value = 'PAI';
			$tujuan = 'PAI'.$date;
		} else {
			$value = 'PA';
			$tujuan = 'PA'.$date;
		}

		$cek_nomor_lab = $this->sv->select("*")->from("NomorLaboratorium")->where("NoLaborat", $tujuan)->get()->row();
		if (!empty($cek_nomor_lab)) {
			$defaultNomorLab = $cek_nomor_lab->Nomor+1;
			$this->sv->set('Nomor', $defaultNomorLab)->where('NoLaborat', $tujuan)->update('NomorLaboratorium');
		} else {
			$this->sv->set('NoLaborat', $tujuan)->set('Nomor', $defaultNomorLab)->insert('NomorLaboratorium');
		}

		if (strlen($defaultNomorLab) == 1) {
			$defaultNomorLab = "000".$defaultNomorLab;
		} elseif (strlen($defaultNomorLab) == 2) {
			$defaultNomorLab = "00".$defaultNomorLab;
		} elseif (strlen($defaultNomorLab) == 3) {
			$defaultNomorLab = "0".$defaultNomorLab;
		}

		// Nomor

		$date2 = Date('my');
		$defaultNomorTransaksi = 1;
		$notransaksi = 'PA'.$date2;

		$cek_nomor_transaksi = $this->sv->select('*')->from('NoTransaksi')->where('NTCode', $notransaksi)->get()->row();
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

		// Finish
		$parse = array(
			'status' => true,
			'NomorLab' => $value.$defaultNomorLab,
			'NomorTransaksi' => $notransaksi.$defaultNomorTransaksi
		);
		return $parse;
	}

	public function create_billing_pemeriksaan($data)
	{
		$parse = [];
		$input_detail = 0;
		$input_detail_hasil = 0;

		$cek_poli = $this->sv->select('*')->from('POLItpp')->where('KDPoli', $data['KdPoli'])->get()->row();
		if (!empty($cek_poli)) {
			$create_nomor = $this->create_new_no($cek_poli->KdTuju);

			if ($create_nomor['NomorLab'] != '' || $create_nomor['NomorTransaksi'] != '') {
				$parse['NoTran'] = $create_nomor['NomorTransaksi'];
				$parse['NoLab'] = $create_nomor['NomorLab'];

				$pasien = $this->sv->select('*')->from('Register')->where('Regno', $data['Regno'])->get()->row();
				$dokter = $this->sv->select('*')->from('FtDokter')->where('KdDoc', $data['KdPengirim'])->get()->row();

				// Parameter
				$post_head_billing = array(
					'NoTran' => $create_nomor['NomorTransaksi'],
					'Tanggal' => $data['TglTransaksi'],
					'Jam' => $data['JamTransaksi'],
					'NoLab' => $create_nomor['NomorLab'],
					'TglSelesai' => $data['TglSelesai'],
					'JamSelesai' => $data['JamSelesai'],
					'Regno' => $data['Regno'],
					'Regdate' => $data['Regdate'],
					'MedRec' => $data['Medrec'],
					'Firstname' => $pasien->Firstname,
					'Sex' => $data['KdSex'] == 'L' ? 'Laki-laki' : 'Perempuan',
					'UmurThn' => $data['UmurThn'],
					'UmurBln' => $data['UmurBln'],
					'UmurHari' => $data['UmurHari'],
					'KdBangsal' => $data['KdBangsal'],
					'KdKelas' => $data['KdKelas'],
					'KdDoc' => $data['KdPengirim'] ?? '',
					'NmDoc' => $dokter->NmDoc ?? '',
					'KdPoli' => $data['KdPoli'],
					'KdCbayar' => $data['KdCBayar'],
					'KdJaminan' => $data['KdJaminan'],
					'Jumlah' => $data['JumlahBiaya'],
					'TotalBiaya' => $data['JumlahBiaya'],
					'Shift' => '1',
					'ValidUser' => $this->session->userdata('username').' '.date('d/m/Y H:i:s'),
					'Kategori' => $data['Kategori'],
					'nStatus' => $data['Status'],
					'nJenis' => $data['Jenis'],
					'KdDokter' => $data['KdPemeriksa']
				);

				$post_head_hasil = array(
					'Notran' => $create_nomor['NomorTransaksi'],					
					'Regno' => $data['Regno'],
					'RegDate' => $data['Regdate'],
					'MedRec' => $data['Medrec'],
					'Firstname' => $pasien->Firstname,
					'Sex' => $data['KdSex'] == 'L' ? 'Laki-laki' : 'Perempuan',
					'UmurThn' => $data['UmurThn'].'-'.$data['UmurBln'].'-'.$data['UmurHari'],
					'ValidUser' => $this->session->userdata('username').' '.date('d/m/Y H:i:s'),
					'TglHasil'   => date('Y-m-d'),
					'JamHasil'   => date('H:i:s'),
					'KdDoc'      => $data['KdPemeriksa']				
				);

				$cek_transaksi = $this->sv->select('*')->from('HeadBilPatologi')->where('NoTran', $create_nomor['NomorTransaksi'])->get()->row();
				if (empty($cek_transaksi)) {
					$save_head_billing = $this->sv->set($post_head_billing)->insert('HeadBilPatologi');
					$parse['message_head_billing'] = 'Masuk Head Billing';
					//$save_head_hasil = $this->sv->set($post_head_hasil)->insert('HasilPatologi');
					//$parse['message_head_hasil'] = 'Masuk Head Hasil';
				} else {
					$update_head_billing = $this->sv->where('NoTran', $create_nomor['NomorTransaksi'])->update('HeadBilPatologi', $post_head_billing);
					$parse['message_billing'] = 'Data Berhasil diubah!';
				}
				$parse['alur-1'] = '-1';
				// post detail
				$pemeriksaan = [];
				for ($i=1; $i < count($data['Pemeriksaan']); $i++) {
					$pemeriksaan[] = $data['Pemeriksaan'][$i];
				}
				$parse['alur0'] = '0';

				foreach ($pemeriksaan as $list_pemeriksaan) {
					// lab Satuan
					$tarif_satuan = $this->sv->select('tarif.KDTarif, tarif.Sarana, tarif.Pelayanan, tarif.Tarif, tarif.KDDetail, pemeriksaan.KdGroup, grouplab.NmGroup, pemeriksaan.NMDetail, 
						pemeriksaan.Satuan,
						pemeriksaan.NilaiNormalPria, 
						pemeriksaan.NilaiNormalWanita, 
						pemeriksaan.NNAwalPria as PemeriksaanAwalPria, 
						pemeriksaan.NNAkhirPria as PemeriksaanAkhirPria, 
						pemeriksaan.NNAwalWanita as PemeriksaanAwalWanita, 
						pemeriksaan.NNAkhirWanita as PemeriksaanAkhirWanita,
						pemeriksaan.KdMappingHistori as KodeMappingHistori,
						detailpemeriksaan.KodeDetail, detailpemeriksaan.NamaDetail, 
						detailpemeriksaan.NilaiNormalPria as detailpemeriksaanNilaiNormalPria, 
						detailpemeriksaan.NilaiNormalWanita as detailpemeriksaanNilaiNormalWanita, 
						detailpemeriksaan.Satuan as detailpemeriksaanSatuan,
						detailpemeriksaan.NNAwalPria as detailpemeriksaanNNAwalPria, 
						detailpemeriksaan.NNAkhirPria as detailpemeriksaanNNAkhirPria, 
						detailpemeriksaan.NNAwalWanita as detailpemeriksaanNNAwalWanita, 
						detailpemeriksaan.NNAkhirWanita as detailpemeriksaanNNAkhirWanita,
						detailpemeriksaan.KdMappingHistori as detailpemeriksaanKodeMappingHistori')
						->from('fTarifPatologi tarif')
						->join('fPemeriksaanPatologi pemeriksaan', 'tarif.KDDetail = pemeriksaan.KDDetail')
						->join('DetailPemeriksaan detailpemeriksaan', 'tarif.KDDetail = detailpemeriksaan.KDDetail', 'LEFT')
						->join('fGroupPatologi grouplab', 'pemeriksaan.KdGroup = grouplab.KDGroup')
						->where('tarif.KDTarif', $list_pemeriksaan['col1'])->get()->row();
					$parse['alur'] = '1';

					$post_detail_billing = array(
						'NoTran' => $create_nomor['NomorTransaksi'],
						'Tanggal' => $data['TglTransaksi'],
						'Regno' => $data['Regno'],
						'MedRec' => $data['Medrec'],
						'KdPemeriksaan' => $tarif_satuan->KDDetail,
						'KdTarif' => $tarif_satuan->KDTarif,
						'NmTarif' => $tarif_satuan->NMDetail,
						'Sarana' => $tarif_satuan->Sarana,
						'Pelayanan' => $tarif_satuan->Pelayanan,
						'JumlahBiaya' => $tarif_satuan->Tarif,
						'nCover' => '0',
						'Shift' => '1',
						'ValidUser' => $this->session->userdata('username').' '.date('d/m/Y H:i:s'),
						'KdDokter' => $data['KdPemeriksa']
					);

					$post_detail_hasil = array(
						'NoTran' => $create_nomor['NomorTransaksi'],
						'Tanggal' => $data['TglTransaksi'],
						'NoLab' => $create_nomor['NomorLab'],
						'Regno' => $data['Regno'],
						'Medrec' => $data['Medrec'],
						'KdGroup' => $tarif_satuan->KdGroup,
						'KDDetail' => $tarif_satuan->KDDetail,
						'NMDetail' => $tarif_satuan->NMDetail,
						'Satuan' => $tarif_satuan->Satuan,
						'NilaiNormal' => $data['KdSex'] == 'L' ? $tarif_satuan->NilaiNormalPria : $tarif_satuan->NilaiNormalWanita,
						'nhasila' => $data['KdSex'] == 'L' ? $tarif_satuan->PemeriksaanAwalPria : $tarif_satuan->PemeriksaanAwalWanita,
						'nhasilb' => $data['KdSex'] == 'L' ? $tarif_satuan->PemeriksaanAkhirPria : $tarif_satuan->PemeriksaanAkhirWanita,
						'keyno' => $create_nomor['NomorTransaksi'].$tarif_satuan->KDDetail.'0000',
						'KdMappingHistori' => $tarif_satuan->KodeMappingHistori
					);
					$parse['alur2'] = '2';

					$parse['alur3'] = '3';
					$save_detail_billing = $this->sv->set($post_detail_billing)->insert('DetailBilPatologi');
					$parse['message_detail_billing'] = 'Masuk Detial Billing';
					// $save_detail_hasil = $this->sv->set($post_detail_hasil)->insert('HasilPatologi');
					// $parse['message_detail_hasil'] = 'Masuk Detial Hasil';
					$input_detail++;
					$parse['message'] = 'Data berhasil masuk';
				}
			}
		} else {
			$parse['message'] = 'Poli gagal diambil, sehingga tidak dapat mengbuat transaksi';
		}
		$parse['input_detail'] = $input_detail;
		$parse['input_detail_hasil'] = $input_detail_hasil;
		return $parse;
	}

	public function delete_billing_laboratorium($notransaksi)
	{
		$delete_hasil_detail = $this->sv->where('NoTran', $notransaksi)->delete('HasilPatologi');
		if ($delete_hasil_detail) {
			$delete_detail = $this->sv->where('NoTran', $notransaksi)->delete('DetailBilPatologi');
		}
		$delete_hasil_head = $this->sv->where('Notran', $notransaksi)->delete('HasilPatologi');
		if ($delete_hasil_head) {
			$delete_head = $this->sv->where('NoTran', $notransaksi)->delete('HeadBilPatologi');
		}
		$parse = array(
			'head' => $delete_head,
			'detail' => $delete_detail,
			'head_hasil' => $delete_hasil_head,
			'detail_hasil' => $delete_hasil_detail
		);
		return $parse;
	}

	public function delete_billing_laboratorium_one($data)
	{
		$cekhead = $this->sv->select('*')->from('DetailBilPatologi')->where('NoTran', $data['NomorTransaksi'])->get()->result();
		if (count($cekhead) > 0) {
			$get_kddetail = $this->sv->select('tarif.KDTarif, tarif.Sarana, tarif.Pelayanan, tarif.Tarif, tarif.KDDetail, pemeriksaan.KdGroup, grouplab.NmGroup, pemeriksaan.NMDetail, 
					pemeriksaan.Satuan, 
					pemeriksaan.NilaiNormalPria, 
					pemeriksaan.NilaiNormalWanita, 
					detailpemeriksaan.KodeDetail, 
					detailpemeriksaan.NamaDetail, 
					detailpemeriksaan.NilaiNormalPria as detailpemeriksaanNilaiNormalPria, 
					detailpemeriksaan.NilaiNormalWanita as detailpemeriksaanNilaiNormalWanita, 
					detailpemeriksaan.NNAwalPria as detailpemeriksaanNNAwalPria, 
					detailpemeriksaan.NNAkhirPria as detailpemeriksaanNNAkhirPria, 
					detailpemeriksaan.NNAwalWanita as detailpemeriksaanNNAwalWanita, 
					detailpemeriksaan.NNAkhirWanita as detailpemeriksaanNNAkhirWanita,
					detailpemeriksaan.Satuan as detailpemeriksaanSatuan,
					detailpemeriksaan.KdMappingHistori as detailpemeriksaanKodeMappingHistori')
					->from('fTarifPatologi tarif')
					->join('fPemeriksaanPatologi pemeriksaan', 'tarif.KDDetail = pemeriksaan.KDDetail')
					->join('DetailPemeriksaan detailpemeriksaan', 'tarif.KDDetail = detailpemeriksaan.KDDetail', 'LEFT')
					->join('fGroupPatologi grouplab', 'pemeriksaan.KdGroup = grouplab.KDGroup')
					->where('tarif.KDTarif', $data['KdTarif'])->get()->result();
			foreach ($get_kddetail as $key => $l) {
				$delete_detail_hasil_one = $this->sv->where('NoTran', $data['NomorTransaksi'])->like('KDDetail', $l->KDDetail)->delete('HasilPatologi');
			}
			$delete_one = $this->sv->where('NoTran', $data['NomorTransaksi'])->where('KdTarif', $data['KdTarif'])->delete('DetailBilPatologi');
			$params = array (
				'TotalBiaya' => $data['Total'],
				'Jumlah' => $data['Total']);
			$updated = $this->sv->where('NoTran', $data['NomorTransaksi'])->update('HeadBilPatologi', $params);

			$check_empty = $this->sv->select('*')->from('DetailBilPatologi')->where('NoTran', $data['NomorTransaksi'])->get()->result();
			if (empty($check_empty)) {
				$delete_one = $this->delete_billing_laboratorium($data['NomorTransaksi']);
			}
		}

		return $delete_one;
	}

	public function update_total_biaya($data)
	{
		$check = $this->sv->select('*')->from('HeadBilPatologi')->where('NoTran', $data['NomorTransaksi'])->get()->result();
		if (!empty($check)) {
			$params = array (
				'TotalBiaya' => $data['Total'],
				'Jumlah' => $data['Total']);
			$updated = $this->sv->where('NoTran', $data['NomorTransaksi'])->update('HeadBilPatologi', $params);
		}

		return $check;
	}

	public function create_pemeriksaan_baru($data)
	{
		$input_detail = 0;
		$input_detail_hasil = 0;
		$tarif_satuan = $this->sv->select('tarif.KDTarif, tarif.Sarana, tarif.Pelayanan, tarif.Tarif, tarif.KDDetail, pemeriksaan.KdGroup, grouplab.NmGroup, pemeriksaan.NMDetail, pemeriksaan.NilaiNormalPria, pemeriksaan.NilaiNormalWanita, pemeriksaan.Satuan, detailpemeriksaan.KodeDetail, detailpemeriksaan.NamaDetail, detailpemeriksaan.NilaiNormalPria as detailpemeriksaanNilaiNormalPria, detailpemeriksaan.NilaiNormalWanita as detailpemeriksaanNilaiNormalWanita, detailpemeriksaan.Satuan as detailpemeriksaanSatuan')
			->from('fTarifPatologi tarif')
			->join('fPemeriksaanPatologi pemeriksaan', 'tarif.KDDetail = pemeriksaan.KDDetail')
			->join('DetailPemeriksaan detailpemeriksaan', 'tarif.KDDetail = detailpemeriksaan.KDDetail', 'LEFT')
			->join('fGroupPatologi grouplab', 'pemeriksaan.KdGroup = grouplab.KDGroup')
			->where('pemeriksaan.KDDetail', $data['kddetail'])->limit(1)->get()->row();

		// var_dump($tarif_satuan);die();
		$pasien = $this->sv->select('*')->from('Register')->where('Regno', $data['regno'])->get()->row();
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
			'Tanggal' => date('Y-m-d'),
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
		// $save_detail_hasil = $this->sv->set($post_detail_hasil)->insert('HasilPatologi');
		// $parse['message_detail_hasil'] = 'Masuk Detial Hasil';
		$input_detail++;

		return $parse;
	}

	public function create_new_pemeriksaan($data)
	{
		$input_detail = 0;
		$input_detail_hasil = 0;
		$cek_kd_mapping = $this->sv->select('*')->from('fPemeriksaanPatologi')->where('KdMapping', $data['kdmapping'])->get()->row();
		if (!empty($cek_kd_mapping)) {
			$cek_pemeriksaan = $this->sv->select('*')->from('HeadBilPatologi')->where('NoTran', $data['NomorTransaksi'])->get()->row();
			if (empty($cek_pemeriksaan)) {
				$pasien = $this->sv->select('*')->from('Register')->where('Regno', $data['Regno'])->get()->row();
				$dokter = $this->sv->select('*')->from('FtDokter')->where('KdDoc', $data['KdPengirim'])->get()->row();

				// Parameter
				$post_head_billing = array(
					'NoTran' => $data['NomorTransaksi'],
					'Tanggal' => $data['TglTransaksi'],
					'Jam' => $data['JamTransaksi'],
					'NoLab' => $data['NomorLab'],
					'TglSelesai' => $data['TglSelesai'],
					'JamSelesai' => $data['JamSelesai'],
					'Regno' => $data['Regno'],
					'Regdate' => $data['Regdate'],
					'MedRec' => $data['Medrec'],
					'Firstname' => $pasien->Firstname,
					'Sex' => $data['KdSex'] == 'L' ? 'Laki-laki' : 'Perempuan',
					'UmurThn' => $data['UmurThn'],
					'UmurBln' => $data['UmurBln'],
					'UmurHari' => $data['UmurHari'],
					'KdBangsal' => $data['KdBangsal'],
					'KdKelas' => $data['KdKelas'],
					'KdDoc' => $data['KdPengirim'] ?? '',
					'NmDoc' => $dokter->NmDoc ?? '',
					'KdPoli' => $data['KdPoli'],
					'KdCbayar' => $data['KdCBayar'],
					'KdJaminan' => $data['KdJaminan'],
					'Jumlah' => $data['JumlahBiaya'],
					'TotalBiaya' => $data['JumlahBiaya'],
					'Shift' => '1',
					'ValidUser' => $this->session->userdata('username').' '.date('d/m/Y H:i:s'),
					'Kategori' => $data['Kategori'],
					'nStatus' => $data['Status'],
					'nJenis' => $data['Jenis'],
					'KdDokter' => $data['KdPemeriksa']
				);

				$post_head_hasil = array(
					'Notran' => $data['NomorTransaksi'],					
					'Regno' => $data['Regno'],
					'RegDate' => $data['Regdate'],
					'MedRec' => $data['Medrec'],
					'Firstname' => $pasien->Firstname,
					'Sex' => $data['KdSex'] == 'L' ? 'Laki-laki' : 'Perempuan',
					'UmurThn' => $data['UmurThn'].'-'.$data['UmurBln'].'-'.$data['UmurHari'],
					'ValidUser' => $this->session->userdata('username').' '.date('d/m/Y H:i:s'),
					'TglHasil'   => date('Y-m-d'),
					'JamHasil'   => date('H:i:s'),
					'KdDoc'      => $data['KdPemeriksa']				
				);

				$cek_transaksi = $this->sv->select('*')->from('HeadBilPatologi')->where('NoTran', $data['NomorTransaksi'])->get()->row();
				if (empty($cek_transaksi)) {
					$save_head_billing = $this->sv->set($post_head_billing)->insert('HeadBilPatologi');
					// $save_head_hasil = $this->sv->set($post_head_hasil)->insert('HasilPatologi');
				} else {
					$update_head_billing = $this->sv->where('NoTran', $data['NomorTransaksi'])->update('HeadBilPatologi', $post_head_billing);
				}

				// lab Satuan
				$tarif_satuan = $this->sv->select('tarif.KDTarif, tarif.Sarana, tarif.Pelayanan, tarif.Tarif, tarif.KDDetail, pemeriksaan.KdGroup, grouplab.NmGroup, pemeriksaan.NMDetail, 
					pemeriksaan.Satuan,
					pemeriksaan.NilaiNormalPria, 
					pemeriksaan.NilaiNormalWanita, 
					pemeriksaan.NNAwalPria as PemeriksaanAwalPria, 
					pemeriksaan.NNAkhirPria as PemeriksaanAkhirPria, 
					pemeriksaan.NNAwalWanita as PemeriksaanAwalWanita, 
					pemeriksaan.NNAkhirWanita as PemeriksaanAkhirWanita,
					pemeriksaan.KdMappingHistori as KodeMappingHistori,
					pemeriksaan.KdInput as KdInput,
					detailpemeriksaan.KodeDetail, detailpemeriksaan.NamaDetail, 
					detailpemeriksaan.NilaiNormalPria as detailpemeriksaanNilaiNormalPria, 
					detailpemeriksaan.NilaiNormalWanita as detailpemeriksaanNilaiNormalWanita, 
					detailpemeriksaan.Satuan as detailpemeriksaanSatuan,
					detailpemeriksaan.NNAwalPria as detailpemeriksaanNNAwalPria, 
					detailpemeriksaan.NNAkhirPria as detailpemeriksaanNNAkhirPria, 
					detailpemeriksaan.NNAwalWanita as detailpemeriksaanNNAwalWanita, 
					detailpemeriksaan.NNAkhirWanita as detailpemeriksaanNNAkhirWanita,
					detailpemeriksaan.KdMappingHistori as detailpemeriksaanKodeMappingHistori,
					detailpemeriksaan.KdInput as detailpemeriksaanKdInput,')
					->from('fTarifPatologi tarif')
					->join('fPemeriksaanPatologi pemeriksaan', 'tarif.KDDetail = pemeriksaan.KDDetail')
					->join('DetailPemeriksaan detailpemeriksaan', 'tarif.KDDetail = detailpemeriksaan.KDDetail', 'LEFT')
					->join('fGroupPatologi grouplab', 'pemeriksaan.KdGroup = grouplab.KDGroup')
					->where('pemeriksaan.KdMapping', $data['kdmapping']);
				if ($data['Kategori'] != '') {
					$tarif_satuan = $tarif_satuan->where('tarif.Kategori', $data['Kategori']);
				}
				if ($data['KdKelas'] != '') {
					$tarif_satuan = $tarif_satuan->where('tarif.KdKelas', $data['KdKelas']);
				}
				$tarif_satuan = $tarif_satuan->get()->row();
				if (empty($tarif_satuan)) {
					return $parse = array(
						'status' => false,
						'message' => 'Tarif tidak ditemukan');
				}

				$post_detail_billing = array(
					'NoTran' => $data['NomorTransaksi'],
					'Tanggal' => $data['TglTransaksi'].' '.date('H:i'),
					'Regno' => $data['Regno'],
					'MedRec' => $data['Medrec'],
					'KdPemeriksaan' => $tarif_satuan->KDDetail,
					'KdTarif' => $tarif_satuan->KDTarif,
					'NmTarif' => $tarif_satuan->NMDetail,
					'Sarana' => $tarif_satuan->Sarana,
					'Pelayanan' => $tarif_satuan->Pelayanan,
					'JumlahBiaya' => $tarif_satuan->Tarif,
					'nCover' => '0',
					'Shift' => '1',
					'ValidUser' => $this->session->userdata('username').' '.date('d/m/Y H:i:s'),
					'KdDokter' => $data['KdPemeriksa']
				);

				$nilainormal = $tarif_satuan->NilaiNormalPria == $tarif_satuan->NilaiNormalWanita ? $tarif_satuan->NilaiNormalPria : 'P: '.$tarif_satuan->NilaiNormalPria.' W:'.$tarif_satuan->NilaiNormalWanita;

				$post_detail_hasil = array(
					'NoTran' => $data['NomorTransaksi'],
					'Tanggal' => $data['TglTransaksi'].' '.date('H:i'),
					'NoLab' => $data['NomorLab'],
					'Regno' => $data['Regno'],
					'Medrec' => $data['Medrec'],
					'KdGroup' => $tarif_satuan->KdGroup,
					'KDDetail' => $tarif_satuan->KDDetail,
					'NMDetail' => $tarif_satuan->NMDetail,
					'Satuan' => $tarif_satuan->Satuan,
					'NilaiNormal' => $nilainormal,
					'nhasila' => $data['KdSex'] == 'L' ? $tarif_satuan->PemeriksaanAwalPria : $tarif_satuan->PemeriksaanAwalWanita,
					'nhasilb' => $data['KdSex'] == 'L' ? $tarif_satuan->PemeriksaanAkhirPria : $tarif_satuan->PemeriksaanAkhirWanita,
					'keyno' => $data['NomorTransaksi'].$tarif_satuan->KDDetail.date('His'),
					'KdMappingHistori' => $tarif_satuan->KodeMappingHistori,
					'KdInput' => $tarif_satuan->KdInput
				);
				$save_detail_billing = $this->sv->set($post_detail_billing)->insert('DetailBilPatologi');
				// $save_detail_hasil = $this->sv->set($post_detail_hasil)->insert('HasilPatologi');
				$input_detail++;
				$parse['message'] = 'Data berhasil masuk';
				$parse['status'] = true;

			} else {
				// lab Satuan
				$tarif_satuan = $this->sv->select('tarif.KDTarif, tarif.Sarana, tarif.Pelayanan, tarif.Tarif, tarif.KDDetail, pemeriksaan.KdGroup, grouplab.NmGroup, pemeriksaan.NMDetail, 
					pemeriksaan.Satuan,
					pemeriksaan.NilaiNormalPria, 
					pemeriksaan.NilaiNormalWanita, 
					pemeriksaan.NNAwalPria as PemeriksaanAwalPria, 
					pemeriksaan.NNAkhirPria as PemeriksaanAkhirPria, 
					pemeriksaan.NNAwalWanita as PemeriksaanAwalWanita, 
					pemeriksaan.NNAkhirWanita as PemeriksaanAkhirWanita,
					pemeriksaan.KdMappingHistori as KodeMappingHistori,
					pemeriksaan.KdInput as KdInput,
					detailpemeriksaan.KodeDetail, detailpemeriksaan.NamaDetail, 
					detailpemeriksaan.NilaiNormalPria as detailpemeriksaanNilaiNormalPria, 
					detailpemeriksaan.NilaiNormalWanita as detailpemeriksaanNilaiNormalWanita, 
					detailpemeriksaan.Satuan as detailpemeriksaanSatuan,
					detailpemeriksaan.NNAwalPria as detailpemeriksaanNNAwalPria, 
					detailpemeriksaan.NNAkhirPria as detailpemeriksaanNNAkhirPria, 
					detailpemeriksaan.NNAwalWanita as detailpemeriksaanNNAwalWanita, 
					detailpemeriksaan.NNAkhirWanita as detailpemeriksaanNNAkhirWanita,
					detailpemeriksaan.KdMappingHistori as detailpemeriksaanKodeMappingHistori,
					detailpemeriksaan.KdInput as detailpemeriksaanKdInput')
					->from('fTarifPatologi tarif')
					->join('fPemeriksaanPatologi pemeriksaan', 'tarif.KDDetail = pemeriksaan.KDDetail')
					->join('DetailPemeriksaan detailpemeriksaan', 'tarif.KDDetail = detailpemeriksaan.KDDetail', 'LEFT')
					->join('fGroupPatologi grouplab', 'pemeriksaan.KdGroup = grouplab.KDGroup')
					->where('pemeriksaan.KdMapping', $data['kdmapping']);
					if ($data['Kategori'] != '') {
						$tarif_satuan = $tarif_satuan->where('tarif.Kategori', $data['Kategori']);
					}
					if ($data['KdKelas'] != '') {
						$tarif_satuan = $tarif_satuan->where('tarif.KdKelas', $data['KdKelas']);
					}
				$tarif_satuan = $tarif_satuan->get()->row();

				if (empty($tarif_satuan)) {
					return $parse = array(
						'status' => false,
						'message' => 'Tarif tidak ditemukan');
				}

				$post_detail_billing = array(
					'NoTran' => $data['NomorTransaksi'],
					'Tanggal' => $data['TglTransaksi'].' '.date('H:i'),
					'Regno' => $data['Regno'],
					'MedRec' => $data['Medrec'],
					'KdPemeriksaan' => $tarif_satuan->KDDetail,
					'KdTarif' => $tarif_satuan->KDTarif,
					'NmTarif' => $tarif_satuan->NMDetail,
					'Sarana' => $tarif_satuan->Sarana,
					'Pelayanan' => $tarif_satuan->Pelayanan,
					'JumlahBiaya' => $tarif_satuan->Tarif,
					'nCover' => '0',
					'Shift' => '1',
					'ValidUser' => $this->session->userdata('username').' '.date('d/m/Y H:i:s'),
					'KdDokter' => $data['KdPemeriksa']
				);
				// var_dump($post_detail_billing);die();
				$nilainormal = $tarif_satuan->NilaiNormalPria == $tarif_satuan->NilaiNormalWanita ? $tarif_satuan->NilaiNormalPria : 'P: '.$tarif_satuan->NilaiNormalPria.' W:'.$tarif_satuan->NilaiNormalWanita;
				$post_detail_hasil = array(
					'NoTran' => $data['NomorTransaksi'],
					'Tanggal' => $data['TglTransaksi'].' '.date('H:i'),
					'NoLab' => $data['NomorLab'],
					'Regno' => $data['Regno'],
					'Medrec' => $data['Medrec'],
					'KdGroup' => $tarif_satuan->KdGroup,
					'KDDetail' => $tarif_satuan->KDDetail,
					'NMDetail' => $tarif_satuan->NMDetail,
					'Satuan' => $tarif_satuan->Satuan,
					'NilaiNormal' => $nilainormal,
					'nhasila' => $data['KdSex'] == 'L' ? $tarif_satuan->PemeriksaanAwalPria : $tarif_satuan->PemeriksaanAwalWanita,
					'nhasilb' => $data['KdSex'] == 'L' ? $tarif_satuan->PemeriksaanAkhirPria : $tarif_satuan->PemeriksaanAkhirWanita,
					'keyno' => $data['NomorTransaksi'].$tarif_satuan->KDDetail.date('His'),
					'KdMappingHistori' => $tarif_satuan->KodeMappingHistori,
					'KdInput' => $tarif_satuan->KdInput
				);

				$save_detail_billing = $this->sv->set($post_detail_billing)->insert('DetailBilPatologi');
				// $save_detail_hasil = $this->sv->set($post_detail_hasil)->insert('HasilPatologi');

				$input_detail++;
				$parse['message'] = 'Data berhasil masuk';
				$parse['status'] = true;

			}
		} else {
			$parse['message'] = 'Kode tidak ditemukan';
			$parse['status'] = false;
		}

		return $parse;
	}

	public function get_list_custom_print($notransaksi)
	{
		return [
			'bil' => $this->sv
				->select('CONVERT(VARCHAR, bl.Tanggal, 120) AS Tanggal')
				->select('pl.KDDetail')
				->select('pl.NMDetail')
				->where('NoTran', $notransaksi)
				->from('DetailBilPatologi AS bl')
				->join('fPemeriksaanPatologi AS pl', 'bl.KdPemeriksaan=pl.KDDetail')
				->get()->result(),
			'pem' => $this->sv
				->select('CONVERT(VARCHAR, bl.Tanggal, 120) AS Tanggal')
				->select('dl.KodeDetail')
				->select('fpl.KDDetail')
				->where('NoTran', $notransaksi)
				->from('DetailBilPatologi AS bl')
				->join('fPemeriksaanPatologi AS fpl', 'bl.KdPemeriksaan=fpl.KDDetail')
				->join('DetailPemeriksaan AS dl', 'bl.KdPemeriksaan=dl.KDDetail')
				->get()->result()
		];
	}

	function update_diskon($param){
		extract($param);
		$this->sv->trans_start();
		$total = $this->sv->query("SELECT Jumlah AS Total FROM HeadBilPatologi WHERE NoTran=?", [$no_tran])->row('Total');
		$new_total = $total - $diskon;
		$this->sv->where('NoTran', $no_tran)->update('HeadBilPatologi', ['Diskon' => $diskon, 'TotalBiaya' => $new_total]);

		$success = $this->sv->trans_complete();
		return $success ? [
			'FormattedJumlahBiaya' => number_format($new_total, 0, ',', '.'),
		] : FALSE;
	}

	public function get_billing_order_pasien_by_no_trans($no_trans, $list_order = NULL)
	{
		$this->sv->select([
				'h.NoTran',
				'h.Tanggal',
				'h.Jam',
				'h.NoLab',
				'h.NoLab',
				'h.TglHasil',
				'h.JamHasil',
				'h.TglSelesai',
				'h.JamSelesai',
				'h.TotalBiaya',
				'h.Jumlah',
				'h.Diskon',
				'h.Regno',
				'h.Medrec',
				'h.Firstname',
				'h.nStatus',
				'h.nJenis',
				'h.UmurThn',
				'h.UmurBln',
				'h.UmurHari',
				'r.KdCBayar', 'cb.NMCbayar',
				'h.KdJaminan', 'jm.NMJaminan',
				'h.KdPoli', 'pl.NMPoli',
				'h.KdBangsal', 'bl.NmBangsal',
				'h.KdKelas', 'kl.NmKelas',
				'h.Kategori', 'kr.NmKategori',
				'h.KdDoc',
				'h.NmDoc',
				'h.KdDokter', 'dr.NmDoc AS NmDokter', 'h.TglSampel', 'h.AsalSampel', 'h.Setujui', 'h.Verifikasi', 'h.Pengambil_sampel', 'h.Kd_ambil_sampel', 'h.Kd_setujui', 'h.Kd_verif'
			])
			->from('HeadBilPatologiTEMP AS h')
			->join('Register AS r', 'r.Regno=h.Regno', 'LEFT')
			->join('TBLcarabayar AS cb', 'r.KdCBayar=cb.KdCBayar', 'LEFT')
			->join('TBLJaminan AS jm', 'h.KdJaminan=jm.KdJaminan', 'LEFT')
			->join('POLItpp AS pl', 'h.KdPoli=pl.KdPoli', 'LEFT')
			->join('TBLBangsal AS bl', 'h.KdBangsal=bl.KdBangsal', 'LEFT')
			->join('TBLKelas AS kl', 'h.KdKelas=kl.KdKelas', 'LEFT')
			->join('TblKategoriPsn AS kr', 'h.Kategori=kr.KdKategori', 'LEFT')
			->join('FtDokter AS dr', 'h.KdDokter=dr.KdDoc', 'LEFT')
			->where('h.NoTran', $no_trans);
			// ->get()->row();

		if($list_order === TRUE)
		{
			$this->sv->where('h.Tanda !=', 0);
		}
		elseif($list_order === FALSE)
		{
			$this->sv->where('h.Tanda =', 0);
		}

		$billing = $this->sv->get()->row();

		if(empty($billing)) return NULL;

		$billing->usia = $billing->UmurThn.' tahun '.$billing->UmurBln.' bulan '.$billing->UmurHari.' hari';
		$billing->FormattedTglSelesai = $billing->TglSelesai ? date('d/m/Y', strtotime($billing->TglSelesai)) : NULL;
		$billing->FormattedJamSelesai = $billing->JamSelesai ? date('H:i:s', strtotime($billing->JamSelesai)) : NULL;
		$billing->FormattedJumlahBiaya = number_format($billing->TotalBiaya, 0, ',', '.');

		$billing->list_detail = $this->sv
			->select([
				'd.NoTran',
				'd.Tanggal',
				'd.KdPemeriksaan',
				'd.KdTarif',
				'd.NmTarif',
				'd.Sarana',
				'd.Pelayanan',
				'd.Qty',
				'd.JumlahBiaya',
				'FtDokter.NmDoc'
			])
			->from('DetailBilPatologi AS d')
			->join('FtDokter','FtDokter.KdDoc = d.KdDokter', 'left')
			->where('d.NoTran', $no_trans)
			->get()->result();
		return $billing;
	}

	/* ocha */
	public function update_qty_transaksi($regno='', $notran='', $kdtarif='', $qty=''){
		$this->sv->update('DetailBilPatologi', array('Qty'=>$qty), array('Regno'=>$regno, 'NoTran'=>$notran, 'KdTarif'=>$kdtarif));

		$det = $this->sv->select('(Sarana+Pelayanan) * Qty as total')
						->get_where('DetailBilPatologi', array('Regno'=>$regno, 'NoTran'=>$notran, 'KdTarif'=>$kdtarif))->row();
		
		$sql = "WITH temp AS
				(SELECT CASE WHEN Qty IS NULL THEN (Sarana+Pelayanan)*1
										WHEN Qty = '' THEN (Sarana+Pelayanan)*1
										ELSE (Sarana+Pelayanan)*Qty
										END 'total'
				FROM DetailBilPatologi
				WHERE NoTran = '$notran')
				
				SELECT SUM(total) as total FROM temp";
		$all = $this->sv->query($sql)->row();

		$head = $this->sv->get_where('HeadBilPatologi', array('NoTran'=>$notran))->row();
		$dataHead = array(
			'Jumlah' => $all->total,
			'TotalBiaya' => $all->total - $head->Diskon 
		);
		$this->sv->update('HeadBilPatologi', $dataHead, array('NoTran'=>$notran));

		$output = array(
			'item_detail' => 'Rp. '.number_format($det->total, 0, ',', '.'),
			'curr_total' => 'Rp. '.number_format($all->total, 0, ',', '.'),
			'num_item_detail' => $det->total,
			'num_curr_total' => $all->total,
			'curr_total_biaya' => 'Rp. '.number_format($all->total - $head->Diskon, 0, ',','.')
		);

		return $output;
	}
	/* ---- */
}
