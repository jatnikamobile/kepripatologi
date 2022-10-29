<div class="row">
    <div class="col-sm-12 col-md-12">
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="col-sm-12">
                <div class="pull-right" style="display: none;">
                    <button type="button" id="btn-histori" class="btn btn-success btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg-histori" style="width: 150px; height: 34px;">Histori Pasien</button>
                </div>
                <div class="col-sm-12 col-md-12">
                    <p><u>Pendaftaran Instansi</u></p>
                    <form method="post" class="row" id="form-psn-bpjs">
                        <div class="col-lg-12 row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Instansi*</label>
                                    <div class="input-group col-sm-9">
                                        <input type="hidden" name="Regno" id="Regno" readonly value="<?= $regno ?>" />
                                        <select name="instansi" id="instansi" class="form-control select2" onchange="PilihUnit(this.value)">
                                            <?php if ($this->session->userdata('grup') == 'INSTANSI'): ?>
                                                <option value="<?= $this->session->userdata('kdInstansi')?>" selected><?= $this->session->userdata('displayName')?></option>
                                            <?php else: ?>
                                                <option value="">Pilih Instansi</option>
                                                <?php foreach($instansi as $item): ?>
                                                  <option value="<?= $item->KdInstansi ?>"><?= $item->NmInstansi ?></option>
                                                <?php endforeach; ?>
                                            <?php endif ?>
                                        </select>
                                        <input type="hidden" name="Regdate" id="Regdate" class="form-control input-sm col-xs-6 col-sm-6" value="<?= date('Y-m-d') ?>"/>
                                        <input type="hidden" name="NomorUrut" id="NomorUrut" readonly="readonly">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Unit*</label>
                                    <div class="input-group col-sm-9">
                                        <select name="unit" id="unit" class="form-control select2">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right"> Tindakan*</label>
                                    <div class="input-group col-sm-9">
                                        <input type="hidden" name="Regno" id="Regno" readonly value="<?= $regno ?>"  >
                                        <select name="tindakan" id="tindakan" class="form-control select2" required>
                                            <option value="">Pilih Tindakan</option>
                                            <?php foreach($tindakan_micro as $item): ?>
                                              <option value="<?= $item->KDDetail ?>"><?= $item->NMDetail ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right"> Jumlah Peserta</label>
                                    <div class="input-group col-sm-8">
                                        <div class="input-group ">
                                        <input type="number" name="jumlah_peserta" id="jumlah_peserta" class="form-control" aria-describedby="basic-addon2">
                                        <span class="input-group-addon" id="basic-addon2">
                                            <a href="javascript:;" id="simpan_instansi" ><i class="fa fa-plus"></i></a></span>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            
    
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="loading_home"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
                            <div class="table-responsive" >
                                <table border="0" width="100%" class="table" id="tabel_peserta">
                                    <thead>
                                        <tr>
                                            <td>NIK</td>
                                            <td>Nama</td>
                                            <td>No.Telpon</td>
                                            <td>Jenis Kelamin</td>
                                            <td>Tanggal Lahir</td>
                                        </tr>
                                    </thead>
                                </table>  
                            </div>
                        </div>
                    <?php if ($this->session->userdata('grup') != 'INSTANSI'): ?>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right"> Tipe Diskon </label>
                                    <div class="input-group col-sm-3">
                                        <select name="tipe_diskon" id="tipe_diskon" style="width: 200px;">
                                            <option value="persen">Persen</option>
                                            <option value="rupiah">Rupiah</option>
                                        </select>
                                        <input type="text" name="jumlah_diskon" id="jumlah_diskon" onchange="ubahdiskon()" value="0" style="width: 200px;">
                                    </div>
                                    <label class="col-sm-3 control-label no-padding-right"> Diskon Instansi </label>
                                    <div class="input-group col-sm-3">
                                        <input type="number" name="diskon_instansi" id="diskon_instansi" class="form-control">
                                        <input type="hidden" name="rupiah_diskon_hide" id="rupiah_diskon_hide" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                        <input type="hidden" name="change_keyakinan" id="change_keyakinan">
                        <input type="hidden" name="regold" id="regold">
                        <button type="submit" name="submit" id="submit" class="btn btn-success">Simpan</button>
                        <!-- <button type="button" name="printsep" id="printsep" class="btn btn-primary"><i class="fa fa-print"></i> Print SEP</button> -->
                        <a href="" class="btn btn-warning"><i class="fa fa-check"></i> Baru</a>
                        <!-- <button type="button" name="printslip" id="printslip" class="btn btn-primary hidden"><i class="fa fa-print"></i> Print Slip</button> -->
                        <button type="button" name="printlabel" id="printlabel" class="btn btn-primary hidden"><i class="fa fa-print"></i> Print Label</button>
                        <!-- <button type="button" name="printkeyakinan" id="printkeyakinan" class="btn btn-primary hidden"><i class="fa fa-print"></i> Print Keyakinan</button> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade modal-loading" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-loading">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="alert alert-info">Memuat Data.. <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span></div>
                </div>
            </div>
        </div>
    </div>
