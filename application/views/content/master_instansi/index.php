<style type="text/css">
    .pemeriksaan-tarif {
        max-height: 500px;
        overflow: auto;
        background-color: transparent;
    }

    .nama-tarif {
        font-size: 9px;
    }
</style>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <!-- Tab panes -->
        <div class="col-sm-6 col-md-6">
            <button type="button" class="btn btn-success btn-xs btn-round" data-toggle="modal" data-target=".create-instansi"><i class="fa fa-plus"></i></button>
            <div class="table-responsive pemeriksaan-tarif">
                <table class="table table-sm table pemeriksaan-tarif" id="kel_pemeriksaan">
                    <thead>
                        <tr class="success">
                            <th style="width:5%;">Kode</th>
                            <th>Keterangan</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Tampil Laporan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($instansi as $key => $l):?>
                            <?php 
                            $laporan="";
                            if($l->TmplLaporan==0){
                                $laporan="Tidak";
                            }else{
                                $laporan="Ya";
                            }
                            // echo '<pre>'; print_r($l); ?>
                            <tr data-id='<?=$l->KdInstansi ?>' data-json='<?= json_encode($l) ?>'>
                                <td><?=@$l->KdInstansi?></td>
                                <td><a href="#" id="<?=@$l->KdInstansi?>" onclick="load_tarif(this.id)"><?=@$l->NmInstansi?></a></td>
                                <td><?=@$l->username_instansi?></td>
                                <td><?=@$l->password_instansi?></td>
                                <td><?=@$laporan?></a></td>
                                <td><button type="button" class="btn btn-primary btn-xs btn-round" data-toggle="modal" data-target=".edit-pass" data-id="<?=$l->KdInstansi?>"data-nm="<?=$l->NmInstansi?>"data-user="<?=$l->username_instansi?>"data-pass="<?=$l->password_instansi?>" data-laporan="<?=$l->TmplLaporan?>"><i class="fa fa-pencil"></i></button></td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
                <p><u>Detail</u></p>
                <div class="detail-tarif">
            </div>
        </div>
</div>
<div class="modal fade create-instansi" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="create-tarif-lab">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Master Instansi</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="col-sm-12">
                            <label for="recipient-name" class="col-form-label">Nama Instansi</label>
                            <input type="text" class="form-control col-sm-3" id="instansi" name="instansi"><br>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-xs btn-round" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success btn-xs btn-round" id="btnTarifBaru">Simpan</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade edit-pass" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="edit-instansi">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Master Instansi</h5>
            </div>
            <div class="modal-body">
                <form id="edit_instansi">
                    <div class="col-sm-12">
                            <label for="recipient-name" class="col-form-label">Nama Instansi</label>
                            <input type="text" class="form-control col-sm-3" id="nm_instansi" name="nm_instansi" readonly><br>
                            <input type="hidden" class="form-control col-sm-3" id="kd_instansi" name="kd_instansi"><br>
                    </div>
                    <div class="col-sm-12">
                            <label for="recipient-name" class="col-form-label">Username Instansi</label>
                            <input type="text" class="form-control col-sm-3" id="user_instansi" name="user_instansi" readonly><br>
                    </div>
                    <div class="col-sm-12">
                            <label for="recipient-name" class="col-form-label">Pass Instansi</label>
                            <input type="text" class="form-control col-sm-3" id="pass_instansi" name="pass_instansi"><br>
                    </div>
                    <div class="col-sm-12">
                            <label for="tampil_laporan" class="col-form-label">Tampil Laporan</label>
                            <select id="tampil_laporan" name="tampil_laporan" class="form-control col-sm-3">
                                <option value="0">Jangan Tampilkan</option>
                                <option value="1">Tampilkan</option>
                            </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-xs btn-round" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success btn-xs btn-round" id="btnEditInstansi">Simpan</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#nama_pemeriksaan').DataTable({
            dom : "f", 
            "search": true,
            paging: false
        });
        $('#kel_pemeriksaan').DataTable({
            dom : "f", 
            "search": true,
            paging: false
        });
        $('#edit-instansi').on('show.bs.modal', function(e) {
            var kd_instansi = $(e.relatedTarget).data('id');
            var nm_instansi = $(e.relatedTarget).data('nm');
            var user_instansi = $(e.relatedTarget).data('user');
            var pass_instansi = $(e.relatedTarget).data('pass');
            var tampil_laporan = $(e.relatedTarget).data('laporan');
            $('#kd_instansi').val(kd_instansi); 
            $('#nm_instansi').val(nm_instansi); 
            $('#user_instansi').val(user_instansi); 
            $('#pass_instansi').val(pass_instansi); 
            $('#tampil_laporan').val(tampil_laporan).trigger('change'); 
        });
        $('#btnTarifBaru').on('click', function(ev){
        ev.preventDefault();
            $.ajax({
                type:'POST',
                url:"<?= base_url('masterinstansi/insert_instansi') ?>",
                data:{
                    instansi: $('#instansi').val(),
                },
                success:function(resp){
                    if (resp.insert) {
                        alert(resp.message);
                        location.reload();
                    } else{
                        alert(resp.message);
                    }
                }
            });
        });
        $('#btnEditInstansi').on('click', function(ev){
        ev.preventDefault();
            $.ajax({
                type:'POST',
                url:"<?= base_url('masterinstansi/update_instansi') ?>",
                data:$('#edit_instansi').serialize(),
                success:function(resp){
                    if (resp.update) {
                        location.reload();
                    } else{
                        alert(resp.message);
                    }
                }
            });
        });
    });

    window.load_tarif = function(node)
    {
        $.ajax({
            type:'POST',
            url:"<?= base_url('masterinstansi/show_tarif') ?>",
            data:{KdInstansi:node},
            dataType:'html',
            beforeSend:function(){
                $('.detail-tarif').html('<div class="alert alert-info">Memuat Data <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span></div>');
            },
            success:function(resp){
                // $('#btnBackGroup').show().fadeIn(3000);
                $('.detail-tarif').html(resp);
            }
        });
    }
</script>
