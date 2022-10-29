<div class="row">
    <div class="col-sm-12 col-md-12">
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="col-sm-12">
                <div class="pull-right" style="display: none;">
                    <button type="button" id="btn-histori" class="btn btn-success btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg-histori" style="width: 150px; height: 34px;">Histori Pasien</button>
                </div>
                <div class="col-sm-12 col-md-12">
                    <p><u>Update Pendaftaran Instansi</u></p>
                    <form method="post" class="row" id="form-psn-bpjs">
                        <div class="col-lg-12 row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Instansi*</label>
                                    <div class="input-group col-sm-9">
                                        <input type="hidden" name="Regno" id="Regno" readonly value="<?= $regno ?>" />
                                        <input type="text" name="instansi" id="instansi" readonly class="form-control" >
                                        <input type="hidden" name="NomorUrut" id="NomorUrut" readonly="readonly">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Unit*</label>
                                    <div class="input-group col-sm-9">
                                        <input type="text" name="unit" id="unit" readonly class="form-control" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right"> Tindakan*</label>
                                    <div class="input-group col-sm-9">
                                        <select name="tindakan" id="tindakan" class="form-control" disabled>
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
                                        <input type="number" name="jumlah_peserta" id="jumlah_peserta" class="form-control" aria-describedby="basic-addon2" readonly>
                                        <!-- <span class="input-group-addon" id="basic-addon2"> -->
                                            <!-- <a href="javascript:;" id="simpan_instansi" ><i class="fa fa-plus"></i></a></span> -->
                                    </div>
                                    </div>
                                </div>
                            </div>
                            
    
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="loading_home"></div>
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
                        <input type="hidden" name="change_keyakinan" id="change_keyakinan">
                        <input type="hidden" name="regold" id="regold">
                        <button type="submit" name="submit" id="submit" class="btn btn-success">Simpan</button>
                    </form>
                </div>
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
    $(document).ready(function(){
        // $('.dateformat').datepicker({autoclose:true, format: 'dd-mm-yyyy'});
        if ($('#Regno').val() != '') {
            search_regno($('#Regno').val());
        }
    });

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
                    '<input type="text" class="form-control" name="nik_peserta[]" id="nik_peserta">',
                    '<input type="text" class="form-control" name="nama_peserta[]" id="nama_peserta">',
                    '<select name="jenis_kelamin[]" id="jenis_kelamin" class="form-control"><option value="Laki-laki">Laki-laki</option><option value="Perempuan">Perempuan</option></select>',
                    '<input type="date" class="form-control tglLahir_peserta" name="tglLahir_peserta[]" id="tglLahir_peserta">',
                ] ).draw( false );
            }
        }else{
            alert('Isi data Instansi, Unit dan tindakan');
        }
        
    });

    $("#submit").on("click",function(e){
        e.preventDefault();
        let loading = $('.modal-loading');
        loading.modal('show');

        var h2 = $('#Regdate').val();

            $.ajax({
                url:"<?=base_url('registrasi/update_instansi')?>",
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
                    if (response) {
                        alert('Data Berhasil diubah');
                        window.location.replace("<?=base_url('list_pasien/instansi/')?>");
                    }else{
                        alert('Data Gagal diubah');
                    }
                }
            });
        
        loading.modal('hide');
    });


    function search_regno(regno) {
        $.ajax({
            url:"<?= base_url('registrasi/search_detail_instansi')?>",
            type:"get",
            data:{
                regno: regno,
            },
            success: function(response)
            {
                console.log(response);
                $('#instansi').val(response.Nama_perusahaan);
                $('#unit').val(response.NmUnit);
                $('#tindakan').val(response.KdDetail_tindakan).trigger('change');
                $('#jumlah_peserta').val(response.jumlah_peserta);
            }
        });
    }

</script>