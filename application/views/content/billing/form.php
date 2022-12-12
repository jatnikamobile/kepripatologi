<div class="row">
  <div class="col-md-4">
    <h6 style="margin-top: 0px; padding-bottom: 0px;" class="header blue">Data Pasien</h6>
    <div class="form-horizontal head-form">
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right"> No. Transaksi </label>
        <div class="col-sm-9">
          <div class="input-group">
            <input type="text" class="form-control" name="no_tran" readonly="readonly" value="<?= @$billing->NoTran ?>">
            <span class="input-group-btn">
              <?php $disabled = empty(@$register->list_transaksi) ? 'disabled="disabled"' : '' ?>
              <button id="btnListTransaksi" class="btn btn-sm btn-default" <?= $disabled ?> type="button">
                <i class="ace-icon fa fa-list bigger-110"></i>
              </button>
            </span>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right"> No. Registrasi </label>
        <div class="col-sm-9">
          <div class="input-group">
            <input type="hidden" name="regno" value="<?= @$register->Regno ?>">
            <input type="text" class="form-control" name="input_regno" maxlength="8" value="<?= @$register->Regno ?>">
            <span class="input-group-btn">
              <button class="btn btn-sm btn-primary" type="button" id="btnCariRegistrasi">
                <i class="ace-icon fa fa-search bigger-110"></i> Cari
              </button>
              <button type="button" class="btn btn-sm btn-purple" id="btn_list_pasien" ><i class="fa fa"></i> List pasien</button>
            </span>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right"> No. RM </label>
        <div class="col-sm-9">
          <div class="input-group">
            <input type="text" class="form-control" name="medrec" readonly="readonly" value="<?= @$register->Medrec ?>">
            <span class="input-group-addon" style="border: none; background: transparent;">
              Tgl. Registrasi:
            </span>
            <input type="text" class="form-control" name="regdate" readonly="readonly" value="<?= isset($register) ? date('d/m/Y', strtotime($register->Regdate)) : NULL ?>">
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right"> Nama </label>
        <div class="col-sm-9">
          <div class="input-group">
            <input type="text" class="form-control" name="firstname" readonly="readonly" value="<?= @$register->Firstname ?>">
            <span class="input-group-addon">
              <?= @$register->KdSex == 'L' ? 'L' : (@$register->KdSex == 'P' ? 'P' : '-') ?>
            </span>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right"> Tgl. Transaksi </label>
        <div class="col-sm-9">
          <div class="input-group">
            <input type="text" class="form-control date-picker" name="tgl_transaksi" value="<?= date('d/m/Y') ?>">
            <span class="input-group-addon" style="border: none; background: transparent;">
              Jam
            </span>
            <input type="text" class="form-control time-picker" name="jam_transaksi" value="<?= date('H:i:s') ?>">
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right"> Usia </label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="usia" readonly="readonly" value="<?= @$register->usia ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right"> Kewarganegaraan </label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="kwn" id="kwn" readonly="readonly" value="<?= @$register->kewarganegaraan ?>">
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <h6 style="margin-top: 0px; padding-bottom: 0px;" class="header blue">Status Perawatan</h6>
    <div class="form-horizontal head-form">
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right"> Dok. Pengirim </label>
        <div class="col-sm-9">
          <select class="form-control select2" name="dok_pengirim" id="dok_pengirim" required>
            <?php if(isset($billing) && isset($billing->KdDoc) && isset($billing->NmDoc)): ?>
              <option value="<?= $billing->KdDoc ?>" selected="selected"><?= $billing->NmDoc ?></option>
            <?php elseif(isset($register) && isset($register->KdDoc) && isset($register->NmDoc)): ?>
              <option value="<?= $register->KdDoc ?>" selected="selected"><?= $register->NmDoc ?></option>
            <?php endif; ?>
          </select>
        </div>
      </div>
      <div class="form-group" id="dokter_pengirim_tx" hidden>
        <div class="col-sm-3"></div>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="dokter_pengirim" id="dokter_pengirim">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right"> Pemeriksa </label>
        <div class="col-sm-9">
          <select class="form-control select2" name="dok_pemeriksa" id="dok_pemeriksa" required>
            <?php if(isset($billing) && ($billing->KdDokter!='' || $billing->NmDokter !='')): ?>
              <option value="<?= $billing->KdDokter ?>" selected="selected"><?= $billing->NmDokter ?></option>
            <?php else: ?>
              <option value="" selected="selected">- Pilih Dokter -</option>
            <?php endif; ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right"> No. PA </label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="no_lab" value="<?= @$billing->NoLab ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right"> Tgl. Terima Sampel </label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="tgl_sampel" value="<?= isset($billing) && isset($register->Regdate) ? date('d/m/Y', strtotime($register->Regdate)) : date('d/m/Y') ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right"> Tgl. Selesai </label>
        <div class="col-sm-9">
          <div class="input-group">
            <input type="text" class="form-control" name="tgl_selesai" value="<?= isset($billing) && isset($billing->TglSelesai) ? date('d/m/Y', strtotime($billing->TglSelesai)) : '' ?>">
            <span class="input-group-addon" style="border: none; background: transparent;">
              Jam
            </span>
            <input type="text" class="form-control" name="jam_selesai"<?= isset($billing) && isset($billing->jam_selesai) ? date('H:i:s', strtotime($billing->JamSelesai)) : '' ?>>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right"> Status </label>
        <div class="col-sm-9">
          <?php $status = isset($billing) ? $billing->nStatus : 0; ?>
          <div class="radio">
            <label>
              <?php $checked = $status == 0 ? 'checked="checked"' : ''?>
              <input name="status" type="radio" class="ace" value="0" <?= $checked ?>>
              <span class="lbl">&nbsp; Normal</span>
            </label>
            <label>
              <?php $checked = $status == 1 ? 'checked="checked"' : ''?>
              <input name="status" type="radio" class="ace" value="1" <?= $checked ?>>
              <span class="lbl">&nbsp; Cito</span>
            </label>
          </div>
        </div>
      </div>
      <!--
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right"> J. Pemeriksaan </label>
        <div class="col-sm-9">
          <?php $jenis = isset($billing) ? $billing->nJenis : 2; ?>
          <div class="radio">
            <label>
              <?php $checked = $jenis == 1 ? 'checked="checked"' : ''?>
              <input name="jenis_pemeriksaan" type="radio" class="ace" value="1" <?= $checked ?>>
              <span class="lbl">&nbsp; Sederhana</span>
            </label>
            <label>
              <?php $checked = $jenis == 2 ? 'checked="checked"' : ''?>
              <input name="jenis_pemeriksaan" type="radio" class="ace" value="2" <?= $checked ?>>
              <span class="lbl">&nbsp; Sedang</span>
            </label>
            <label>
              <?php $checked = $jenis == 3 ? 'checked="checked"' : ''?>
              <input name="jenis_pemeriksaan" type="radio" class="ace" value="3" <?= $checked ?>>
              <span class="lbl">&nbsp; Canggih</span>
            </label>
          </div>
        </div>
      </div>
      -->
    </div>
  </div>
  <div class="col-md-4">
    <h6 style="margin-top: 0px; padding-bottom: 0px;" class="header blue">Ruang Rawat / Poli Asal</h6>
    <?php $source = $billing ?? $register ?? NULL; ?>
    <div class="form-horizontal head-form">
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right"> R. Rawat </label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="ruang_rawat" readonly="readonly" value="<?= @$source->NmBangsal ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right"> Kelas </label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="kelas" readonly="readonly" value="<?= @$source->NmKelas ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right"> Poli </label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="poli" readonly="readonly" value="<?= @$source->NMPoli ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right"> Cara Bayar </label>
        <div class="col-sm-9">
          <!--
          <input type="text" class="form-control" name="cara_bayar" readonly="readonly" value="<?= @$source->NMCbayar ?>">
          -->
          <select class="form-control" name="cara_bayar" data-value="<?= @$source->KdCbayar?>">
              <option value="">-- Pilih --</option>
              <?php
                if(@$cara_bayar){
                  foreach($cara_bayar as $dt){
                    echo '<option value="'.$dt->KDCbayar.'" '.(@$source->KdCBayar == $dt->KDCbayar ? 'selected' : '').'>'.$dt->NMCbayar.'</option>';
                  }
                }
              ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right"> Jaminan </label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="jaminan" readonly="readonly" value="<?= @$source->NMJaminan ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right"> Kategori </label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="kategori" readonly="readonly" value="<?= @$source->NmKategori ?>">
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <hr>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <div class="pull-left">
      <div class="form-inline">
        <button id="btnPilihTindakan" type="button" class="btn btn-sm btn-info btn-round"><i class="fa fa-search"></i> Pilih Tindakan</button>
        <label class="inline" style="margin-left: 10px;">
          <span class="lbl"> Kode Tindakan: </span>
        </label>
        <div class="input-group" style="margin-left: 10px;">
          <input type="text" class="input-small" name="kode_input" style="width: 190px;">
          <span class="input-group-btn">
            <button id="btnCariTindakan" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Cari</button>
          </span>
        </div>
      </div>
    </div>
    <div class="pull-right">
      <button id="btnSimpan" type="submit" class="btn btn-sm btn-primary btn-round">
        <i class="fa fa-save"></i> Simpan / Konfirmasi
      </button>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <hr>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered table-striped mb-0" id="detail-billing">
      <thead>
        <tr>
          <th style="width: 50px;">No.</th>
          <th style="width: 200px;">Waktu Diinput</th>
          <th>Pemeriksaan</th>
          <th style="width: 150px;">Sarana</th>
          <th style="width: 150px;">Pelayanan</th>
          <th style="width: 100px;">Qty</th>
          <th style="width: 150px;">Biaya</th>
          <th style="width: 50px;">#</th>
        </tr>
      </thead>
      <tbody>
        <?php $this->load->view($content.'.detail-table-rows.php', ['list_detail' => isset($billing) ? $billing->list_detail : []]); ?>
      </tbody>
    </table>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="pull-left">
      <a  id="btnShowBaru" href="<?= site_url('billing/baru/'.@$register->Regno) ?>" class="btn btn-xs btn-warning btn-round">
        <i class="fa fa-check"></i> Baru
      </a>
     
      <a href="<?= site_url('billingpemeriksaan/print_label_billing?notransaksi='.@$billing->NoTran) ?>" class="btn btn-xs btn-primary btn-round">
        <i class="fa fa-print"></i> Cetak Label
      </a>
      <a id="btnShowPemeriksaan" href="<?= site_url('hasilpemeriksaan/show_pemeriksaan/'.@$billing->NoTran) ?>" class="btn btn-xs btn-success btn-round">
        <i class="fa fa-check-circle"></i> Isi Pemeriksaan
      </a>
    </div>
    <div class="pull-right">
      <span>Jumlah Biaya: </span>
      <input type="hidden" id="jumlah_biaya_hide" value="<?= isset($billing) ? $billing->Jumlah :'-' ?>">
      <input type="text" name="jumlah_biaya"  value="<?= isset($billing) ? ('Rp. '.number_format($billing->Jumlah, 0, ',', '.')) : '-' ?>" style="width: 200px;" readonly="readonly">
    </div>
  </div>
  <br><br>
  <div class="col-md-12">
    <div class="pull-right">
      <span >Tipe Diskon: </span>
      <select name="tipe_diskon" id="tipe_diskon" style="width: 200px;">
        <option value="persen">Persen</option>
        <option value="rupiah">Rupiah</option>
      </select>
      <span style="width: 200px;" id="txt">Nominal: </span>
      <input type="text" name="jumlah_diskon" id="jumlah_diskon" onchange="ubahdiskon()" value="0" style="width: 200px;">
      <input type="text" name="rupiah_diskon" id="rupiah_diskon" value="<?= isset($billing) ? ('Rp. '.number_format($billing->Diskon, 0, ',', '.')) : '-' ?>" style="width: 200px;" readonly="readonly">
      <input type="hidden" name="rupiah_diskon_hide" id="rupiah_diskon_hide" >
    </div>
  </div>
  <div class="col-md-12">
    <div class="pull-right">
      <span>Jumlah Keseluruhan Biaya: </span>
      <input type="text" name="total_biaya" id="total_biaya" value="<?= isset($billing) ? ('Rp. '.number_format($billing->TotalBiaya, 0, ',', '.')) : '-' ?>" style="width: 200px;" readonly="readonly">
    </div>
  </div>
