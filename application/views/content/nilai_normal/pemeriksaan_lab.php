<div id="group-pemeriksaan">
    <div class="table-wrapper-scroll-y my-custom-scrollbar masuk">
        <table class="table table-bordered table-striped mb-0" id="pemeriksaan-lab">
            <thead>
                <tr class="info">
                    <th>Kode Group</th>
                    <th>Pemeriksaan</th>
                    <th>Satuan</th>
                    <th><button type="button" class="btn btn-success btn-xs btn-round" data-toggle="modal" data-target=".create-pemeriksaan-lab"><i class="fa fa-plus"></i></button></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pemeriksaan as $key => $l):?>
                <tr data-id='<?=$l->KDDetail ?>' data-json='<?= json_encode($l) ?>'>
                    <td><?=@$l->KDDetail?></td>
                    <td><a href="#" id="<?=@$l->KDDetail?>" onclick="load_pembanding(this.id)"><?=@$l->NMDetail?></td>
                    <td><?=@$l->Satuan?></td>
                    <td>
                        <button type="button" class="btn btn-primary btn-xs btn-round btn-edit-pemeriksaan"><i class="fa fa-pencil"></i></button>
                        <a href="#" class="btn btn-xs btn-danger btndeleteSubPemeriksaan" onclick="delete_sub_pemeriksaan(this.id)" id="<?= @$l->KDDetail ?>"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade edit-pemeriksaan-lab" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="edit-pemeriksaan-lab">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Pemeriksaan Patalogi Anatomi</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Kode:</label><br>
                        <input type="text" id="kddetail" name="kddetail" readonly>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Pemeriksaan:</label>
                        <input type="text" class="form-control" id="detail" name="detail">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Satuan:</label>
                        <input type="text" class="form-control" id="satuan" name="satuan">
                    </div>
                    <div class="form-group">
                        <div class="radio">
                            <label>
                                <input name="KdInput" type="radio" class="ace" value="1"/>
                                <span class="lbl">&nbsp; Text</span>
                            </label>
                            <label>
                                <input name="KdInput" type="radio" class="ace" value="2"/>
                                <span class="lbl">&nbsp; Pilihan</span>
                            </label>
                            <label>
                                <input name="KdInput" type="radio" class="ace" value="3"/>
                                <span class="lbl">&nbsp; Text Area</span>
                            </label>
                            <label>
                                <input name="KdInput" type="radio" class="ace" value="4"/>
                                <span class="lbl">&nbsp; Kosong/Tidak diisi</span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-xs btn-round" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-xs btn-round" id="btnPemeriksaanEdit">Ubah</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade create-pemeriksaan-lab" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="create-pemeriksaan-lab">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pemeriksaan Patalogi Anatomi Baru</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Pemeriksaan:</label>
                        <input type="hidden" class="form-control" id="kodegroup_input" name="kodegroup_input">
                        <input type="text" class="form-control" id="detail_input" name="detail_input">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Satuan:</label>
                        <input type="text" class="form-control" id="satuan_input" name="satuan_input">
                    </div>
                    <div class="form-group">
                        <div class="radio">
                            <label>
                                <input name="KdInput_input" type="radio" class="ace" value="1" checked />
                                <span class="lbl">&nbsp; Text</span>
                            </label>
                            <label>
                                <input name="KdInput_input" type="radio" class="ace" value="2"/>
                                <span class="lbl">&nbsp; Pilihan</span>
                            </label>
                            <label>
                                <input name="KdInput_input" type="radio" class="ace" value="3"/>
                                <span class="lbl">&nbsp; Text Area</span>
                            </label>
                            <label>
                                <input name="KdInput_input" type="radio" class="ace" value="4"/>
                                <span class="lbl">&nbsp; Kosong/Tidak diisi</span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-xs btn-round" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-xs btn-round" id="btnPemeriksaanCreate">Simpan</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#pemeriksaan-lab').on("click", '.btn-edit-pemeriksaan', function(){
        let button = $(this);
        let tr = button.parents('tr');
        let data = JSON.parse(tr.attr('data-json'));
        console.log(data);
        $('#create-pemeriksaan-lab [name=kodegroup_input]').val(data.KdGroup);
        $('#edit-pemeriksaan-lab [name=kddetail]').val(data.KDDetail);
        $('#edit-pemeriksaan-lab [name=detail]').val(data.NMDetail);
        $('#edit-pemeriksaan-lab [name=satuan]').val(data.Satuan);
        $('#edit-pemeriksaan-lab [name=kdmapping]').val(data.KdMapping);
        $('#edit-pemeriksaan-lab [name=nilainormalpria]').val(data.NilaiNormalPria);
        $('#edit-pemeriksaan-lab [name=NilaiAwalPria]').val(data.NNAwalPria);
        $('#edit-pemeriksaan-lab [name=NilaiAkhirPria]').val(data.NNAkhirPria);
        $('#edit-pemeriksaan-lab [name=nilainormalwanita]').val(data.NilaiNormalWanita);
        $('#edit-pemeriksaan-lab [name=NilaiAwalWanita]').val(data.NNAwalWanita);
        $('#edit-pemeriksaan-lab [name=NilaiAkhirWanita]').val(data.NNAkhirWanita);
        if (data.KdInput != '') {
            $("[name=KdInput][value=" + data.KdInput + "]").attr('checked', 'checked');
            // $('#edit-pemeriksaan-lab [name=KdInput]:checked').val(data.KdInput);
        }
        $('#edit-pemeriksaan-lab').modal('toggle');
    });

    $('#btnPemeriksaanCreate').on('click', function(ev){
        ev.preventDefault();
        $.ajax({
            type:'POST',
            url:"<?= base_url('mastertarif/pemeriksaan_post') ?>",
            data:{
                kdgroup: $('#kodegroup_input').val(),
                detail: $('#detail_input').val(),
                satuan: $('#satuan_input').val(),
                kdinput: $('input[name=KdInput_input]:checked').val(),
                nilainormalpria: $('#nilainormalpria_input').val(),
                nnawalpria: $('#NilaiAwalPria_input').val(),
                nnakhirpria: $('#NilaiAkhirPria_input').val(),
                nilainormalwanita: $('#nilainormalwanita_input').val(),
                nnawalwanita: $('#NilaiAwalWanita_input').val(),
                nnakhirwanita: $('#NilaiAkhirWanita_input').val(),
                kdmapping: $('#kdmapping_input').val()
            },
            success:function(resp){
                console.log(resp);
                if (resp.insert) {
                    load_detail(resp.kode);
                    alert(resp.message);
                } else{
                    alert(resp.message);
                }
            }
        });
    });

    $('#btnPemeriksaanEdit').on('click', function(ev){
        ev.preventDefault();
        $.ajax({
            type:'POST',
            url:"<?= base_url('mastertarif/pemeriksaan_update') ?>",
            data:{
                id: $('#kddetail').val(),
                kdgroup: $('#kodegroup_input').val(),
                detail: $('#detail').val(),
                satuan: $('#satuan').val(),
                kdinput: $('input[name=KdInput]:checked').val(),
                nilainormalpria: $('#nilainormalpria').val(),
                nnawalpria: $('#NilaiAwalPria').val(),
                nnakhirpria: $('#NilaiAkhirPria').val(),
                nilainormalwanita: $('#nilainormalwanita').val(),
                nnawalwanita: $('#NilaiAwalWanita').val(),
                nnakhirwanita: $('#NilaiAkhirWanita').val(),
                kdmapping: $('#kdmapping').val()
            },
            success:function(resp){
                console.log(resp);
                if (resp.insert) {
                    alert(resp.message);
                } else{
                    alert(resp.message);
                }
            }
        });
    });

    function delete_sub_pemeriksaan(kddetail) {
        $.ajax({
            type:'POST',
            url:"<?= base_url('mastertarif/delete_sub_pemeriksaan') ?>",
            data:{
                kddetail: kddetail
            },
            success:function(resp){
                console.log(resp);
                if (resp.status) {
                    alert(resp.message);
                } else{
                    alert(resp.message);
                }
            }
        });
    }
</script>