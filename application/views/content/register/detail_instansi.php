<style>
    .cover{
        object-fit: cover;
        max-width:  70%;
        height: auto;
    }
</style>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="col-sm-12">
                <div class="col-sm-12 col-md-12">
                    <p><u>Update Bukti Bayar Instansi</u></p>
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="table_rincian" class ="table" width="100" border="0">
                                    <thead>
                                        <tr>
                                            <td width="30%">Nama Instansi</td> 
                                            <td width="70%">: <?=$data->Nama_perusahaan ?></td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Register Instansi</td> 
                                            <td width="70%">: <?=$data->No_register ?> </td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Tanggal Daftar</td> 
                                            <td width="70%">: <?= date('d-m-Y', strtotime($data->Regdate)) ?> </td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Jumlah Peserta Didaftarkan</td> 
                                            <td width="70%">: <?=$data->jumlah_peserta ?> </td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Pemeriksaan</td> 
                                            <td width="70%">: <?=$data->KdDetail_tindakan ?> </td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Status Bukti Bayar</td> 
                                            <td width="70%">: <?php if($data->tgl_upload == null) {
                                                echo "Belum Upload Bukti";
                                            } else{ echo "Sudah Upload Bukti Tanggal ".date("d-m-Y", strtotime($data->tgl_upload)); } ?> </td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Status Pembayaran Kasir</td> 
                                            <td width="70%">: <?php if($data->Cetak_kwitansi == null) {echo'Belum Cetak Kwitansi';} else{ echo 'Sudah Cetak Kwitansi Tanggal '.date("d-m-Y", strtotime($data->Cetak_kwitansi));} ?> </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="loading_home" style="margin-bottom: 30px">
                            <div class="table-responsive">
                                <table id="table_detail" class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Register Peserta</th>
                                            <th>Nama Peserta</th>
                                            <th>Nik Peserta</th>
                                            <th>Tgl Lahir Peserta</th>
                                            <th>No Hp Peserta</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-lg-12 row">
                            <?php echo form_open_multipart('Registrasi/do_upload');?>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Bukti Pembayaran</label>
                                    <div class="input-group col-sm-9">
                                        <input type="file" name="Pict" id="Pict" class="form-input" required value="<?php if(!empty($data)){echo $data->file_photo;}else{echo "";}  ?>">
                                        <input type="hidden" name="title" id="title" value="<?= $regno_instansi ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <button type="submit" id="btnUpload" class="btn btn-info btn-xs btn-round">Upload</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group container">
                                <img src="<?=base_url('assets/images/bukti_bayar_instansi/'.$data->file_photo)?>" width="600" height="300" class="cover" alt="PHOTO">
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
  var tabel_view;
  var loading = $('.modal-loading');
  var regno_instansi = '<?= $regno_instansi ?>';
  $(function() {
    $('.input-daterange').datepicker({autoclose:true, format: 'yyyy-mm-dd'});
    tabel_view = $('#table_detail').DataTable({
      dom : "fltrip",
      "processing": true,
      "serverside" : false,
      "language": {
        "loadingRecords": "&nbsp;",
        "processing": "data Loading..."
      }, 
      ajax: {
        "url": '<?php echo site_url('Registrasi/show_data')?>',
        "type": 'POST', 
        "data": {'regno' : regno_instansi},
      },
      columns: [
        { data: "no" },
        { data: "regno" },
        { data: "nama" },
        { data: "nik" },
        { data: "tgllahir" },
        { data: "nohp" }
      ],
      columnDefs: [
        { targets: [ 0 ], visible: true },
      ]
    });

    $('#cari').on('click', function(ev) {
        loading.modal('show');
        tabel_view.ajax.reload();
    });

  });
</script>