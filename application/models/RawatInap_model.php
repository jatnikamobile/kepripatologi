<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RawatInap_model extends CI_Model {
	
	protected $sv;
	function __construct(){
		parent::__construct();
        $this->sv = $this->load->database('server',true);
        $this->load->model("Master_model","mm");
	}
    // datatable list pasien
    private function _dt_list_pasien($regdate='', $medrec='', $nama='', $regno='', $kd_bangsal='', $dokter='',$set='')
    {
        $begindate = date("Y-m-d");
        $this->column_order = array(null, "MasterPS.Medrec", "FPPRI.Regno", "FPPRI.Regdate", "FPPRI.Firstname", "FPPRI.Regtime",
                                    "FPPRI.KdCbayar", "TBLcarabayar.NMCbayar", "FPPRI.KdJaminan", "TBLJaminan.NMJaminan",
                                    "DetailPindah.KdBangsal", "FPPRI.KdPoli", "POLItpp.NMPoli","FPPRI.Kategori", "FPPRI.KdIcd",
                                    "TBLBangsal.NmBangsal", "FPPRI.KdKelas", "TBLKelas.NmKelas", "FPPRI.nokamar",
                                    "DetailPindah.NoTTidur", "DetailPindah.KdDoc", "MasterPS.Address", "TblKategoriPsn.NmKategori",
                                    "FtDokter.NmDoc", "TBLICD10.DIAGNOSA");
        $this->column_search = array("MasterPS.Medrec", "FPPRI.Regno", "FPPRI.Regdate", "FPPRI.Firstname", "FPPRI.Regtime",
                                    "FPPRI.KdCbayar", "TBLcarabayar.NMCbayar", "FPPRI.KdJaminan", "TBLJaminan.NMJaminan",
                                    "DetailPindah.KdBangsal", "FPPRI.KdPoli", "POLItpp.NMPoli","FPPRI.Kategori", "FPPRI.KdIcd",
                                    "TBLBangsal.NmBangsal", "FPPRI.KdKelas", "TBLKelas.NmKelas", "FPPRI.nokamar",
                                    "DetailPindah.NoTTidur", "DetailPindah.KdDoc", "MasterPS.Address", "TblKategoriPsn.NmKategori",
                                    "FtDokter.NmDoc", "TBLICD10.DIAGNOSA");
        $this->order = array('FPPRI.Regdate' => 'DESC');

        $this->sv->select("MasterPS.Medrec, FPPRI.Regno, FPPRI.Regdate, FPPRI.Firstname, FPPRI.Regtime,
                           FPPRI.KdCbayar, TBLcarabayar.NMCbayar, FPPRI.KdJaminan, TBLJaminan.NMJaminan,
                           DetailPindah.KdBangsal, FPPRI.KdPoli, POLItpp.NMPoli,FPPRI.Kategori, FPPRI.KdIcd,
                           TBLBangsal.NmBangsal, FPPRI.KdKelas, TBLKelas.NmKelas, DetailPindah.NoKamar,
                           DetailPindah.NoTTidur, DetailPindah.KdDoc, MasterPS.Pod, MasterPS.Bod,
                           MasterPS.Address, TblKategoriPsn.NmKategori, FPPRI.Sex,
                           FtDokter.NmDoc, TBLICD10.DIAGNOSA Diagnosa, FPPRI.ValidUser")
                ->from("FPPRI")
                ->join("MasterPS", "FPPRI.Medrec = MasterPS.Medrec", "INNER")
                ->join("TblKategoriPsn", "FPPRI.Kategori = TblKategoriPsn.KdKategori", "INNER")
                ->join("DetailPindah", "FPPRI.Regno = DetailPindah.Regno", "INNER")
                ->join("TBLcarabayar", "FPPRI.KdCbayar = TBLcarabayar.KDCbayar", "LEFT")
                ->join("TBLJaminan", "FPPRI.KdJaminan = TBLJaminan.KDJaminan", "LEFT")
                ->join("POLItpp", "FPPRI.KdPoli = POLItpp.KDPoli", "LEFT")
                ->join("TBLBangsal", "DetailPindah.KdBangsal = TBLBangsal.KdBangsal", "LEFT")
                ->join("TBLKelas", "DetailPindah.KdKelas = TBLKelas.KdKelas", "LEFT")
                ->join("FtDokter", "DetailPindah.KdDoc = FtDokter.KdDoc", "LEFT")
                ->join("TBLICD10", "FPPRI.KdIcd = TBLICD10.KDICD", "LEFT")
                ->where("FPPRI.Status", 0)
                ->where("CAST(FPPRI.Regdate AS DATE) <=", $begindate)
                ->where("FPPRI.Regno NOT IN (SELECT Regno FROM FPulang WHERE Tanggal <= '$begindate')");
        if ($regno != '') { $this->sv->where('FPPRI.Regno', $regno); }
        if ($regdate != '') { $this->sv->where("FPPRI.Regdate", $regdate); }
        if ($kd_bangsal != '' && $kd_bangsal != '99') { $this->sv->where('DetailPindah.KdBangsal', $kd_bangsal); }
        if ($medrec != '') { $this->sv->like('FPPRI.Medrec', $medrec); }
        if ($nama != '') { $this->sv->like('FPPRI.Firstname', $nama); }
        if ($dokter != '') { $this->sv->where('DetailPindah.KdDoc', $dokter); }

        $i = 0;
        foreach ($this->column_search as $item) // loop column
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                if($i===0) // first loop
                {
                    $this->sv->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->sv->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->sv->or_like($item, $_POST['search']['value']);
                }
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->sv->group_end(); //close bracket
            }
            $i++;
        }
        if(isset($_POST['order'])) // here order processing
        {
            $this->sv->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->sv->order_by(key($order), $order[key($order)]);
        }
    }

    public function list_pasien($regdate='', $medrec='', $nama='', $regno='', $kd_bangsal='', $dokter='',$set='')
    {
        $this->_dt_list_pasien($regdate, $medrec, $nama, $regno, $kd_bangsal, $dokter, $set);
        if($_POST['length'] != -1) $this->sv->limit($_POST['length'], $_POST['start']);
        $query = $this->sv->get()->result();
        return $query;
    }

    public function count_filtered_list_pasien($regdate='', $medrec='', $nama='', $regno='', $kd_bangsal='', $dokter='',$set='')
    {
        $this->_dt_list_pasien($regdate, $medrec, $nama, $regno, $kd_bangsal, $dokter,$set);
        $query = $this->sv->get();
        return $query->num_rows();
    }

    public function count_all_list_pasien($kd_bangsal='',$medrec='',$set='')
    {
        $this->sv->from("FPPRI");
        if($set == 'riwayat' && $medrec != ''){
            $this->sv->where("Medrec",$medrec);
        }else{
            $this->sv->where("YEAR(Regdate)", date('Y'));
        }
        return $this->sv->count_all_results();
    }
}
