<link rel="stylesheet" href="<?=base_url('assets/new/css/bootstrap.min.css')?>" />
<style type="text/css">
  *{
      font-family: Arial, Helvetica, sans-serif;
      font-size: 12px;
  }

  .top-header {
    font-family: Arial, Helvetica, sans-serif;
    text-align: center;
    width: 170pt;
    margin-bottom: 15px;
  }
  .center-header {
    font-family: Arial, Helvetica, sans-serif;
    text-align: center;
    margin-bottom: 15px;
  }

  .box1 {
    padding: 5px;
    border: 1px solid black;
    border-radius: 5px;
    height: 120px;
  }

  .box2 {
    padding: 5px;
    border: 1px solid black;
    border-radius: 5px;
    height: 120px;
  }

  #tablePemeriksaan {
    width: 95%;
    border: 1px black solid;
    margin: 5px;
  }

  #tablePemeriksaan th td{
    padding: 10px;
  }

  .data-tambahan {
    height: 300px;
  }

  .desc-table td {
    vertical-align: top;
  }
</style>
    
<table border="0" width="100%" style="border-bottom: 1px solid black;">
  <tr>
    <td width="80%" style="text-align: right; padding-bottom: 30px; padding-right: 40px">
      <img src="<?php echo site_url('assets/images/kopsurat_keprii.png') ?>" height="110px" alt="">
    </td>
    <td width="20%"></td>
  </tr> 
