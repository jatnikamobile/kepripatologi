<a href="<?= base_url('billing/edit/'.$head[0]->NoTran) ?>" class="btn btn-success btn-xs btn-round">
	<i class="fa  fa-check-circle-o"></i> Tambah pemeriksaan baru
</a>
<button type="submit" class="btn btn-success btn-xs btn-round" id="btnSaveHasil">
	<i class="fa fa-save"></i> Simpan
</button>
<button type="button" class="btn btn-primary btn-xs btn-round" id="btnPrintHasil">
	<i class="fa fa-print"></i> Print Hasil  
</button>
<table class="table table-bordered table-striped mb-0" id="detail-pemeriksaan" style="margin-top: 10px;">
	<thead>
		<tr class="info">
			<th width="5%">no</th>
			<th width="30%">Pemeriksaan</th>
			<th width="65%">Hasil</th>
		</tr>
	</thead>
	<tbody>
		<?php $no=1;foreach ($list as $key => $l):?>
			<tr>
				<?php if (strlen($l->KDDetail) <= 5): ?>
					<td><?= $no++; ?></td>
					<td><?=@$l->NMDetail?></td>
					<input type="hidden" name="hasil[<?=$l->KDDetail?>][kddetail]" id="hasil[<?=$l->KDDetail?>][kddetail]" value="<?=$l->KDDetail?>">
					<td></td>
				<?php else: ?>
					<td></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;<?=@$l->NMDetail?></td>
					<td></td>
				<?php endif ?>
			</tr>
			<?php if ($l->KdGroup != '6'): ?>
				<tr>
					<td></td>
					<td>&emsp;<b>Keterangan Klinik</b></td>
					<td><textarea name="hasil[<?=$l->KDDetail?>][Hasil_KetKlinik]" id="hasil[<?=$l->KDDetail?>][Hasil_KetKlinik]" class="form-control"><?=@$l->Hasil_KetKlinik?></textarea></td>
				</tr>
				<tr>
					<td></td>
					<td>&emsp;<b>Pemeriksaan Makroskopis</b></td>
					<td><textarea name="hasil[<?=$l->KDDetail?>][Hasil_PemMakro]" id="hasil[<?=$l->KDDetail?>][Hasil_PemMakro]" class="form-control"><?=@$l->Hasil_PemMakro?></textarea></td>
				</tr>
				<tr>
					<td></td>
					<td>&emsp;<b>Pemeriksaan Mikroskopis</b></td>
					<td><textarea name="hasil[<?=$l->KDDetail?>][Hasil_PemMikro]" id="hasil[<?=$l->KDDetail?>][Hasil_PemMikro]" class="form-control"><?=@$l->Hasil_PemMikro?></textarea></td>
				</tr>
				<tr>
					<td></td>
					<td>&emsp;<b>Kesimpulan</b></td>
					<td><textarea name="hasil[<?=$l->KDDetail?>][Hasil_Kesimpulan]" id="hasil[<?=$l->KDDetail?>][Hasil_Kesimpulan]" class="form-control"><?=@$l->Hasil_Kesimpulan?></textarea></td>
				</tr>
				<tr>
					<td></td>
					<td>&emsp;<b>Anjuran</b></td>
					<td><textarea name="hasil[<?=$l->KDDetail?>][Hasil_Anjuran]" id="hasil[<?=$l->KDDetail?>][Hasil_Anjuran]" class="form-control"><?=@$l->Hasil_Anjuran?></textarea></td>
				</tr>
			<?php else: ?>
					<tr>
					<td></td>
					<td>&emsp;<b>Data Awal</b></td>
					<td><textarea name="hasil[<?=$l->KDDetail?>][Hasil_Datawal]" id="hasil[<?=$l->KDDetail?>][Hasil_Datawal]" class="form-control"><?=@$l->Hasil_Datawal?></textarea></td>
				</tr>
				<tr>
					<td></td>
					<td>&emsp;<b>Data Hasil Immunohistokimia</b></td>
					<td><textarea name="hasil[<?=$l->KDDetail?>][Hasil_Imuno]" id="hasil[<?=$l->KDDetail?>][Hasil_Imuno]" class="form-control"><?=@$l->Hasil_Imuno?></textarea></td>
				</tr>

				<tr>
					<td></td>
					<td>&emsp;<b>Hasil Pemeriksaan</b></td>
					<td><textarea name="hasil[<?=$l->KDDetail?>][Hasil_pemImuno]" id="hasil[<?=$l->KDDetail?>][Hasil_pemImuno]" class="form-control"><?=@$l->Hasil_pemImuno?></textarea></td>
				</tr>
			<?php endif ?>
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
