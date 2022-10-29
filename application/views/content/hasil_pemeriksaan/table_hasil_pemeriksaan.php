<a href="<?= base_url('billing/edit/'.$head->Notran) ?>" class="btn btn-success btn-xs btn-round">
	<i class="fa  fa-check-circle-o"></i> Tambah pemeriksaan baru
</a>
<button type="submit" class="btn btn-success btn-xs btn-round" id="btnSaveHasil">
	<i class="fa fa-save"></i> Simpan
</button>
<button type="button" class="btn btn-primary btn-xs btn-round" id="btnPrintHasil">
	<i class="fa fa-print"></i> Print Hasil  
</button>
<button type="button" class="btn btn-primary btn-xs btn-round" id="btnPrintHasilFormat">
	<i class="fa fa-print"></i> Print
</button>
<button type="button" class="btn btn-primary btn-xs btn-round" id="btnPrintHasilEng">
	<i class="fa fa-print"></i> English
</button>
<button  style="display: none" type="button" class="btn btn-primary btn-xs btn-round" id="btnPrintCustom">
	<i class="fa fa-print"></i> Print Custom 
</button>
<table class="table table-bordered table-striped mb-0" id="detail-pemeriksaan" style="margin-top: 10px;">
	<thead>
		<tr class="info">
			<th>no</th>
			<th>Pemeriksaan</th>
			<th>Hasil</th>
			<th>Nilai Normal</th>
			<th>Satuan</th>
			<th>Histori</th>
		</tr>
	</thead>
	<tbody>
		<?php $no=1;foreach ($list as $key => $l):?>
			<tr>
				<?php if (strlen($l->KDDetail) <= 5): ?>
					<td><?= $no++; ?></td>
					<td><?=@$l->NMDetail?></td>
				<?php else: ?>
					<td></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;<?=@$l->NMDetail?></td>
				<?php endif ?>

				<?php if ($l->KdInput == '4'): ?>
					<td></td>
				<?php elseif ($l->KdInput == '2'): ?>
					<td><select name="hasil[<?=@$l->keyno?>]" id="hasil[<?=@$l->keyno?>]" class="form-control input-sm">
						<?php foreach ($hasil as $row) {?>
							<option value="<?=$row->NmHasil?>"> <?= $row->NmHasil ?></option>
						<?php } ?>
						</select>
					</td>
				<?php elseif ($l->KdInput == '3'): ?>
					<td><textarea name="hasil[<?=@$l->keyno?>]" id="hasil[<?=@$l->keyno?>]" class="form-control"><?=@$l->Hasil?></textarea></td>
					<!-- <td><input type="text" name="hasil[<?=@$l->keyno?>]" id="hasil[<?=@$l->keyno?>]" value="<?=@$l->Hasil?>"></td> -->
					<!-- <td><input type="text" name="hasil[<?=@$l->keyno?>]" id="hasil[<?=@$l->keyno?>]" value="<?=@$l->Hasil?>"></td> -->
				<?php else: ?>
					<td><input type="text" name="hasil[<?=@$l->keyno?>]" id="hasil[<?=@$l->keyno?>]" value="<?=@$l->Hasil?>"></td>
				<?php endif ?>
				<td><?=@$l->NilaiNormal?></td>
				<td><?=@$l->Satuan?></td>
				<td><a href="#" class="btn btn-info btn-xs" id="<?=@$l->KDDetail?>" onclick="load_histori(this.id)">Histori <?= @$l->NMDetail ?></a></td>
			</tr>
		<?php endforeach?>
	</tbody>
