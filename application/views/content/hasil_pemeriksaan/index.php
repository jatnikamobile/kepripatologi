<div class="row">
  <div class="col-sm-12 col-md-12" style="border: 1px solid grey; border-radius: 5px;">
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
      <p><i><u>Data Transaksi</u></i></p>
      <div class="col-sm-12">
        <form id="formCariTransaksi">
          <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">No Transaksi</label>
            <div class="input-group col-sm-9">
              <span class="input-group-addon" id="" style="border:none;background-color:transparent;">:</span>
              <input type="text" name="NoTransaksi" id="NoTransaksi" class="input-sm" value="<?= @$notran ?>" />
              <button type="submit" class="btn btn-info btn-sm" id="btnCari" style="margin-left: 10px;">
                <i class="ace-icon fa fa-search"></i>Cari
              </button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-sm-12">
        <div class="form-group">
          <label class="col-sm-3 control-label no-padding-right">No Patologi Anatomi</label>
          <div class="input-group col-sm-9">
            <span class="input-group-addon" id="" style="border:none;background-color:transparent;">:</span>
            <input type="text" name="NoPatologi" id="NoPatologi" class="input-sm" />
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-group">
          <label class="col-sm-3 control-label no-padding-right">Tgl. Hasil</label>
          <div class="input-group col-sm-9">
            <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
            <input type="date" name="TglHasil" class="form-control input-sm" id="TglHasil" value="<?=date('Y-m-d')?>" />
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-group">
          <label class="col-sm-3 control-label no-padding-right">Jam Hasil</label>
          <div class="input-group col-sm-9">
            <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
            <input type="text" name="JamHasil" class="form-control input-sm" id="JamHasil" > </input>
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-group">
          <label class="col-sm-3 control-label no-padding-right">Tgl. Terima Sampel</label>
          <div class="input-group col-sm-9">
            <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
            <input type="date" name="TglSampel" class="form-control input-sm" id="TglSampel"  />
          </div>
        </div>
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
      <p><i><u>Data Pasien</u></i></p>
      <div class="col-sm-12">
        <div class="form-group">
          <label class="col-sm-2 control-label no-padding-right">No Registrasi</label>
          <div class="input-group col-sm-9">
            <span class="input-group-addon" id="" style="border:none;background-color:transparent;">:</span>
            <input type="text" name="Regno" id="Regno" class="input-sm" readonly />
            <input type="hidden" name="KdDokter" id="KdDokter" class="input-sm" readonly />
            <span class="input-group-addon" id="" style="border:none;background-color:white;">Tgl Registrasi</span>
            <input type="date" name="Regdate" class="form-control input-sm col-sm-3" id="Regdate" readonly />
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-group">
          <label class="col-sm-2 control-label no-padding-right">No Rekam Medis</label>
          <div class="input-group col-sm-9">
            <span class="input-group-addon" id="" style="border:none;background-color:transparent;">:</span>
            <input type="text" name="Medrec" id="Medrec" class="form-control input-sm" readonly />

            <span class="input-group-addon" id="" style="border:none;background-color:white;">Nama Pasien</span>
            <input type="text" name="Firstname" id="Firstname" class="form-control input-sm col-xs-10 col-sm-5" readonly/>
          </div>
        </div>
      </div>
      <div class="col-sm-12">
          <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right">Jenis Kelamin</label>
            <div class="input-group col-sm-3">
              <span class="input-group-addon" id="" style="border:none;background-color:transparent;">:</span>
              <div class="radio">
                <label>
                  <input disabled="disabled" name="KdSex" type="radio" class="ace" value="L"/>
                  <span class="lbl">&nbsp; Laki - Laki</span>
                </label>
                <label>
                  <input disabled="disabled" name="KdSex" type="radio" class="ace" value="P"/>
                  <span class="lbl">&nbsp; Perempuan</span>
                </label>
              </div>
            </div>
          </div>
      </div>
      <div class="col-sm-12">
          <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right">Usia</label>
            <div class="input-group col-sm-3">
              <span class="input-group-addon" id="" style="border:none;background-color:transparent;">:</span>
              <input type="text" name="UmurThn" id="UmurThn" class="form-control input-sm col-xs-6 col-sm-3" readonly/>
              <!-- Input Umur Bulan -->
              <span class="input-group-addon no-border-right no-border-left" id="">/</span>
              <input type="text" name="UmurBln" id="UmurBln" class="form-control input-sm col-xs-6 col-sm-3" readonly/>
              <!-- Input Umur Hari -->
              <span class="input-group-addon no-border-right no-border-left" id="">/</span>
              <input type="text" name="UmurHari" id="UmurHari" class="form-control input-sm col-xs-6 col-sm-3" readonly/>
            </div>
          </div>
      </div>
    </div>
  </div>
  <!-- <button class="btn btn-info btn-sm" type="button" id="search_tindakan"><i class="fa fa-plus"></i> Tindakan Baru</button>
  <form id="formTindakan">
    <div class="form-group">
      <label class="col-sm-1 control-label no-padding-right">Kode Tindakan</label>
      <div class="input-group col-sm-3">
        <span class="input-group-addon" id="" style="border:none;background-color:transparent;">:</span>
        <input type="text" name="KodeTindakan" id="KodeTindakan" class="input-sm" />
        <button type="submit" class="btn btn-success btn-sm" id="btnTindakan" style="margin-left: 10px;">
          <i class="ace-icon fa fa-plus"></i>  Cari
        </button>
      </div>
    </div>
  </form> -->
  <form id="formInputHasil" method="POST" action="POST">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
    <input type="hidden" name="NoTran" id="NoTran" class="input-sm"/>
    <div class="col-sm-12 col-md-12" style="margin-top: 25px;">
      <div class="col-sm-12">
        <center><h4>Hasil Pemeriksaan</h4></center>
        <div id="tableTindakan"></div>
      </div>
    </div>
    <div class="col-sm-12 col-md-12" style="margin-top: 25px;">
      <div class="col-sm-12">
        <div class="col-sm-6">
          <div class="form-group">
            <br>
            <!-- TTD ATAU QR -->
            <p><i>Metode Pengesahan Dokumen</i></p>
            <input type="radio" id="ttd" name="pengesahan" value="ttd">
            <label for="ttd">Ttd Dokter</label>
            <input type="radio" id="qr" name="pengesahan" value="qr" checked>
            <label for="qr">QR Code</label><br>
            <!-- KETERANGAN COVID -->
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <input type="hidden" name="Saran" id="Saran">
          </div>
        </div><br>
        <div class="col-sm-6">
          <div class="pull-right">
            <div class="form-group">

            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="pull-right">
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<div class="modal fade" id="modal-tindakan" tabindex="-1" role="dialog" aria-labelledby="ModalGroupTindakan">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="ModalGroupTindakan">Pemeriksaan</h4>
      </div>
      <div class="modal-body">
        <div id="target-pemeriksaan"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-print-custom" role="dialog" aria-labelledby="ModalPrintCustom">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="ModalPrintCustom">Print Custom</h4>
      </div>
      <div class="modal-body">
        <form>
          <div style="display: none;" id="detail-pems">
            
          </div>
          <table class="table table-bordered" id="table-list-custom">
            <thead>
              <tr>
                <th style="width: 50px; text-align: center;">#</th>
                <th style="width: 240px;">Tanggal / Jam</th>
                <th>Nama Tindakan</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">
          Close
        </button>
        <button id="btnPrintCustom" type="button" class="btn btn-primary">
          <i class="fa fa-print"></i> Print
        </button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  var kdgroup = '';
  $(document).ready(function(){
    console.log('Have a nice day :) by Mediantara');
    if ($('#NoTransaksi').val() != '') $('#formCariTransaksi').submit();
    $('#JamHasil').timepicker({
      minuteStep: 1,
      showSeconds: true,
      showMeridian: false,
    });
  });

  $('#formCariTransaksi').submit(function(ev) {
    ev.preventDefault();
    searchHeadHasil($('#NoTransaksi').val());
    searchDetailHasil($('#NoTransaksi').val());
  });
 
  $('#formInputHasil').submit(function(ev) {
    ev.preventDefault();
    let btn = $('#btnSaveHasil');
    var tgl_hasil = $('#TglHasil').val(); 
    var jam_hasil = $('#JamHasil').val(); 
    var tgl_sample = $('#TglSampel').val(); 
    var asal_sample = $('#AsalSampel').val(); 
    console.log(jam_hasil);
    let oldText = btn.html();
    btn.html('<i class="fa fa-spin fa-spinner"></i> ' + 'tunggu...');
    btn.prop('disabled', true);
    $.ajax({
      url: "<?= base_url('hasilpemeriksaan/post_hasil_pemeriksaan') ?>",
      type: 'POST',
      data: $(this).serialize(this)+"&Tgl_hasil="+tgl_hasil+"&Jam_hasil="+jam_hasil+"&tgl_sample="+tgl_sample+"&asal_sample="+asal_sample,
      datatype: 'json',
      success: function(resp){
        console.log(resp);
        // alert(resp.message);
        scrollTo({top: 0});
        btn.prop('disabled', false);
        btn.html(oldText);
        searchDetailHasil($('#NoTransaksi').val());

      }
    });
  });

  $('#table-list-custom tbody').on('click', 'tr', function() {
    $(this).find('input[type=checkbox]').trigger('click');
  });

  $('#table-list-custom tbody').on('click', 'tr input[type=checkbox]', function() {
    console.log('#detail-pems [kode-detail="' + $(this).val() + '"]');
    $('#detail-pems [kode-detail="' + $(this).val() + '"]').prop('checked', $(this).prop('checked'));
  });

  function searchHeadHasil(notransaksi) {
    $.ajax({
      url:"<?=base_url('hasilpemeriksaan/get_pasien_by_notran')?>",
      type:'POST',
      data:{notransaksi:notransaksi},
      success:function(resp){
        $('#NoPatologi').val(resp.NoLab);
        $('#NoTran').val(resp.NoTran);
        $('#Regno').val(resp.Regno);
        $('#Medrec').val(resp.MedRec);
        $('#Firstname').val(resp.Firstname);
        $('#KdDokter').val(resp.KdDoc);
        $('#TglSampel').val(resp.TglSampel ? resp.TglSampel : '');
        $('#AsalSampel').val(resp.AsalSampel);
        $('#Regdate').val(resp.Regdate.substring(0,10));
        $("input[name=KdSex][value=" + resp.KdSex + "]").attr('checked', 'checked');
        const myArray = resp.UmurThn.split("-");
        $('#UmurThn').val(myArray[0]);
        $('#UmurBln').val(myArray[1]);
        $('#UmurHari').val(myArray[2]);
        $('#Ct_value').val(resp.Ct_value);
        $('#TglHasil').val(resp.TglHasil.substring(0,10));
        $('#JamHasil').val(resp.TglHasil.substring(11,19));
        // $('#ttd').val("ttd").trigger('change').attr('checked', 'checked').prop('checked');
      }
    });
  }

  function searchDetailHasil(notransaksi) {
    let btn = $('#btnCari');
    let oldText = btn.html();
    btn.html('<i class="fa fa-spin fa-spinner"></i> ' + 'tunggu...');
    btn.prop('disabled', true);
    $.ajax({
      url:"<?=base_url('hasilpemeriksaan/get_pasien_by_notran_table_detail')?>",
      type:'POST',
      data:{notransaksi:notransaksi},
      beforeSend:function(){
        $('#tableTindakan').html('<div class="alert alert-info">Memuat Data <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span></div>');
      },
      success:function(resp){
        $('#tableTindakan').html(resp);
        btn.prop('disabled', false);
        btn.html(oldText);
      }
    });
  }

  $('#search_tindakan').on('click', function(ev) {
    ev.preventDefault();
    var xhr = $.ajax({
      url:"<?=base_url('hasilpemeriksaan/show_group_pemeriksaan_lab')?>",
      type:'POST',
      data:{kdgroup:kdgroup},
      beforeSend:function(){
        $('#modal-tindakan').modal('show');
        $('#target-pemeriksaan').html('<div class="alert alert-info">Memuat Data <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span></div>');
      },
      success:function(resp){
        $('#target-pemeriksaan').html(resp);
      }
    });
  });

  $('#formTindakan').submit(function(ev) {
    ev.preventDefault();
    let btn = $('#btnTindakan');
    let oldText = btn.html();
    btn.html('<i class="fa fa-spin fa-spinner"></i> ' + 'tunggu...');
    btn.prop('disabled', true);
    if ($('#Regno').val() == '') {
      alert('Isi terlebih dahulu no registrasi terlebih dahulu');
    } else {
      $.ajax({
        url:"<?=base_url('hasilpemeriksaan/post_new_pemeriksaan')?>",
        type:'POST',
        data:{
          kdmapping: $('#KodeTindakan').val(), 
          notran: $('#NoTransaksi').val(), 
          regno: $('#Regno').val(),
          KdPengirim: $('#KdDokter').val(),
          kdlab: $('#NoPatologi').val()
        },
        success:function(resp){
          console.log(resp);
          $('#KodeTindakan').val('');
          $('#btnCari').click();
        }
      });
    }
    btn.prop('disabled', false);
    btn.html(oldText);
  });

  $('#btnPrintCustom').click(function(ev) {
    ev.preventDefault();
    if ($('#NoTransaksi').val() == '') {
      alert('Nomor Transaksi Kosong');
    } else {
      var xhr = $.ajax({
        url:"<?=base_url('hasilpemeriksaan/print_hasil_pemeriksaan')?>",
        data: $('#modal-print-custom form input').serialize() +'&'+ 'notransaksi='+$('#NoTransaksi').val(),
        type:'get',
        // data:{notransaksi: $('#NoTransaksi').val()},
        beforeSend:function(){
          $('#modal-tindakan').modal('show');
          $('#target-pemeriksaan').html('<div class="alert alert-info">Memuat Data <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span></div>');
        },
        success:function(resp){
          $('#target-pemeriksaan').html(resp);
          setTimeout(function () {
            $('#target-pemeriksaan').printElement();
          }, 1000);
        }
      });
    }
  });
</script>