<div class="table-responsive pemeriksaan-tarif">
    <table class="table table-sm table pemeriksaan-tarif" id="table-unit">
        <thead>
            <tr class="success">
                <th>Kode Unit</th>
                <th>Nama Unit</th>
                <th><button type="button" class="btn btn-success btn-xs btn-round" data-toggle="modal" data-target=".create-tarif-lab"><i class="fa fa-plus"></i></button></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($unit as $key => $l):?>
            <tr data-id='<?=$l->KdUnit ?>' data-json='<?= json_encode($l) ?>'>
                <td><?=@$l->KdUnit?></td>
                <td><?=@$l->NmUnit?></td>
                <td>
                    <button type="button" id="<?=@$l->KdUnit?>" onclick="load_tarif(this.id)" class="btn btn-danger btn-xs btn-round"><i class="fa fa-trash"></i></button></td>
            </tr>
            <?php endforeach?>
        </tbody>
    </table>
</div>

<div class="modal fade create-tarif-lab" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="create-tarif-lab">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Master Unit</h5>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" class="form-control" id="kddetail" name="kddetail" value="<?=$kode?> ">
                    <div class="col-sm-12">
                            <label for="recipient-name" class="col-form-label">Nama Unit</label>
                            <input type="text" class="form-control col-sm-3" id="unit" name="unit">
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
<script>
    var table;
    $(document).ready(function(){

        table = $('#table-unit').DataTable({
            dom : "f", 
            "search": true,
            paging: false
        });
    });
    $('#btnTarifBaru').on('click', function(ev){
        ev.preventDefault();
        $.ajax({
            type:'POST',
            url:"<?= base_url('masterinstansi/insert') ?>",
            data:{
                unit: $('#unit').val(),
                kdInstansi: $('#kddetail').val(),
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

    window.load_tarif = function(node){
        $.ajax({
            type:'POST',
            url:"<?= base_url('masterinstansi/delete') ?>",
            data:{
                kdunit: node,
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