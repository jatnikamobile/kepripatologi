<div id="group-pembanding">
    <div class="table-wrapper-scroll-y my-custom-scrollbar-pembanding masuk">
        <table class="table table-bordered table-striped mb-0" id="pembanding-lab">
            <thead>
                <tr class="info">
                    <th>Kode</th>
                    <th>Pemeriksaan</th>
                    <th>Satuan</th>
                    <th>Set Awal Pria</th>
                    <th>Set Akhir Pria</th>
                    <th>Set Awal Wanita</th>
                    <th>Set Awal Wanita</th>
                    <th>Nilai Normal Pria</th>
                    <th>Nilai Normal Wanita</th>
                    <th><button type="button" class="btn btn-success btn-xs btn-round" data-toggle="modal" data-target=".create-pembanding-lab"><i class="fa fa-plus"></i></button></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pembanding as $key => $l):?>
                <tr data-id='<?=$l->KodeDetail ?>' data-json='<?= json_encode($l) ?>'>
                    <td><?=@$l->KodeDetail?></td>
                    <td><?=@$l->NamaDetail?></td>
                    <td><?=@$l->Satuan?></td>
                    <td><?=@$l->NNAwalPria?></td>
                    <td><?=@$l->NNAkhirPria?></td>
                    <td><?=@$l->NNAwalWanita?></td>
                    <td><?=@$l->NNAkhirWanita?></td>
                    <td><?=@$l->NilaiNormalPria?></td>
                    <td><?=@$l->NilaiNormalWanita?></td>
                    <td><button type="button" class="btn btn-primary btn-xs btn-round btn-edit-pembanding"><i class="fa fa-pencil"></i></button>
                        <a href="#" class="btn btn-xs btn-danger btndeletePemeriksaan" onclick="delete_detail_pemeriksaan(this.id)" id="<?= @$l->KodeDetail ?>"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade edit-pembanding-lab" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="edit-pembanding-lab">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Pembanding Laboraturium</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Kode:</label>
                        <input type="text" class="form-control col-sm-3" id="kodedetail" name="kodedetail" readonly>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Pemeriksaan:</label>
                        <input type="text" class="form-control" id="namadetail" name="namadetail">
                    </div>
                    <div class="form-group" style="border: 1px solid grey; border-radius: 5px; padding: 5px;">
                        <label for="message-text" class="col-form-label">Nilai Normal Pria:</label>
                        <input type="text" class="form-control" id="nilainormalpriapembanding" name="nilainormalpriapembanding">
                        <span>Nilai Awal Pria</span>
                        <input type="number" class="" id="NilaiAwalPriaPembanding" name="NilaiAwalPriaPembanding">
                        <span>S/D</span>
                        <input type="number" class="" id="NilaiAkhirPriaPembanding" name="NilaiAkhirPriaPembanding">
                    </div>
                    <div class="form-group" style="border: 1px solid grey; border-radius: 5px; padding: 5px;">
                        <label for="message-text" class="col-form-label">Nilai Normal Wanita:</label>
                        <input type="text" class="form-control" id="nilainormalwanitapembanding" name="nilainormalwanitapembanding">
                        <span>Nilai Awal Wanita</span>
                        <input type="number" class="" id="NilaiAwalWanitaPembanding" name="NilaiAwalWanitaPembanding">
                        <span>S/D</span>
                        <input type="number" class="" id="NilaiAkhirWanitaPembanding" name="NilaiAkhirWanitaPembanding">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Satuan:</label>
                        <input type="text" class="form-control" id="satuanpembanding" name="satuanpembanding">
                    </div>
                    <div class="form-group">
                        <div class="radio">
                            <label>
                                <input name="KdInputPembanding" type="radio" class="ace" value="1"/>
                                <span class="lbl">&nbsp; Text</span>
                            </label>
                            <label>
                                <input name="KdInputPembanding" type="radio" class="ace" value="2"/>
                                <span class="lbl">&nbsp; Pilihan</span>
                            </label>
                            <label>
                                <input name="KdInputPembanding" type="radio" class="ace" value="3"/>
                                <span class="lbl">&nbsp; Text Area</span>
                            </label>
                            <label>
                                <input name="KdInputPembanding" type="radio" class="ace" value="4"/>
                                <span class="lbl">&nbsp; Kosong/Tidak diisi</span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-xs btn-round" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-xs btn-round" id="btnPembandingEdit">Ubah</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade create-pembanding-lab" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="create-pembanding-lab">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembanding Laboraturium Baru</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Pemeriksaan:</label>
                        <input type="hidden" class="form-control" id="kodedetail_input" name="kodedetail_input">
                        <input type="text" class="form-control" id="detailpembanding_input" name="detailpembanding_input">
                    </div>
                    <div class="form-group" style="border: 1px solid grey; border-radius: 5px; padding: 5px;">
                        <label for="message-text" class="col-form-label">Nilai Normal Pria:</label>
                        <input type="text" class="form-control" id="nilainormalpriapembanding_input" name="nilainormalpriapembanding_input">
                        <span>Nilai Awal Pria</span>
                        <input type="number" class="" id="NilaiAwalPriaPembanding_input" name="NilaiAwalPriaPembanding_input">
                        <span>S/D</span>
                        <input type="number" class="" id="NilaiAkhirPriaPembanding_input" name="NilaiAkhirPriaPembanding_input">
                    </div>
                    <div class="form-group" style="border: 1px solid grey; border-radius: 5px; padding: 5px;">
                        <label for="message-text" class="col-form-label">Nilai Normal Wanita:</label>
                        <input type="text" class="form-control" id="nilainormalwanitapembanding_input" name="nilainormalwanitapembanding_input">
                        <span>Nilai Awal Wanita</span>
                        <input type="number" class="" id="NilaiAwalWanitaPembanding_input" name="NilaiAwalWanitaPembanding_input">
                        <span>S/D</span>
                        <input type="number" class="" id="NilaiAkhirWanitaPembanding_input" name="NilaiAkhirWanitaPembanding_input">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Satuan:</label>
                        <input type="text" class="form-control" id="satuanpembanding_input" name="satuanpembanding_input">
                    </div>
                    <div class="form-group">
                        <div class="radio">
                            <label>
                                <input name="KdInputPembanding_input" type="radio" class="ace" value="1" checked />
                                <span class="lbl">&nbsp; Text</span>
                            </label>
                            <label>
                                <input name="KdInputPembanding_input" type="radio" class="ace" value="2"/>
                                <span class="lbl">&nbsp; Pilihan</span>
                            </label>
                            <label>
                                <input name="KdInputPembanding_input" type="radio" class="ace" value="3"/>
                                <span class="lbl">&nbsp; Text Area</span>
                            </label>
                            <label>
                                <input name="KdInputPembanding_input" type="radio" class="ace" value="4"/>
                                <span class="lbl">&nbsp; Kosong/Tidak diisi</span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-xs btn-round" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-xs btn-round" id="btnPembandingCreate">Simpan</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#pembanding-lab').on("click", '.btn-edit-pembanding', function(){
        let button = $(this);
        let tr = button.parents('tr');
        let data = JSON.parse(tr.attr('data-json'));
        console.log(data);
        $('#edit-pembanding-lab [name=kodedetail]').val(data.KodeDetail);
        $('#edit-pembanding-lab [name=namadetail]').val(data.NamaDetail);
        $('#edit-pembanding-lab [name=satuanpembanding]').val(data.Satuan);
        $('#edit-pembanding-lab [name=nilainormalpriapembanding]').val(data.NilaiNormalPria);
        $('#edit-pembanding-lab [name=NilaiAwalPriaPembanding]').val(data.NNAwalPria);
        $('#edit-pembanding-lab [name=NilaiAkhirPriaPembanding]').val(data.NNAkhirPria);
        $('#edit-pembanding-lab [name=nilainormalwanitapembanding]').val(data.NilaiNormalWanita);
        $('#edit-pembanding-lab [name=NilaiAwalWanitaPembanding]').val(data.NNAwalWanita);
        $('#edit-pembanding-lab [name=NilaiAkhirWanitaPembanding]').val(data.NNAkhirWanita);
        if (data.KdInput != '') {
            $("input[name=KdInputPembanding][value=" + data.KdInput + "]").attr('checked', 'checked');
            // $('#edit-pemeriksaan-lab [name=KdInputPembanding]:checked').val(data.KdInput);
        }
        $('#edit-pembanding-lab').modal('toggle');
    });

    $('#btnPembandingCreate').on('click', function(ev){
        ev.preventDefault();
        $.ajax({
            type:'POST',
            url:"<?= base_url('mastertarif/pembandingan_post') ?>",
            data:{
                kddetail: $('#kodedetail_input').val(),
                detail: $('#detailpembanding_input').val(),
                satuan: $('#satuanpembanding_input').val(),
                kdinput: $('input[name=KdInputPembanding_input]:checked').val(),
                nilainormalpria: $('#nilainormalpriapembanding_input').val(),
                nnawalpria: $('#NilaiAwalPriaPembanding_input').val(),
                nnakhirpria: $('#NilaiAkhirPriaPembanding_input').val(),
                nilainormalwanita: $('#nilainormalwanitapembanding_input').val(),
                nnawalwanita: $('#NilaiAwalWanitaPembanding_input').val(),
                nnakhirwanita: $('#NilaiAkhirWanitaPembanding_input').val()
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

    $('#btnPembandingEdit').on('click', function(ev){
        ev.preventDefault();
        $.ajax({
            type:'POST',
            url:"<?= base_url('mastertarif/pembanding_update') ?>",
            data:{
                id: $('#kodedetail').val(),
                nmdetail: $('#namadetail').val(),
                satuan: $('#satuanpembanding').val(),
                kdinput: $('input[name=KdInputPembanding]:checked').val(),
                nilainormalpria: $('#nilainormalpriapembanding').val(),
                nnawalpria: $('#NilaiAwalPriaPembanding').val(),
                nnakhirpria: $('#NilaiAkhirPriaPembanding').val(),
                nilainormalwanita: $('#nilainormalwanitapembanding').val(),
                nnawalwanita: $('#NilaiAwalWanitaPembanding').val(),
                nnakhirwanita: $('#NilaiAkhirWanitaPembanding').val()
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

    function delete_detail_pemeriksaan(kode) {
        $.ajax({
            type:'POST',
            url:"<?= base_url('mastertarif/delete_detail_pemeriksaan') ?>",
            data:{
                kode: kode
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