<script>
    function PilihUnit(id){
        $.ajax({
            url:"<?= base_url('registrasi/getUnitInstansi')?>",
            type:'POST',
            data:{
                id: id
            },
            dataType: 'JSON',
            success:function(response){
                $("#unit").html(response.data);
            }
        });

    }
      function ubahdiskon(){
          var pil = $('#tipe_diskon').val();
          var jumlah = $('#jumlah_diskon').val();
          var qty = $('#jumlah_peserta').val();
          $('#diskon_instansi').attr('readonly',true);
          if (pil == 'rupiah')  {
            $('#diskon_instansi').val(jumlah);
          }else {
           $.ajax({
                url:"<?= base_url('registrasi/getTarifTindakan')?>",
                type:'POST',
                data:{
                    id: $('#tindakan').val(),
                },
                dataType: 'JSON',
                success:function(response){
                    var tarif = parseInt(response.tarif);
                    var total = ((tarif * qty)*(jumlah/100)); 
                    $('#diskon_instansi').val(total);
                }
            }); 
          }
            

        }
        function formatNumber(num) {
          if(num){
              return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
          }else{
            return "0";
          }
        }
    var tabel_peserta;
    var jum_peserta_total=0;
    $(document).ready(function(){
        // $('.dateformat').datepicker({autoclose:true, format: 'dd-mm-yyyy'});
        if ($('#Regno').val() != '') {
            search_regno($('#Regno').val());
        }
        var inst = "<?php echo $this->session->userdata('grup') ?>"; 
        if ( inst == 'INSTANSI' ) {
            PilihUnit(<?php echo $this->session->userdata('kdInstansi')?>);
        }

        tabel_peserta = $('#tabel_peserta').DataTable();
    });



    $('.select2').select2();
    $('#unit').select2();
    $('.tglLahir_peserta').datepicker({
          format: 'dd-mm-yyyy',
          autoclose: true,
          endDate: '0d',
          todayHighlight: true,
        });


    $('#simpan_instansi').on('click', function(ev) {
        ev.preventDefault();
        var unit = $('#unit').val();
        var instansi = $('#instansi').val();
        var tind = $('#tindakan').val();
        if (unit !='' && instansi != '' && tind!= '') {
            var jumlah = $('#jumlah_peserta').val();
            for (var i = 0; i < jumlah; i++) {

                tabel_peserta.row.add( [
                    '<input type="text" class="form-control" maxlength="16" pattern="\d{4}" required name="nik_peserta[]" id="nik_peserta'+(i+jum_peserta_total)+'">',
                    '<input type="text" class="form-control" name="nama_peserta[]" required id="nama_peserta'+(i+jum_peserta_total)+'">',
                    '<input type="number" class="form-control" name="no_telp[]"  required id="no_telp'+(i+jum_peserta_total)+'">',
                    '<select name="jenis_kelamin[]" id="jenis_kelamin'+(i+jum_peserta_total)+'" required class="form-control"><option value="Laki-laki">Laki-laki</option><option value="Perempuan">Perempuan</option></select>',
                    '<input type="date" class="form-control tglLahir_peserta" required name="tglLahir_peserta[]" id="tglLahir_peserta'+(i+jum_peserta_total)+'">',
                ] ).draw( false );
            }
        jum_peserta_total += parseInt(jumlah);
        }else{
            alert('Isi data Instansi, Unit dan tindakan');
        }
        
    });
    $("#submit").on("click",function(e){
        e.preventDefault();
        var lengkap =true;
        let strArray = [];
        for (var i = 0; i < jum_peserta_total ; i++) {
            var nik = $("#nik_peserta"+i).val();

            var nik_jumlah = $("#nik_peserta"+i).val().length;
            strArray.push(nik); 
            var nama = $("#nama_peserta"+i).val();
            var telp = $("#no_telp"+i).val();
            var tgllhr = $("#tglLahir_peserta"+i).val();
            if (nik == '' ) {
                lengkap = false;
                alert('Lengkapi NIK Peserta');
            }else if (nik_jumlah < 16 || nik_jumlah > 16) {
                lengkap = false;
                alert('Nik Peserta harus 16 digit');
            }else if (nama == '') {
                lengkap = false;
                alert('Lengkapi Nama Peserta');
            }else if (telp == '') {
                lengkap = false;
                alert('Lengkapi Telpon Peserta');
            }else if (tgllhr == '') {
                lengkap = false;
                alert('Lengkapi Tanggal Lahir Peserta');
            }

        }
        let findDuplicates = arr => arr.filter((item, index) => arr.indexOf(item) != index)
        // console.log(findDuplicates(strArray)) // All duplicates
        // console.log([...new Set(findDuplicates(strArray))]) // Unique duplicates
        a = [...new Set(findDuplicates(strArray))]; // Unique duplicates
        console.log(a) // Unique duplicates

        if(a.length === 0){
            if (lengkap) {
                let loading = $('.modal-loading');
                loading.modal('show');
                var h2 = $('#Regdate').val();
                    $.ajax({
                        url:"<?=base_url('registrasi/post_instansi')?>",
                        type:"post",
                        dataType:"json",
                        data: $('#form-psn-bpjs').serialize()
                        ,beforeSend(){
                            loading.modal('show');
                        },error: function(response){
                            alert('Gagal menambahkan/server down, Silahkan coba lagi');
                            loading.modal('hide');
                        },
                        success:function(response)
                        {
                            console.log(response);
                            loading.modal('hide');
                            $('#Regno').val(response.Regno);
                            $('#NomorUrut').val(response.NomorUrut);
                            // alert('sedang dalam perbaikan 30mnt/ selain fisio terapi pasien masuk');
                            pesan = response.message + "\n" +
                                    "Pasien " + response.Firstname + "\n" +
                                    "Antrian aplikasi baru " + response.NomorUrut;
                            alert(pesan);
                        }
                    });
            }
            // alert("lolos");
        }else{ 
            alert("ada data nik duplikat : "+a);
        }
           
    });

    // Ngitung Umur
    $('#Bod').on("change",function(){
        var today = new Date();
        var bod = $('#Bod').val();
        var age = "";
        var month = Number(bod.substr(5,2));
        var day = Number(bod.substr(8,2));

        // Get Year
        age = today.getFullYear() - bod.substring(0,4);
        if (today.getMonth() < (month - 1)) {
            age--;
        }
        if (((month - 1) == today.getMonth()) && (today.getDate() < day)) {
            age--;
        }
        $('#UmurThn').val(age);

        // Get Month
        var calMonth = (today.getMonth()+1)-month;
        if ( calMonth < 0) {
            if (calMonth < 0) {
                var generateMonth = calMonth+12;
                $('#UmurBln').val(generateMonth);
            }else{
                $('#UmurBln').val(calMonth);
            }
        }else{
            // var valMonth = today.getMonth() - month;
            
            $('#UmurBln').val(calMonth);
        }

        // Get Day
        var callDay = today.getDate()-day;
        if ( callDay < 0) {
            if (callDay < 0) {
                var generateDay = callDay+30;
                $('#UmurHari').val(generateDay);
            }else{
                $('#UmurHari').val(callDay);
            }
        }else{
            // var valMonth = today.getMonth() - month;
            
            $('#UmurHari').val(callDay);
        }

    });

    function sum_bod(age) {
        var today = new Date();
        var bod = age;
        var age = "";
        var month = Number(bod.substr(5,2));
        var day = Number(bod.substr(8,2));

        // Get Year
        age = today.getFullYear() - bod.substring(0,4);
        if (today.getMonth() < (month - 1)) {
            age--;
        }
        if (((month - 1) == today.getMonth()) && (today.getDate() < day)) {
            age--;
        }
        $('#UmurThn').val(age);

        // Get Month
        var calMonth = (today.getMonth()+1)-month;
        if ( calMonth < 0) {
            if (calMonth < 0) {
                var generateMonth = calMonth+12;
                $('#UmurBln').val(generateMonth);
            }else{
                $('#UmurBln').val(calMonth);
            }
        }else{
            // var valMonth = today.getMonth() - month;
            
            $('#UmurBln').val(calMonth);
        }

        // Get Day
        var callDay = today.getDate()-day;
        if ( callDay < 0) {
            if (callDay < 0) {
                var generateDay = callDay+30;
                $('#UmurHari').val(generateDay);
            }else{
                $('#UmurHari').val(callDay);
            }
        }else{
            // var valMonth = today.getMonth() - month;
            
            $('#UmurHari').val(callDay);
        }
    }

    function search_regno(regno) {
        $.ajax({
            url:"<?= base_url('registrasi/search_regno')?>",
            type:"get",
            data:{
                regno: regno,
            },
            success: function(response)
            {
                console.log(response.data);
                $('#Kunjungan').val('Lama');
                $('#Medrec').val(response.data.Medrec);
                $('#Notelp').val(response.data.phone);
                $('#kat_NoRM').val(response.data.Medrec);
                $('#kat_Firstname').val(response.data.Firstname);
                $('#Kategori').val(response.data.Kategori);
                $('#Regdate').val(response.data.Regdate.substring(0,10));
                $('#NomorUrut').val(response.data.NomorUrut);
                $('#Firstname').val(response.data.Firstname);
                $('#NoIden').val(response.data.nikktp);
                $('#pisat').val(response.data.Pisat);
                $('#noKartu').val(response.data.NoPeserta);
                $('#TglDaftar').val(response.data.Regdate.substring(0,10));
                $('#Bod').val(response.data.Bod.substring(0,10));
                sum_bod(response.data.Bod.substring(0,10));
                $('#statusPeserta').val(response.data.StatPeserta);
                $('#Peserta').val(response.data.NmRefPeserta);
                if (response.data.KdSex != null) {
                    $("input[name=KdSex][value="+response.data.KdSex.toUpperCase()+"]").attr('checked', 'checked');
                }
                $('#catatan').val(response.data.Catatan);
            }
        });
    }

</script>