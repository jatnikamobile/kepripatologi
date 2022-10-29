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
        <div class="col-sm-12 col-md-12">
            <button type="button" class="btn btn-success btn-xs btn-round" data-toggle="modal" data-target=".create-instansi"><i class="fa fa-plus"></i></button>
            <div class="table-responsive pemeriksaan-tarif">
                <table class="table table-sm table pemeriksaan-tarif" id="kel_pemeriksaan">
                    <thead>
                        <tr class="success">
                            <th style="width:5%;">ID Negara</th>
                            <th>Nama Negara</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($negara as $key => $l):?>
                            <?php 
                            // echo '<pre>'; print_r($l); ?>
                            <tr data-id='<?=$l->id_negara ?>' data-json='<?= json_encode($l) ?>'>
                                <td><?=@$l->id_negara?></td>
                                <td><?=@$l->nm_negara?></td>
                                <td><button type="button" class="btn btn-danger btn-xs btn-round" onclick="del('<?=$l->id_negara?>')"><i class="fa fa-trash"></i></button></td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
</div>
<div class="modal fade create-instansi" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="create-tarif-lab">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Master Negara</h5>
            </div>
            <div class="modal-body" style="margin-bottom: 50px;">
                <form>
                    <div class="col-sm-12">
                            <label for="recipient-name" class="col-form-label">Nama Negara</label>
                            <input type="text" class="form-control col-sm-3" id="nm_negara" name="nm_negara"><br>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-xs btn-round" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success btn-xs btn-round" id="btnNegaraAdd">Simpan</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#btnNegaraAdd').on('click', function(ev){
        ev.preventDefault();
            $.ajax({
                type:'POST',
                url:"<?= base_url('masternegara/insert_negara') ?>",
                data:{
                    nm_negara: $('#nm_negara').val(),
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
    });

    window.load_tarif = function(node)
    {
        $.ajax({
            type:'POST',
            url:"<?= base_url('masternegara/show_tarif') ?>",
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

    function del(id_negara){

        $.ajax({
                type:'POST',
                url:"<?= base_url('masternegara/delete') ?>",
                data:{
                    id_negara: id_negara,
                },
                success:function(resp){
                    if (resp.delete) {
                        alert(resp.message);
                        location.reload();
                    } else{
                        alert(resp.message);
                    }
                }
            });
    }
</script>
