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
<table border="0" width="100%" style="border-bottom: 1px solid black;">
  <tr>
    <td width="100%" style="text-align: right; padding-bottom: 10px; padding-right: 40px">
      <img src="<?php echo site_url('assets/images/kopsurat_keprii.png') ?>" height="110px" alt="">
    </td>
  </tr> 
</table><br>
  
<div class="main-content">
  <div class="main-content-inner">
    <div class="page-content">
      <div class="row">
        <div class="col-xs-12">
          <table class="desc-table" width="100%" style="padding-top: 40px; padding-bottom: 10px;">
            <tr>
              <td width="5%"></td>
              <td width="20%">Name</td>
              <td width="5%">:</td>
              <td width="70%"><b><?= $head->Firstname ?></b></td>
            </tr>
            <tr>
              <td width="5%"></td>
              <td>Lab. Number</td>
              <td>:</td>
              <td><?= $head->Nolab ?></td>
            </tr>
            <tr>
              <td width="5%"></td>
              <td>Passport Number</td>
              <td>:</td>
              <td><?= $head->Nik?></td>
            </tr>
            <tr>
              <td width="5%"></td>
              <td>Gender</td>
              <td>:</td>
              <td><?php if ($head->Sex == 'Perempuan') {
                $gender='Female'; 
              }else{$gender='Male';} echo $gender; ?></td>
            </tr>
            <tr>
              <td width="5%"></td>
              <td>Date of Birth</td>
              <td>:</td>
              <td><?= date("F, dS Y", strtotime($head->Bod)) ?></td>
            </tr>
            <tr>
              <td width="5%"></td>
              <td>Nationality</td>
              <td>:</td>
              <td><?= (isset($head->kewarganegaraan)) ? $head->kewarganegaraan : 'WNI' ?></td>
            </tr>
            <tr>
              <td width="5%"></td>
              <td>Sampling Date</td>
              <td>:</td>
              <td><?= date("F, dS Y", strtotime($head->TglSampel)).' '.date("H:i:s", strtotime($head->Tglhasil)) ?></td>
            </tr>
            <tr>
              <td width="5%"></td>
              <td>Clinical Specimen</td>
              <td>:</td>
              <td><?= $head->AsalSampel ?></td>
            </tr>
            <tr>
              <td width="5%"></td>
              <td>Result Time</td>
              <td>:</td>
              <td><?= (isset($head->Tglhasil)) ?  date("F, dS Y", strtotime($head->Tglhasil)) : '' ?> <br><br></td>
          
            </tr>
          </table>
          <hr width="100%">
        </div>
        <div class="col-lg-12" style="margin-top: 5px;">
          <div class="top-header">
            <h4>RESULT</h4><br>
          </div>
          <div class="data-pemeriksaan">
            <table id="tablePemeriksaan" border="1" align="center">
              <thead >
                <tr>
                  <th style="font-size: 14px; text-align: center; padding-bottom: 5px; padding-top: 5px;">Examination Name</th>
                  <th style="font-size: 14px; text-align: center; padding-bottom: 5px; padding-top: 5px;">Result</th>
<!--                   <th style="font-size: 14px;">SATUAN</th>
                <th style="font-size: 14px;">NILAI RUJUKAN</th>
 -->                  </tr>
              </thead>
              <tbody>
                <?php for ($i=0; $i < count($detail); $i++):?>
                  
                  <?php foreach ($detail[$i]['detail'] as $d): ?>
                    <?php if (($d->Hasil != '' && $d->KdInput != '4') || ($d->KdInput == '4' && $d->Hasil == '')): ?>
                    <tr>
                        <td style="font-size: 13px; text-align: center; padding-top: 5px; padding-bottom: 5px;">&nbsp;&nbsp;&nbsp;&nbsp; <?= $d->NMDetail ?></td>
                        <td style="width: 50%; font-size: 13px;text-align: center;"><b>
                          <?php $hasil = $d->Hasil;  
            						  if($hasil == 'Terdeteksi (Positif)'){
                            $hasil = 'Detected (Positive)';
            						  }else {$hasil = 'Not Detected (Negative)';}?>
                          <?= $hasil ?></b>
                        </td>
                        <!-- <td style="font-size: 13px;"><?= $d->Satuan ?></td> -->
                        <!-- <td style="font-size: 13px;"><?= $d->NilaiNormal ?></td> -->
                      </tr>
                    <?php endif; ?>
                  <?php endforeach?>
                <?php endfor?>
              </tbody>
            </table>
          </div>
          <br>
          <?php if (!empty($head->Ct_value)): ?>
            <p style="margin-top: 15px; margin-left: 50px;">CT Value: <?=$head->Ct_value ?></p>
            <?php endif ?>

          <br>
          <?php if($pengesahan == 'ttd'):?>
            <table id="tableTtd" border="0">
              <tr>
                <td style="text-align: center; width: 30%; display: none" >Doctor</td>
                <td></td>
                <td style="text-align: center; width: 40%;">Jakarta, <?= $tgl_ttd ?></td>
              </tr>
              <tr>
                <td style="padding-bottom: 50px; text-align: center; width: 30%; display: none" >Doctor</td>
                <td></td>
                <td style="padding-bottom: 50px; text-align: center; width: 40%;">Physician,</td>
              </tr>
              <tr>
                <td style="text-align: center; width: 30%; display: none;">(dr.Primatia.S, Sp.PK)</td>
                <td></td>
                <!-- <td style="text-align: center; width: 40%;"><u><?= $fdokter->NmDoc ?></u><br><span style="font-size: 10px; font-family: "><?= $fdokter->korps_ttd ?></span></td> -->
                <td style="text-align: center; width: 40%;"><u> d r .   &nbsp; N u n i k &nbsp; U t a m i  &nbsp; S p . M K</u><br><span style="font-size: 7.5px; font-family: "><?=isset($fdokter) ? $fdokter->korps_ttd : '-'?></span></td>
              </tr>
            </table>
          <?php else: ?>
            <table id="tableTtd" border="0">
              <tr>
                <td style="padding-top: 90px; text-align: center; width: 30%; display: none;"></td>
                <td></td>
                <td style="text-align: center; width: 40%;">Tanjung Pinang, <?= $tgl_ttd ?> <br> Physician, <br><br>
                  <img src="<?php echo site_url('assets/qr/'.$qr) ?>" width="110px" height='110px' alt="">
                </td>
              </tr>
              <tr>
                <td style="text-align: center; width: 30%; display: none;">(dr.Primatia.S, Sp.PK)</td>
                <td><br></td>
                <td style="padding-bottom: 50px; text-align: center; width: 40%;"><br><?= isset($fdokter) ? $fdokter->NmDoc : '-'  ?><br></td>
              </tr>
            </table>
          <?php endif ?>
          <div class="data-tambahan" style='display:none;'>
            <p>Catatan: <?=$head->Catatan ?></p>
            <p>Keterangan </p>
            <p>- Hasil di atas hanya menggambarkan kondisi pada saat pengambilan sampel.<br>
            - Hasil negatif belum dapat menyingkirkan kemungkinan adanya infeksi SARS CoV-2.<br>
            - Bila positif lakukan isolasi mandiri dan terpantau.<br>
            - Tetap melakukan “MASTAGAR” (Gunakan masker, cuci tangan sesering mungkin dengan sabun atau handrub, <br> &nbsp;&nbsp;jaga jarak dan hindari keramaian serta berperilaku sehat).<br>
            - Bila ada keluhan konsultasikan dengan dokter keluarga anda atau klinik kesehatan/RS terdekat.</p>
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