</div>

<div id="list-transaksi-modal" class="modal fade" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header no-padding">
        <div class="table-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            <span class="white">&times;</span>
          </button>
          List Transaksi Dalam Registrasi Ini
        </div>
      </div>

      <div class="modal-body no-padding">
        <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
          <thead>
            <tr>
              <th>No. Transaksi</th>
              <th><i class="fa fa-calendar"></i> Tanggal</th>
              <th><i class="fa fa-clock-o"></i> Jam</th>
            </tr>
          </thead>

          <tbody>
            <?php if(isset($register) && !empty($register->list_transaksi)): ?>
              <?php $this->load->view($content.'.list-transaksi-table-rows.php', ['list_transaksi' => $register->list_transaksi ]); ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <div class="modal-footer no-margin-top">
        <button class="btn btn-sm pull-left" data-dismiss="modal">
          <i class="ace-icon fa fa-times"></i> Tutup
        </button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal_list_pasien" tabindex="-1" role="dialog" aria-labelledby="ModalGroupList">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ModalGroupList">List Pasien</h4>
            </div>
            <div class="modal-body">
                <form id="form_list_pasien_modal">
                    <p>Pilih list pasien:</p>
                    <input type="radio" id="lpasien1" name="list_pasien" value="Rajal">
                    <label for="lpasien1">Rawat Jalan</label>&nbsp;&nbsp;
                    <input type="radio" id="lpasien2" name="list_pasien" value="IGD">
                    <label for="lpasien2">IGD</label>&nbsp;&nbsp;
                    <input type="radio" id="lpasien3" name="list_pasien" value="Ranap">
                    <label for="lpasien3">Rawat Inap</label><br><br>    
                    <input class="btn btn-round btn-sm btn-success"  type="submit" value="Submit">
                </form>
                <div style="padding-top:10px" id="target_list_pasien"></div>
            </div>
        </div>
    </div>
