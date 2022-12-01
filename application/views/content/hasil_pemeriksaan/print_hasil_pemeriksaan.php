<link rel="stylesheet" href="<?=base_url('assets/new/css/bootstrap.min.css')?>" />
<style type="text/css">
  *{
      font-family: Arial, Helvetica, sans-serif;
      font-size: 12px;
  }

  .top-header {
    font-family: Arial, Helvetica, sans-serif;
    font-weight: bold;
    text-align: center;
/*    width: 220pt;
*/    margin-bottom: 15px;
  }

  .box1 {
    padding: 5px;
    border: 1px solid black;
    border-radius: 5px;
    height: 150px;
  }

  .box2 {
    padding: 5px;
    border: 1px solid black;
    border-radius: 5px;
    height: 130px;
  }

  #tablePemeriksaan {
    width: 95%;
  }
  #tableTtd {
    width: 95%;
  }

  .data-tambahan {
    height: 300px;
  }

  .desc-table td {
    vertical-align: top;
  }
</style>
<?php foreach ($heads as $head): ?>
  <table border="0" width="100%" style="border-bottom: 1px solid black;">
    <tr>
      <td  style="text-align: center; padding-bottom: 10px; padding-right: 40px">
        <img src="<?php echo site_url('assets/images/kopsurat_keprii.png') ?>" height='110px' alt="">
      </td>
    </tr> 
  </table><center> <b style="font-size:22px;">PATALOGI ANATOMI</b></center><br><br>
    
  <div class="main-content">
    <div class="main-content-inner">
      <div class="page-content">
        
        <div class="row">
          <div class="col-xs-12">
            <table class="desc-table" width="100%" style="padding-top: 40px; padding-bottom: 10px;">
              <tr>
                <td width="5%"></td>
                <td width="10%">Nama Pasien</td>
                <td width="5%">:</td>
                <td width="20%"><b><?= $head->Firstname ?></b></td>
                <td width="10%"></td>
                <td width="20%">Jenis Pembayaran</td>
                <td width="5%">:</td>
                <td width="20%"><b><?= $head->NmKategori ?></b></td>
              </tr>
              <tr>
                <td width="5%"></td>
                <td>No. PA</td>
                <td>:</td>
                <td><?= $head->NoTran ?></td>
                <td width="5%"></td>
                <td width="20%">Tanggal Diterima</td>
                <td width="5%">:</td>
                <td width="30%"><b><?= date("d F Y", strtotime($head->TglSampel))?></b></td>
              </tr>
              <tr>
                <td width="5%"></td>
                <td>No RM</td>
                <td>:</td>
                <td><?= $head->MedRec ?></td>
                <td width="5%"></td>
                <td>Tanggal Dijawab</td>
                <td>:</td>
                <td><?= date("d F Y", strtotime($head->TglHasil)) ?></td>
              </tr>
              <tr>
                <td width="5%"></td>
                <td>Tanggal Lahir</td>
                <td>:</td>
                <td><?= date("d F Y", strtotime($head->Bod)) ?></td>
                <td width="5%"></td>
                <td>Dokter Pengirim</td>
                <td>:</td>
                <td><?= $head->NmDoc ?></td>
              </tr>
              <tr>
                <td width="5%"></td>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td><?= $head->Sex ?></td>
                <td width="5%"></td>
                <td>Ruang / Poli</td>
                <td>:</td>
                <td><?= $head->NmBangsal ? $head->NmBangsal : $head->NMPoli ?></td>
              </tr>
              <tr>
                <td width="5%"></td>
                <td>Jenis Pemeriksaan</td>
                <td>:</td>
                <td><?= $head->NmGroup ?></td>
                <td width="5%"></td>
                <td>Biaya Pemeriksaan</td>
                <td>:</td>
                <td><?= number_format($head->Tarif)  ?></td>
              </tr>
            </table>
            <hr width="100%">
          </div>
          <div class="col-lg-12" style="margin-top: 5px;">
            <div class="top-header">
              <h4>HASIL PEMERIKSAAN</h4><br>
            </div>
            <div class="data-pemeriksaan">
              <table id="tablePemeriksaan" align="center">
                <tbody>
                  <?php if ($head->KdGroup != 6): ?>
                    <tr><td style="padding:10px;">
                      <b>Keterangan Klinik :</b>
                    </td></tr>
                    <tr><td  style="padding:10px;"><?=$head->Hasil_KetKlinik ?></td></tr>
                    <tr><td>
                      <b>Pemeriksaan Makroskopis :</b>
                    </td></tr>
                    <tr><td  style="padding:10px;"><?=$head->Hasil_PemMakro ?></td></tr>
                    <tr><td>
                      <b>Pemeriksan Mikroskopis :</b>
                    </td></tr>
                    <tr><td  style="padding:10px;"><?=$head->Hasil_PemMikro ?></td></tr>
                    <tr><td>
                      <b>Kesimpulan :</b>
                    </td></tr>
                    <tr><td  style="padding:10px;"><?=$head->Hasil_Kesimpulan ?></td></tr>
                    <tr><td>
                      <b>Anjuran :</b>
                    </td></tr>
                    <tr><td  style="padding:10px;"><?=$head->Hasil_Anjuran ?></td></tr>
                  <?php else: ?>
                    <tr><td>
                      <b>Data Awal :</b>
                    </td></tr>
                    <tr><td  style="padding:10px;"><?=$head->Hasil_Datawal ?></td></tr>
                    <tr><td>
                      <b>Data Hasil Immunohistokimia :</b>
                    </td></tr>
                    <tr><td  style="padding:10px;"><?=$head->Hasil_Imuno ?></td></tr>
                    <tr><td>
                      <b>Hasil Pemeriksaan :</b>
                    </td></tr>
                    <tr><td  style="padding:10px;"><?=$head->Hasil_pemImuno ?></td></tr>
                  <?php endif ?>
                </tbody>
              </table>
            </div>
            <br><br>
            <?php if($pengesahan == 'ttd'):?>
              <table id="tableTtd" border="0">
                <tr>
                  <td style="text-align: center; width: 30%; display: none" >Dokter</td>
                  <td></td>
                  <td style="text-align: center; width: 40%;">Jakarta, <?= $tgl_ttd ?></td>
                </tr>
                <tr>
                  <td style="padding-bottom: 50px; text-align: center; width: 30%; display: none" >Dokter</td>
                  <td></td>
                  <td style="padding-bottom: 50px; text-align: center; width: 40%;">Dokter Pemeriksa</td>
                </tr>
                <tr>
                  <td style="text-align: center; width: 30%; display: none;">(dr.Primatia.S, Sp.PK)</td>
                  <td></td>
                  <!-- <td style="text-align: center; width: 40%;"><u><?= $fdokter->NmDoc ?></u><br><span style="font-size: 10px; font-family: "><?= $fdokter->korps_ttd ?></span></td> -->
                   <td style="text-align: center; width: 40%;"><u> d r .   &nbsp; N u n i k &nbsp; U t a m i  &nbsp; S p . M K</u><br><span style="font-size: 7.5px; font-family: "><?= isset($fdokter) ? $fdokter->korps_ttd : '-' ?></span></td>
                </tr>
              </table>
            <?php else: ?>
              <table id="tableTtd" border="0">
                <tr>
                  <td style="padding-top: 90px; text-align: center; width: 30%; display: none;"></td>
                  <td></td>
                  <td style="text-align: center; width: 40%;">Jakarta, <?= $tgl_ttd ?> <br> Dokter Pemeriksa <br><br>
                    <img src="<?php echo site_url('assets/qr/'.$qr) ?>" width="110px" height='110px' alt="">
                  </td>
                </tr>
                <tr>
                  <td style="text-align: center; width: 30%; display: none;"></td>
                  <td><br></td>
                  <td style="padding-bottom: 50px; text-align: center; width: 40%;"><br><?=  isset($fdokter) ? $fdokter->NmDoc : '-' ?><br></td>
                </tr>
              </table>
            <?php endif ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endforeach ?>