</table>
<div class="modal fade" id="modal-histori-pemeriksaan" tabindex="-1" role="dialog" aria-labelledby="ModalHistoriPemeriksaan">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="ModalHistoriPemeriksaan">Histori Pasien</h4>
			</div>
			<div class="modal-body">
				<div id="target-histori-pemeriksaan"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var value = 'hide';
	var val = '' ;
	function load_histori(pemeriksaan) {
		$.ajax({
			url:"<?=base_url('hasilpemeriksaan/histori_pasien')?>",
			type:'get',
			data:{pemeriksaan: pemeriksaan, medrec: $('#Medrec').val()},
			beforeSend:function(){
				$('#modal-histori-pemeriksaan').modal('show');
				$('#target-histori-pemeriksaan').html('<div class="alert alert-info">Memuat Data <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span></div>');
			},
			success:function(resp){
				$('#target-histori-pemeriksaan').html(resp);
				// $('#btnBackGroup').hide().fadeOut(3000);
			}
		});
	}

	const bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

  $('#btnPrintCustom').click(function(ev) {
    ev.preventDefault();
    let btn = $(this);
    let oldText = btn.html();

    	// $('#modal-print-custom').modal('show');
    btn
      .attr('content-orig', btn.html())
      .html('<i class="fa fa-spin fa-spinner"></i> ' + 'tunggu...')
      .prop('disabled', true);

    $.get("<?= base_url('hasilpemeriksaan/get_list_custom_print/') ?>" + $('#NoTransaksi').val())
    .done(function(res) {
    	if(res) {
    		$('#modal-print-custom tbody').html('');
    		if(res.bil && res.bil.length) {

		    	res.bil.forEach(function(item) {
		    		let d = new Date(item.Tanggal);
		    		$('#modal-print-custom tbody').append(`
		    				<tr>
		    					<td><input type="checkbox" name="kode_detail[]" kode-detail="${item.KDDetail}#${item.Tanggal}" value="${item.KDDetail}#${item.Tanggal}"></td>
		    					<td>
		    						${ String(d.getDate()).padStart(2, '0') } ${bulanList[d.getMonth()]} ${d.getFullYear()} /
		    						${ String(d.getHours()).padStart(2, '0') }:${ String(d.getMinutes()).padStart(2, '0') }:${ String(d.getSeconds()).padStart(2, '0') }</td>
		    					<td>${item.NMDetail}</td>
		    				</tr>
		    			`);
		    	});
    		}
    		$('#detail-pems').html('');
    		if(res.pem && res.pem.length) {
    			res.pem.forEach(function(item) {

    				$('#detail-pems').append(`<input kode-detail="${item.KDDetail}#${item.Tanggal}" type="checkbox" name="kode_detail[]" value="${item.KodeDetail}#${item.Tanggal}">`);
    			});
    		}
    	}
    	else {
    		$('#modal-print-custom tbody').html('<tr><td colspan="100%" style="text-align: center; font-style: italic;">(Tidak ada data)</td></tr>');
    	}

    	$('#modal-print-custom').modal('show');
    })
    .always(function() {
      btn.html(btn.attr('content-orig')).prop('disabled', false);
    });
  });

  $('input[type=radio][name=infocvd19]').change(function(){
	value = $(this).val();

  });

  $('input[type=radio][name=pengesahan]').change(function(){
	val = $(this).val();

  });

  $('#btnPrintHasil').on('click', function(ev) {
    ev.preventDefault();
    if ($('#NoTransaksi').val() == '') {
      alert('Nomor Transaksi Kosong');
    } else {
		var text= '<?= date('d F Y') ?>';
		var tgll = prompt("Masukkan Tanggal", text);
	    var infoCovid19 = value;
	    var pengesahan = val;
        var xhr = $.ajax({
        url:"<?=base_url('hasilpemeriksaan/print_hasil_pemeriksaan')?>",
        type:'get',
        data:{notransaksi: $('#NoTransaksi').val(), tanggal_ttd:tgll, infoCovid19:infoCovid19, pengesahan:pengesahan},
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
  });

  $('#btnPrintHasilEng').on('click', function(ev) {
    ev.preventDefault();
    if ($('#NoTransaksi').val() == '') {
      alert('Nomor Transaksi Kosong');
    } else {
		var text= '<?= date('F dS Y') ?>';
		var tgll = prompt("Masukkan Tanggal", text);
	  var infoCovid19 = value;
	  var pengesahan = val;
      var xhr = $.ajax({
        url:"<?=base_url('hasilpemeriksaan/print_hasil_pemeriksaan_eng')?>",
        type:'get',
        data:{notransaksi: $('#NoTransaksi').val(),tanggal_ttd:tgll, infoCovid19:infoCovid19, pengesahan:pengesahan},
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
  });

  $('#btnPrintHasilFormat').on('click', function(ev) {
    ev.preventDefault();
    if ($('#NoTransaksi').val() == '') {
      alert('Nomor Transaksi Kosong');
    } else {
		var text= '<?= date('d F Y') ?>';
		var tgll = prompt("Masukkan Tanggal", text);
	  var infoCovid19 = value;
	  var pengesahan = val;
      var xhr = $.ajax({
        url:"<?=base_url('hasilpemeriksaan/print_hasil_pemeriksaan_micro')?>",
        type:'get',
        data:{notransaksi: $('#NoTransaksi').val(), tanggal_ttd:tgll,  infoCovid19:infoCovid19, pengesahan:pengesahan},
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
  });
</script>