</div>

<div id="list-tindakan-modal" class="modal fade" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header no-padding">
        <div class="table-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            <span class="white">&times;</span>
          </button>
          <span class="judul">Group Pemeriksaan</span>
        </div>
      </div>

      <div class="modal-body no-padding">
        <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
          <thead>
            <tr>
              <th>Kode</th>
              <th>Nama Tindakan</th>
            </tr>
          </thead>
          <tbody>
            <?php $this->load->view($content.'.tindakan-table-rows.php', ['list_detail' => $group_tindakan, 'type' => 'group']); ?>
          </tbody>
        </table>
      </div>

      <div class="modal-footer no-margin-top">
        <button class="btn btn-sm pull-right" data-dismiss="modal">
          <i class="ace-icon fa fa-times"></i> Tutup
        </button>
        <button class="btn btn-sm pull-left btn-warning btn-back" disabled="disabled">
          <i class="ace-icon fa fa-chevron-left"></i> Kembali
        </button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<script type="text/javascript">

  $(function() {
    $('#btnListTransaksi').click(function() {
      $('#list-transaksi-modal').modal('show');
    });
    $('#btn_list_pasien').on('click',function(e){
        $('#modal_list_pasien').modal('show'); 
    });

    $('#form_list_pasien_modal').submit(function(ev){
        ev.preventDefault();
        jQuery("input[name='list_pasien']").each(function() {
           var value = this.value;
           var checked = this.checked;
            if ( checked == true ) {
                var xhr = $.ajax({
                    url:"<?=base_url('billingpemeriksaan/test')?>",
                    type:'POST',
                    data:{way:value},
                    beforeSend:function(){
                        $('#target_list_pasien').html('<div class="alert alert-info">Memuat Data <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span></div>');
                    },
                    success:function(resp){
                        $('#target_list_pasien').html(resp);
                    }
                });
            }
        })
    });

    $('[name=jam_transaksi]').timepicker({
      minuteStep: 1,
      showSeconds: true,
      showMeridian: false,
    });

    $('[name=jam_selesai]').timepicker({
      minuteStep: 1,
      showSeconds: true,
      showMeridian: false,
      defaultTime: false,
    });

    $('[name=tgl_transaksi], [name=tgl_selesai]').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
      endDate: '0d',
      todayHighlight: true,
    });

    $('[name=cara_bayar]').select2();

    $('[name=dok_pemeriksa], [name=dok_pengirim]').select2({
      ajax: {
        url: '<?= site_url('ajax/dokter') ?>',
        processResults: function(data, params) {
          return {
            results: data.data.map(function(item){
              item.id = item.KdDoc;
              item.text = item.NmDoc;
              return item;
            }),
            pagination: {
              more: data.pagination.next_page
            }
          }
        },
      },

      templateResult: function(item) {
        if(item.loading) {
          return item.text;
        }

        return `
          <p>
             <b>${item.NmDoc}</b><br><small>Poli: <i>${item.NmPoli}</i></small>
          </p>
        `;
      },
      escapeMarkup: function(markup) {
        return markup;
      },
      templateSelection: function(item) {
        return item.text;
      },
    });

    $('[name=input_regno]')
      .on('input', function (ev) {
        if(/^[0-9]{8}$/.test(this.value)) {
          $('#btnCariRegistrasi').prop('disabled', false).attr('title', 'Cari pasien untuk no. registrasi ini');
          allowInput(this.value == $('[name=regno]').val());
          // if(this.value != $('[name=regno]').val()) {
          //   $('#btnCariRegistrasi').trigger('click');
          // }
        }
        else {
          $('#btnCariRegistrasi').prop('disabled', true).attr('title', 'No. registrasi harus 8 digit angka');
          allowInput(false);
        }
      })
      .on('keypress', function(ev) {
        if(/^[0-9]{8}$/.test(this.value) && ev.key === 'Enter') {
          console.log(this.value);
          $('#btnCariRegistrasi').trigger('click');
        }
      })
      .trigger('input')
    ;

    function allowInput(allow) {
      $('.head-form [name]:not([name=input_regno]), #btnPilihTindakan, #btnCariTindakan, [name=kode_input], #btnSimpan')
        .prop('disabled', !allow);
      // $('.head-form [name=input_regno]').prop('disabled', false);
    }

    function processRegisterResponse(register) {
      $('[name=no_tran]').val('');
      $('[name=no_lab]').val('');
      $('[name=regno]').val(register.Regno);
      $('[name=input_regno]').val(register.Regno);
      $('[name=medrec]').val(register.Medrec);
      $('[name=regdate]').val(register.FormattedRegdate);
      $('[name=firstname]').val(register.Firstname);
      $('[name=firstname]').next().text(register.KdSex == 'L' ? 'L' : (register.KdSex == 'P' ? 'P' : '-'));
      $('[name=usia]').val(register.usia);
      $('[name=kwn]').val(register.kewarganegaraan);
      $('[name=ruang_rawat]').val(register.NmBangsal);
      $('[name=kelas]').val(register.NmKelas);
      $('[name=poli]').val(register.NMPoli);
      $('[name=cara_bayar]').val(register.NMCbayar);
      $('[name=jaminan]').val(register.NMJaminan);
      $('[name=kategori]').val(register.NmKategori);
      $('[name=jumlah_biaya]').val('-');
      $('[name=dok_pengirim]').empty();
      // $('[name=dok_pemeriksa]').empty();
      if(register.KdDoc) {
        $('[name=dok_pengirim]').append(new Option(register.NmDoc, register.KdDoc, false, false)).trigger('change');
      }
      else {
        $('[name=dok_pengirim]').val(null).trigger('change');
      }

      $('#list-transaksi-modal tbody').html(register.listTransaksiMarkup);
      $('#detail-billing tbody').html(register.listDetailMarkup);
      $('#btnListTransaksi').prop('disabled', register.list_transaksi.length == 0);
      allowInput(true);
    }

    function processBillingResponse(billing) {
      $('[name=no_tran]').val(billing.NoTran);
      $('[name=usia]').val(billing.usia);
      $('[name=kwn]').val(billing.kewarganegaraan);
      $('[name=ruang_rawat]').val(billing.NmBangsal);
      $('[name=kelas]').val(billing.NmKelas);
      $('[name=poli]').val(billing.NMPoli);
      $('[name=cara_bayar]').val(billing.NMCbayar);
      $('[name=jaminan]').val(billing.NMJaminan);
      $('[name=kategori]').val(billing.NmKategori);
      $('[name=no_lab]').val(billing.NoLab);
      $('[name=tgl_selesai]').val(billing.FormattedTglSelesai);
      $('[name=jam_selesai]').val(billing.FormattedJamSelesai);
      $('[name=jumlah_biaya]').val('Rp. ' + billing.FormattedTotalBiaya);
      $('[name=total_biaya]').val('Rp. ' + billing.FormattedJumlahBiaya);

      $('#btnShowBaru').attr('href',  '<?= site_url('billing/baru/') ?>' + billing.Regno);
      
      $('#btnShowPemeriksaan').attr('href', '<?= site_url('hasilpemeriksaan/show_pemeriksaan/') ?>' + billing.NoTran);

      if(billing.KdDoc) {
        $('[name=dok_pengirim]').append(new Option(billing.NmDoc, billing.KdDoc, false, false)).trigger('change');
      }
      else {
        $('[name=dok_pengirim]').val(null).trigger('change');
      }
      if(billing.KdDokter) {
        $('[name=dok_pemeriksa]').append(new Option(billing.NmDokter, billing.KdDokter, false, false)).trigger('change');
      }
      else {
        // $('[name=dok_pemeriksa]').val(null).trigger('change');
      }
      $('[name=status]').prop('checked', false);
      $(`[name=status][value=${billing.nStatus}]`).prop('checked', true);
      $('[name=jenis_pemeriksaan]').prop('checked', false);
      $(`[name=jenis_pemeriksaan][value=${billing.nJenis}]`).prop('checked', true);

      $('#detail-billing tbody').html(billing.listDetailMarkup);
    }

    let cariRegisterAjax;

    $('#btnCariRegistrasi').click(function() {
      let btn = $(this);
      let regno = $('[name=input_regno]').val();

      let loadingText = '<i class="fa fa-spin fa-spinner"></i> Cari';
      let errorText = '<i class="fa fa-times"></i> Cari';
      btn.attr('original-content', btn.html());

      if(typeof cariRegisterAjax !== 'undefined') {
        cariRegisterAjax.abort();
      }

      cariRegisterAjax = $.ajax({
        url: '<?= site_url('ajax/registrasi/') ?>' + regno,
        retryCount: 3,
        beforeSend: function() {
          btn.html(loadingText).attr('disabled', true);
        },
        success: function(res) {
          if(res) {
            processRegisterResponse(res);
            if(res.TransaksiSekarang) {
              let trans = res.TransaksiSekarang;
              console.log(trans);
              processBillingResponse(trans);
              window.history.replaceState(null, $('title').text(), '<?= site_url('billing/edit/') ?>' + trans.NoTran);
            }
            else {
              window.history.replaceState(null, $('title').text(), '<?= site_url('billing/baru/') ?>' + res.Regno);
            }
          }
        },
        complete: function() {
          btn.html(btn.attr('original-content')).attr('disabled', false);
        },
        // error: function() {
        //   let params = this;
        //   btn.html(errorText).attr('disabled', false);
        //   if(params.retryCount--) {
        //     setTimeout(function() {
        //       $.ajax(params);
        //     }, 5000);
        //   }
        // }
      });
    });

    $('#btnPilihTindakan, #list-tindakan-modal .btn-back').click(function() {
      $('#list-tindakan-modal .judul').text('Group Pemeriksaan');
      $('#list-tindakan-modal .btn-back').prop('disabled', true);
      $('#list-tindakan-modal .group-tindakan').show();
      $('#list-tindakan-modal .detail-tindakan').remove();
      $('#list-tindakan-modal').modal('show');
    });

    function addTindakan(noTran, kodeTindakan, kodeInput) {

      //let last_nomor = $('#detail-billing tbody tr:last-child').data('nomor');
      let last_nomor = $('#detail-billing tbody tr').last().data('nomor');
      return $.ajax({
        method: 'POST',
        url: '<?= site_url('ajax/tambah_tindakan') ?>',
        data: {
          no_tran: noTran,
          kode_tindakan: kodeTindakan,
          kode_input: kodeInput,
          last_nomor: last_nomor,
          diskon: $('#rupiah_diskon_hide').val(),
        },
        beforeSend: function() {
          $('#btnCariTindakan').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Cari Tindakan');
          $('#btnPilihTindakan').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Pilih Tindakan');
        },
        success: function(res) {
          if(res && res.success) {
            if(res.listDetailMarkup) {
              if(!last_nomor) {
                $('#detail-billing tbody').html(res.listDetailMarkup);
              }
              else if(res.listDetailMarkup) {
                $('#detail-billing tbody').append(res.listDetailMarkup);
              }
            }

            $('[name=jumlah_biaya]').val('Rp. ' + res.result.FormattedJumlahBiaya);
            $('[name=total_biaya]').val('Rp. '+res.result.FormattedJumlahBiaya); //ocha temp
          }
        },
        complete: function() {
          $('#btnCariTindakan').prop('disabled', false).html('<i class="fa fa-plus"></i> Cari Tindakan');
          $('#btnPilihTindakan').prop('disabled', false).html('<i class="fa fa-search"></i> Pilih Tindakan');
          $('[name=kode_input]').val('');
        }
      });
    }



    $('#list-tindakan-modal tbody').on('click', '.detail-tindakan', function(ev) {
      let kodeTindakan = $(this).data('kode');
      let noTran = $('[name=no_tran]').val();

      $('#list-tindakan-modal .judul').text('Group Pemeriksaan');
      $('#list-tindakan-modal .btn-back').prop('disabled', true);
      $('#list-tindakan-modal .group-tindakan').show();
      $('#list-tindakan-modal .detail-tindakan').remove();
      $('#list-tindakan-modal').modal('hide');

      if(!noTran) {
        $('#btnSimpan').trigger('click');
        simpanAjax.done(function(res) {
          if(res && res.success) {
            addTindakan(res.result.NoTran, kodeTindakan);
          }
        });
      }
      else {
        addTindakan(noTran, kodeTindakan);
      }
    });

    $('#list-tindakan-modal tbody').on('click', '.group-tindakan', function(ev) {
      
      let kodeGroup = $(this).data('kode');
      let namaGroup = $(this).data('nama');

      $.ajax({
        url: '<?= site_url('ajax/get_detail_tindakan/') ?>' + kodeGroup,
        beforeSend: function() {
          $('#list-tindakan-modal .judul').html('<i class="fa fa-spin fa-spinner"></i> Group Pemeriksaan');
        },
        success: function(res) {
          if(res) {
            $('#list-tindakan-modal .judul').html('Group Pemeriksaan / ' + namaGroup);
            $('#list-tindakan-modal .group-tindakan').hide();
            $('#list-tindakan-modal tbody').append(res.listDetailMarkup);
            $('#list-tindakan-modal .btn-back').prop('disabled', false);
          }
        },
        error: function() {
          $('#list-tindakan-modal .judul').html('<i class="fa fa-times"></i> Group Pemeriksaan');
        }
      });
    });

    $('[name=kode_input]').on('keypress', function(ev) {
      if(ev.key === 'Enter') {
        $('#btnCariTindakan').click();
      }
    });

    $('#btnCariTindakan').click(function() {
      let noTran = $('[name=no_tran]').val();
      let kodeInput = $('[name=kode_input]').val();
      if(!noTran) {
        $('#btnSimpan').trigger('click');
        simpanAjax.done(function(res) {
          if(res && res.success) {
            addTindakan(res.result.NoTran, null, kodeInput);
          }
        });
      }
      else {
        addTindakan(noTran, null, kodeInput);
      }
    });


    let simpanAjax;

    $('#btnSimpan').click(function() {

      var dok_pengirim = document.getElementById('dok_pengirim').validity.valid;
      var tx_pengirim = document.getElementById('dokter_pengirim').value;
      var dok_pemeriksa = document.getElementById('dok_pemeriksa').validity.valid;
      var dok_tx = tx_pengirim || '' ;
      if (!dok_pengirim) { alert('Isi Dokter Pengirim'); return; }
      if (!dok_pemeriksa) { alert('Isi Dokter Pemeriksa'); return; }
      // if (!tx_pengirim) { dok_tx = tx_pengirim}


      let btn = $(this);
      let loadingText = '<i class="fa fa-spin fa-spinner"></i> Simpan / Konfirmasi';
      let errorText = '<i class="fa fa-times"></i> Simpan / Konfirmasi';
      btn.attr('original-content', btn.html());

      if(typeof simpanAjax !== 'undefined') {
        simpanAjax.abort();
      }

      simpanAjax = $.ajax({
        method: 'POST',
        url: '<?= site_url('ajax/simpan_billing') ?>',
        data: {
          no_tran: $('[name=no_tran]').val(),
          regno: $('[name=regno]').val(),
          dok_pengirim: $('[name=dok_pengirim]').val(),
          dtx: dok_tx,
          dok_pemeriksa: $('[name=dok_pemeriksa]').val(),
          jenis_sampel: $('[name=jenis_sampel]').val(),
          tgl_sampel: $('[name=tgl_sampel]').val(),
          tgl_selesai: $('[name=tgl_selesai]').val(),
          jam_selesai: $('[name=jam_selesai]').val(),
          tgl_transaksi: $('[name=tgl_transaksi]').val(),
          jam_transaksi: $('[name=jam_transaksi]').val(),
          status: $('[name=status]:checked').val(),
          kwn: $('#kwn').val(),
          cara_bayar: $('[name=cara_bayar]').val(),
          no_lab: $('[name=no_lab]').val(),
          jenis_pemeriksaan: $('[name=jenis_pemeriksaan]:checked').val(),
        },
        retryCount: 3,
        beforeSend: function() {
          btn.html(loadingText).attr('disabled', true);
        },
        success: function(res) {
     
          if(res && res.success) {
            $('[name=no_tran]').val(res.result.NoTran);
            $('[name=no_lab]').val(res.result.NoLab);
            $('#btnShowBaru').attr('href', '<?= site_url('billing/baru/') ?>' + res.result.Regno);
            $('#btnShowPemeriksaan').attr('href', '<?= site_url('hasilpemeriksaan/show_pemeriksaan/') ?>' + res.result.NoTran);
            window.history.replaceState(null, $('title').text(), '<?= site_url('billing/edit/') ?>' + res.result.NoTran);
          }
        },
        complete: function() {
          btn.html(btn.attr('original-content')).attr('disabled', false);
        },
        // error: function() {
        //   let params = this;
        //   btn.html(errorText).attr('disabled', false);
        //   if(params.retryCount--) {
        //     setTimeout(function() {
        //       $.ajax(params);
        //     }, 5000);
        //   }
        // }
      });
    });

    let cariBillingAjax;

    $('#list-transaksi-modal tbody').on('click', '[data-notran]', function(ev) {
      $('#list-transaksi-modal').modal('hide');
      let btn = $('#btnListTransaksi');
      let notran = $(this).data('notran');
      let regno = $('[name=regno]').val();
      if(!notran) {
        $('[name=dok_pemeriksa], [name=tgl_selesai], [name=jam_selesai], [name=no_lab], [name=no_tran]').val(null).trigger('change');
        let date = new Date();
        $('[name=tgl_transaksi]').datepicker('setDate', new Date(date.getFullYear(), date.getMonth(), date.getDate()));
        $('[name=jam_transaksi]').val(`${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`);
        $('#detail-billing tbody').html(
          '<tr><td style="font-style: italic; text-align: center;" colspan="100%">(Tidak ada data)</td></tr>'
        );
        window.history.replaceState(null, $('title').text(), '<?= site_url('billing/baru/') ?>' + regno);
        return;
      }

      let loadingText = '<i class="fa fa-spin fa-spinner"></i>';
      let errorText = '<i class="fa fa-times"></i>';
      btn.attr('original-content', btn.html());

      if(typeof cariBillingAjax !== 'undefined') {
        cariBillingAjax.abort();  
      }

      cariBillingAjax = $.ajax({
        url: '<?= site_url('ajax/billing/') ?>' + notran,
        retryCount: 3,
        beforeSend: function() {
          btn.html(loadingText).attr('disabled', true);
        },
        success: function(res) {
          if(res.register && res.billing) {
            processRegisterResponse(res.register);
            processBillingResponse(res.billing);
            window.history.replaceState(null, $('title').text(), '<?= site_url('billing/edit/') ?>' + res.billing.NoTran);
          }
        },
        complete: function() {
          btn.html(btn.attr('original-content')).attr('disabled', false);
        },
        // error: function() {
        //   let params = this;
        //   btn.html(errorText).attr('disabled', false);
        //   if(params.retryCount--) {
        //     setTimeout(function() {
        //       $.ajax(params);
        //     }, 5000);
        //   }
        // }
      });
    });

    $('#detail-billing tbody').on('click', '.btn-delete', function() {
      let btn = $(this);

      let loadingText = '<i class="fa fa-spin fa-spinner"></i>';
      let errorText = '<i class="fa fa-times"></i>';
      btn.attr('original-content', btn.html());

      let no_tran = $('[name=no_tran]').val();
      let kode_tarif = btn.parents('tr').data('kode_tarif');

      bootbox.confirm('Apakah anda yakin akan menghapus data ini?', function(confirm) {
        if(confirm) {
          $.ajax({
            method: 'POST',
            url: '<?= site_url('ajax/hapus_detail_billing/') ?>' + no_tran + '/' + kode_tarif,
            beforeSend: function() {
              btn.html(loadingText).attr('disabled', true);
            },
            success: function(res) {
              if(res && res.success) {
                btn.parents('tr').remove();
                $('[name=jumlah_biaya]').val('Rp. ' + res.formatted_total);
                $('[name=total_biaya]').val('Rp. ' + res.formatted_total); //ocha temp
              }
            },
            complete: function() {
              btn.html(btn.attr('original-content')).attr('disabled', false);
            },
          });
        }
      });
    });
  });

  $('[name=dok_pengirim]').on('change', function() {
      let dok = $(this).val();
      if(dok == 'D010') {
        $('#dokter_pengirim_tx').show();
      }else{
        $('#dokter_pengirim_tx').hide();
      }
    })
    .trigger('change');

  function ubahdiskon(){
      var pil = $('#tipe_diskon').val();
      var diskon = $('#jumlah_diskon').val();
      var jumlah = $('#jumlah_biaya_hide').val();
      var jum = jumlah.replace(/\,/g,'');
      var nominal,total;
      if (pil == 'persen') {
        nominal = parseInt(jumlah*(diskon/100));
        
      }else{
        nominal = parseInt(diskon) ;
      }
      total = jumlah - nominal;
      $("#rupiah_diskon").val('Rp. '+formatNumber(nominal));
      $("#rupiah_diskon_hide").val(nominal);
      $("#total_biaya").val('Rp. '+formatNumber(total));
      update_diskon();

    }
    function formatNumber(num) {
      if(num){
          return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
      }else{
        return "0";
      }
    }

     function update_diskon() {
      var noTran =$('[name=no_tran]').val();
      return $.ajax({
        method: 'POST',
        url: '<?= site_url('ajax/update_diskon') ?>',
        data: {
          no_tran: noTran,
          diskon: $('#rupiah_diskon_hide').val(),
        },
        beforeSend: function() {
          $('#simpanDiskon').prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Loading..');
        },
        success: function(res) {
          if(res && res.success) {
            $('[name=total_biaya]').val('Rp. ' + res.result.FormattedJumlahBiaya);
          }
        },
        complete: function() {
          $('#simpanDiskon').prop('disabled', false).html('<i class="fa fa-save"></i> Simpan');
        }
      });
    }
</script>
