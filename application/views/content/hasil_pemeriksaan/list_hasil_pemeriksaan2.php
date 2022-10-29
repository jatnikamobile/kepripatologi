<style type="text/css">
  #hasil-pemeriksaan td {
    border: 1px solid #00000037;
  }

  tr.highlight-danger {
        background: #CC3338; color: white;
    }
  .highlight-danger {
        background: #CC3338; color: white;
    }
  .highlight-warning {
        background: #FFFE66; 
    }

</style>
<div class="row">
  <div class="col-sm-12 col-md-12" style="border: 1px solid grey; border-radius: 5px;">
    <div class="row">
      <div class="col-md-12">
        <h4>List Pemeriksaan</h4>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <form id="searchForm" class="form-inline">
          <div class="pull-left">
            <label class="inline">
              <span class="lbl"> Tanggal: </span>
            </label>
            <div class="input-daterange input-group">
              <input type="text" name="from_date" class="input-sm date-picker" value="<?= html_escape($input['from_date']->format('Y-m-d')) ?>">
              <span class="input-group-addon">
                <i class="fa fa-exchange"></i>
              </span>
              <input type="text" name="to_date" class="input-sm date-picker" value="<?= html_escape($input['from_date']->format('Y-m-d')) ?>">
            </div>

			  <label class="inline" style="margin-left: 15px;" >
				  <span class="lbl">Ruangan : </span>
			  </label>
			  <select name="ruangan" >
				  <option value="">--Semua Ruangan--</option>
				  <?php foreach ($bangsals as $bangsal):?>
					  <option value="<?php echo $bangsal->NmBangsal;?>"
					  <?php echo $input['ruangan'] == $bangsal->NmBangsal ? 'selected' : ''?>
					  ><?php echo $bangsal->NmBangsal;?></option>
				  <?php endforeach;?>
			  </select>

            <label class="inline" style="margin-left: 15px;" >
              <span class="lbl" > Status Hasil: </span>
            </label>
            <select name="status_hasil" >
              <option value="">Semua</option>
              <?php $selected = 1 == $input['status_hasil'] ? 'selected="selected"' : ''; ?>
              <option value="1">Belum Terisi</option>
              <?php $selected = 2 == $input['status_hasil'] ? 'selected="selected"' : ''; ?>
              <option value="2">Sebagian Terisi</option>
              <?php $selected = 3 == $input['status_hasil'] ? 'selected="selected"' : ''; ?>
              <option value="3">Terisi Lengkap</option>
            </select>
            <button type="button" id="cari" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> CARI</button>
          </div>
        </form>
      </div>
    </div>
    <div class="row" style="margin-top: 14px;">
      <div class="col-md-12">
        <table class="table table-bordered mb-0" id="hasil-pemeriksaan">
          <thead>
            <tr>
<!--               <th>HasFilledIn</th>
              <th>HasNotFilled</th> -->
              <th style="width: 110px;">No. Transaksi</th>
              <th style="width: 70px;">No. Lab</th>
              <th style="width: 110px;">No. Registrasi</th>
              <th style="width: 70px;">No. RM</th>
              <th style="width: 90px;">Tgl. Hasil</th>
              <th >Nama (Umur)</th>
              <th>Kategori</th>
              <th>Catatan</th>
              <th>Poli</th>
              <th>Ruang</th>
              <th>Kelas</th>
              <th>Alamat / Catatan</th>
              <th style="width: 50px;">Print</th>
              <th style="width: 100px;">#</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
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
  var tabel_view;
  var loading = $('.modal-loading');
  $(function() {
    $('.input-daterange').datepicker({autoclose:true, format: 'yyyy-mm-dd'});
    tabel_view = $('#hasil-pemeriksaan').DataTable({
      dom : "fltrip",
      ajax: {
        "url": '<?php echo site_url('HasilPemeriksaan/show_list')?>',
        "type": 'POST',
        "processing": true,
        "serverside" : false,
        "language": {
            "loadingRecords": "&nbsp;",
            "processing": "data Loading..."
        },  
        "data": function ( d ) {
         return $('#searchForm').serialize();
        },
        "dataSrc": function (json) {
          loading.modal('hide');
          return json.data;
        }
      },
      columns: [
        // { data: "isi" },
        // { data: "edit" },
        { data: "Notran" },
        { data: "Nolab" },
        { data: "Regno" },
        { data: "MedRec" },
        { data: "Tglhasil" },
        { data: "Firstname" },
        { data: "NmKategori" },
        { data: "Catatan" },
        { data: "NMPoli" },
        { data: "NmBangsal" },
        { data: "NMKelas" },
        { data: "CatatanRegistrasi" },
        { data: "PrintCount" },
        { data: "aksi" }
      ],
      columnDefs: [
        { targets: [ 0 ], visible: true },
        { targets: [ 1 ], visible: true },
      ],
      "createdRow": function( row, data, dataIndex ) {
        if ( data['isi'] == 0 ) {
          $(row).addClass( 'highlight-danger '+data[0] );
        }else if(data['isi'] == 1 && data['edit']== 1){
          $(row).addClass("highlight-warning");
        }
      }
    });

    $('#cari').on('click', function(ev) {
        loading.modal('show');
        tabel_view.ajax.reload();
    });

  });
</script>