</table><br>
<div class="main-content">
  <div class="main-content-inner">
    <div class="page-content">
      <div class="row">

        <div class="col-xs-12">
          <div class="center-header" >
              HASIL PEMERIKSAAN REAL TIME PCR SARS CoV 2<br>
              LAB. PATOLOGI ANATOMI KLINIK RSUD RAJA AHMAD TABIB
            </div>
        </div>
        <br><br>
        <div class="col-lg-12" style="margin-top: 50px;">
          <div class="data-pemeriksaan">
            <table id="tablePemeriksaan" border="1" width="100%" style="text-align: center;">
              <thead>
                <tr>
                  <th style=" width: 42px; text-align: center; float: center; padding-top: 10px; padding-bottom: 10px; font-size: 11px; font-family: arial; ">NO</th>
                  <th style=" width: 72px; text-align: center; font-size: 10px; line-height: 0.3cm;" >NO <br> LAB</th>
                  <th style="width : 113px; text-align: center; font-size: 10px; " >NAMA</th>
                  <th style="width : 56.6px; text-align: center; font-size: 10px;" >UMUR</th>
                  <th style="width : 98px; text-align: center; font-size: 10px; line-height: 0.3cm;" >JENIS <br> KELAMIN</th>
                  <th style="width : 113px; text-align: center; font-size: 10px; line-height: 0.3cm;" >TANGGAL <br> PENGAMBILAN SPESIMEN</th>
                  <th style="width : 105.8px; text-align: center; font-size: 10px; line-height: 0.3cm;" >JENIS <br>SPESIMEN</th>
                  <th style="width : 102px; text-align: center; font-size: 10px; line-height: 0.3cm;" >HASIL <br> PEMERIKSAAN</th>
                </tr>
              </thead>
              <tbody>
                <?php $a=1; for ($i=0; $i < count($detail); $i++):?>
                <tr >
                  <td style="width: 42px; text-align: center; float: center; padding-top: 34px; padding-bottom: 34px;"><?=$a++?></td>
                  <td style="width: 72px; text-align: center; float: center;"><?= $head->Nolab ?></td>
                  <td style="width: 113px; text-align: center; float: center;"><?= $head->Firstname ?></td>
                  <td style="width: 56.6px; text-align: center; float: center;"><?php $now = new DateTime(); $brt = new DateTime($head->Bod); $interval = $now->diff($brt); echo $interval->y; ?> Tahun</td>
                  <td style="width: 98px; text-align: center; float: center;"><?= $head->Sex ?></td>
                  <td style="width: 113px; text-align: center; float: center;"><?= date("d-m-Y", strtotime($head->TglSampel)) ?></td>
                  <td style="width: 105.8px; text-align: center; float: center;"><?= $head->AsalSampel ?></td>
                  <?php foreach ($detail[$i]['detail'] as $d): ?>
                    <?php if (($d->Hasil != '' && $d->KdInput != '4') || ($d->KdInput == '4' && $d->Hasil == '')): ?>
                        <td style="width: 102px; font-size: 13px;text-align: center;"><b>
                          <?php $hasil = $d->Hasil;  
                          if($hasil == 'Terdeteksi (Positif)'){
                            $hasil = 'Terdeteksi (Positif)';
                          }else {$hasil = 'Tidak Terdeteksi (Negatif)';}?>
                          <?= $hasil ?></b>
                        </td>
                    <?php endif; ?>
                  <?php endforeach?>
                </tr>
                <?php endfor?>
              </tbody>
            </table>
          </div>
            <?php if (!empty($head->Ct_value)): ?>
            <p style="margin-top: 15px; margin-left: 15px;">CT Value: <?=$head->Ct_value ?></p>
            <?php endif ?>

          <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-11">
              <table cellpadding="5" style="border: 0px; padding: 5px auto; margin-top: 40px;">
                <tr>
                  <td width="30%" style="padding-top:5px; padding-bottom: 5px">Diperiksa Oleh</td>
                  <td width="5%"> : </td>
                  <td width="65%"><?= $head->Setujui?> </td>
                </tr>
                <tr>
                  <td width="30%" style="padding-top:5px; padding-bottom: 5px">Diverifikasi Oleh</td>
                  <td width="5%"> : </td>
                  <td width="65%"><?= $head->Verifikasi ?></td>
                </tr>
                <tr>
                  <td width="30%" style="padding-top:5px; padding-bottom: 5px">Disetujui Oleh</td>
                  <td width="5%"> : </td>
                  <td width="65%"><?= $head->dokterPemeriksa ?></td>
                </tr>
              </table>
            </div>
          </div>
          <br><br>
          <div class="col-lg-12">
            <table style="border: 0px;" width="100%">
                <tr>
                  <td width="50%"></td>
                  <td width="50%" align="center">
                    <table style="border: 0px; text-align: center;">
                      <tr>
                        <td>Jakarta, <?= $tgl_ttd ?> </td>
                      </tr>
                      <tr>
                        <td>Kepala <?= $profil->Keterangan ?>,
                          <br><br><br><br><br><br></td>
                      </tr>
                      <tr>
                        <td><?= $profil->rs_kepala ?></td>
                      </tr>
                      <tr>
                        <td><?=$profil->rs_kepala_korps?></td>
                      </tr>
                    </table>
                  </td>
                </tr>
            </table>
          </div>
          <br><br><br><br><br><br>
          <div class="data-tambahan" style="margin-top: 50px;">
            <p>Keterangan </p>
            <p>- Hasil di atas hanya menggambarkan kondisi pada saat pengambilan sampel.<br>
            - Hasil negatif belum dapat menyingkirkan kemungkinan adanya infeksi SARS CoV-2.<br>
            - Bila positif lakukan isolasi mandiri dan terpantau.<br>
            - Tetap melakukan “MASTAGAR” (Gunakan masker, cuci tangan sesering mungkin dengan sabun atau handrub, <br> &nbsp;&nbsp;jaga jarak dan hindari keramaian serta berperilaku sehat).<br>
            - Bila ada keluhan konsultasikan dengan dokter keluarga anda atau klinik kesehatan/RS terdekat.</p>

            <br>
            <?php if($infocvd19 == 'show'):?><p><i>Keterangan Hasil Rapid Test Covid-19: <br><br>
            1. Hasil Non-Reaktif belum dapat menyingkirkan kemungkinan adanya infeksi, sehingga masih beresiko menularkan ke orang lain.
            Hasil Non-Reaktif dapat terjadi karena beberapa kondisi : Window period ( terinfeksi namun antibody belum terbentuk ), 
            terdapat gangguan pembentukan antibody (immunocompromised) atau kadar antibody dibawah deteksi alat. <br>
            2. Lakukan pemeriksaan ulang anti SARS-CoV-2 10 Hari kemudian apabila baru pertama kali melakukan pemeriksaan. <br>
            3. Hasil pemeriksaan antibody tidak digunakan sebagai dasar untuk mendiagnosa infeksi SARS-CoV-2, Status Pasien, atau keputusan klinis. <br>
            4. Lakukan karantina mandiri dengan menuggunakan masker, cuci tangan sesering mungkin menggunakan sabun, jaga jarak dan hindari keramaian serta berperilaku hidup sehat.</i></p><br>
            <?php endif?>
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>
