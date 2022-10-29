<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_laporan extends CI_Model {
	
	protected $sv;
	function __construct(){
		parent::__construct();
        $this->sv = $this->load->database('server',true);
	}

	public function get_data($tgl_awal, $tgl_akhir, $kode='', $fil_hasil='')
	{
		if ($kode!='') {
			$this->sv->where('I.KdInstansi', $kode);
		}
		if ($fil_hasil!='') {
			$this->sv->like('DH.hasil', $fil_hasil);
		}
		$this->sv->select('HH.*,HB.TglSampel,HB.Tanggal,HB.AsalSampel,HB.Pengambil_sampel,HB.Verifikasi,HB.Setujui,HB.Catatan, UI.NmUnit, pl.NMDetail, I.NmInstansi, CAST(R.Bod AS DATE) as TglLahir, R.phone, dok.NmDoc as pemeriksa, R.Catatan, R.nikktp ');
		$stat = $this->sv->from('HasilPatologi as HH')
				->join('HeadBilPatologi HB', 'HB.Notran= HH.Notran','left' )
				->join('Register R', 'R.Regno= HH.Regno', 'left')
				->join('TBLUnitInstansi UI', 'R.unitInstansi = UI.KdUnit', 'left')
				->join('TBLInstansi I', 'I.KdInstansi= UI.KdInstansi','left')
				->join('FtDokter dok', 'dok.KdDoc = HB.KdDokter', 'left')
				->join('fPemeriksaanPatologi PL', 'HH.KDDetail = PL.KDDetail')
				->where('R.RegDate >=', $tgl_awal)
				->where('R.RegDate <=', $tgl_akhir)->get();
		return $stat->result();	
	}  

	public function get_instansi($kode='')
	{
		if ($kode!='') {
			$this->sv->where('KdInstansi', $kode);
		}
		$this->sv->select('*');
		$stat = $this->sv->from('TBLInstansi')->get();
		return $stat->result();	
	}

	public function get_pil_hasil()
	{
		return $this->sv->select("*")
			->from('TBLHasilMicro')
			->get()->result();
	}

	public function get_head_hasil_pemeriksaan($notran)
	{
		$data = $this->sv->select('head.Notran, register.nikktp as Nik, head.Regno, headbilling.TglSampel, headbilling.AsalSampel, headbilling.Verifikasi, headbilling.Setujui ,head.MedRec, head.RegDate, register.Firstname, register.KdSex, register.KdTuju, register.KdCbayar, head.Umurthn, head.Sex, register.Bod, head.Tglhasil, head.Jamhasil, headbilling.KdDoc, headbilling.NmDoc, headbilling.KdBangsal, bangsal.NmBangsal, kelas.NMkelas, poli.NMPoli, dokter.NmDoc as dokterPemeriksa, master.Address, headbilling.TglSampel, headbilling.AsalSampel, headbilling.kewarganegaraan')->from('HasilPatologi head')
			->join('Register register', 'head.Regno = register.Regno')
			->join('MasterPS master', 'register.Medrec = master.Medrec', 'LEFT')
			->join('HeadBilPatologi headbilling', 'head.Notran = headbilling.NoTran')
			->join("TBLBangsal bangsal", "headbilling.KdBangsal = bangsal.KdBangsal", "LEFT")
			->join("TBLKelas kelas", "headbilling.KdKelas = kelas.KdKelas", "LEFT")
			->join("POLItpp poli", "headbilling.KdPoli = poli.KDPoli", "LEFT")
			->join("FtDokter dokter", "headbilling.KdDokter = dokter.KdDoc", "LEFT")
			->join("TblKategoriPsn kategori", "headbilling.Kategori = kategori.KdKategori", "LEFT")
			->where('head.Notran', $notran)->get()->result();
		return $data;
	}

	public function search_group_print($notran, $custom_detail = NULL)
	{
		$result = [];
		$this->sv->select('detail.KdGroup, g.NmGroup')
			->from('HasilPatologi detail')
			->join('fGroupPatologi g', 'substring(detail.KdGroup, 1, 2) = g.KDGroup', 'LEFT')
			->group_by('detail.KdGroup')->group_by('g.NmGroup')
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

	public function get_dokter_kepala()
	{
		return $this->sv->select("*")
			->from('FtDokter')
			->where('jabatan', 'Kepala Lab')
			->get()->row();
	}

	public function get_fprofile()
	{
		return $this->sv->select("*")
			->from('fProfile')
			->get()->row();
	}

	public function search_detail_print($kdgroup, $nmgroup, $notran, $custom_detail = NULL)
	{
		$this->sv->select([
			'detail.NoTran',
			'detail.Tanggal',
			'detail.keyno',
			'detail.NoLab',
			'detail.KDDetail',
			'detail.NMDetail',
			'detail.Satuan',
			'detail.NilaiNormal',
			'detail.Hasil',
			'detail.nhasila',
			'detail.nhasilb',
			'detail.KdInput'
		])
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

}