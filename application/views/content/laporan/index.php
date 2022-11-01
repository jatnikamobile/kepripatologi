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
        <form id="search_laporan" >
                <div class="row clearfix">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label>Dari Tanggal</label>
                        <div class="form-line">
                            <input type="text" name="tgl_awal" class="form-control" value="<?= date('d-m-Y') ?>" id="tgl_awal">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label >Sampai Tanggal</label>
                        <div class="form-line">
                            <input type="text" name="tgl_akhir" class="form-control" id="tgl_akhir" value="<?=date('d-m-Y')?>" >
                        </div>
                    </div>  
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                    <label >Instansi</label>
                    <div class="form-line">
                      <select name="instansi" id="instansi" class="form-control">
                        <option value="">Semua</option>
                        <?php foreach($instansi as $item): ?>
                          <option value="<?= $item->KdInstansi ?>"><?= $item->NmInstansi ?></option>
                        <?php endforeach; ?>
                      </select>
                      <select name="instansi_hide" id="instansi_hide" class="form-control" style="display:none">
                        <option value="">Semua</option>
                        <?php foreach($instansi as $item): ?>
                          <option value="<?= $item->KdInstansi ?>"><?= $item->NmInstansi ?></option>
                        <?php endforeach; ?>
                      </select>
                  </div>
                  </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                    <label >Hasil</label>
                    <div class="form-line">
                      <select name="hasil" class="form-control">
                        <option value="">Semua</option>
                        <?php foreach($hasil as $item): ?>
                          <option value="<?= $item->NmHasil ?>"><?= $item->NmHasil ?></option>
                        <?php endforeach; ?>
                      </select>
                  </div>
                  </div>
                </div>
                <div class="form-group">
                    <button type="button" name="cari" class="btn btn-primary btn-block" id="cari" >Cari Data</button>
                </div>
            </div>
        </form>
        <!-- Tab panes -->
        <div class="table-responsive pemeriksaan-tarif">
            <table class="table table-sm table pemeriksaan-tarif" id="kel_pemeriksaan">
                <thead>
                    <tr class="success">
                        <th style=" text-align: center; float: center">No</th>
                        <th style=" text-align: center;" >No RM</th>
                        <th style=" text-align: center;" >No Lab</th>
                        <th style=" text-align: center;" >No KTP</th>
                        <th style=" text-align: center;" >Nama</th>
                        <th style=" text-align: center;" >Jenis Kelamin</th>
                        <th style=" text-align: center;" >Tanggal Lahir</th>
                        <th style=" text-align: center;" >Umur</th>
                        <th style=" text-align: center;" >Tgl Terima Sampel</th>
                        <th style=" text-align: center;" >Tgl Periksa</th>
                        <th style=" text-align: center;" >Jenis Sampel</th>
                        <th style=" text-align: center;" >Jenis Pemeriksaan</th>
                        <th style=" text-align: center;" >Dokter Pengirim</th>
                        <th style=" text-align: center;" >Hasil Periksa</th>
                        <th style=" text-align: center;" >Instansi</th>
                        <th style=" text-align: center;" >Keterangan</th>
                        <th style=" text-align: center;" >No Hp</th>
                        <th style=" text-align: center;" >Pengambil Sampel</th>
                        <th style=" text-align: center;" >Verifikator</th>
                        <th style=" text-align: center;" >Validator</th>
                        <th style=" text-align: center;" >Print</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
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
    </div>
<script>
    var tabel;
    var sessionInstansi = "<?php echo $this->session->userdata('kdInstansi');?>";
    $(document).ready(function(){
        $('#tgl_awal').datepicker({autoclose:true, format: 'dd-mm-yyyy'});
        $('#tgl_akhir').datepicker({autoclose:true, format: 'dd-mm-yyyy'});

        if(sessionInstansi!=""){
            $('#instansi').val(sessionInstansi).trigger('change');
            $('#instansi_hide').val(sessionInstansi).trigger('change');
            $('#instansi_hide').css("display", "block");
            $('#instansi_hide').prop('disabled', true);
            $('#instansi').css("display", "none");
        }

        tabel = $('#kel_pemeriksaan').DataTable({
            dom : "fBi", 
            paging: false,
            ajax:{
                "url": '<?php echo base_url('laporan/getDataTable')?>',
                "type": 'POST',
                "cache": false,
                "data": function ( d ) {
                    return $('#search_laporan').serialize();
                },
                beforeSend: function(){
                  // Here, manually add the loading message.
                  $('#kel_pemeriksaan > tbody').html(
                    '<tr class="odd">' +
                      '<td valign="top" colspan="19" class="dataTables_empty"><i class="fa fa-spinner fa-spin fa-2x fa-fw"></i> <span>Loading</span></td>' +
                    '</tr>'
                  );
                },
            },
            columns: [
                { data: "no" },
                { data: "rm" },
                { data: "nolab" },
                { data: "nikktp" },
                { data: "nama" },
                { data: "jenkel" },
                { data: "tgl_lahir" },
                { data: "umur" },
                { data: "tgl_sampel" },
                { data: "tanggal_periksa" },
                { data: "jenis_sampel" },
                { data: "tindakan" },
                { data: "pengirim" },
                { data: "hasil" },
                { data: "instansi" },
                { data: "keterangan" },
                { data: "telp" },
                { data: "pengambil_sampel" },
                { data: "verifikator" },
                { data: "setujui" },
                { data: "print" }
            ],
            columnDefs: [
                { targets: [ 0 ], visible: true }
            ],
        });
        $('#cari').on('click', function(ev) {
            ev.preventDefault();
            tabel.ajax.reload();
        });
    });

    function print(data) {
        var text= '<?= date('d F Y') ?>';
        var tgll = prompt("Masukkan Tanggal", text);
        var xhr = $.ajax({
            type: "GET",
            data: {
                "notran": data, "tanggal_ttd":tgll
            },
            url:"<?=base_url('laporan/print_hasil_pemeriksaan')?>",
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

    function print_eng(data) {
        var text= '<?= date('F dS Y') ?>';
        var tgll = prompt("Masukkan Tanggal", text);
        var xhr = $.ajax({
            type: "GET",
            data: {
                "notran": data, "tanggal_ttd":tgll
            },
            url:"<?=base_url('laporan/print_hasil_pemeriksaan_eng')?>",
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

</script>
