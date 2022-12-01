<?php if(empty($list_detail)): ?>
  <tr>
    <td style="font-style: italic; text-align: center;" colspan="100%">
      (Tidak ada data)
    </td>
  </tr>
<?php else: ?>
  <?php $no = $last_number ?? 0; foreach($list_detail as $item): ?>
    <tr data-kode_tarif="<?= $item->KdTarif ?>" data-nomor="<?= ++$no ?>">
      <td><?= $no ?>.</td>
      <td><?= date('d/m/Y - H:i:s', strtotime($item->Tanggal)) ?></td>
      <td><?= $item->NmTarif ?></td>
      <td>Rp. <?= number_format($item->Sarana, 0, ',', '.') ?></td>
      <td>Rp. <?= number_format($item->Pelayanan, 0, ',', '.') ?></td>
      <td><input type="number" name="qty" class="form-control inp-qty" value="<?= $item->Qty ? $item->Qty : 1?>"/></td>
      <td>Rp. <?= number_format(($item->JumlahBiaya * ($item->Qty ? $item->Qty : 1)), 0, ',', '.') ?></td>
      <td>
        <button class="btn btn-minier btn-danger btn-round btn-delete">
          <i class="fa fa-trash"></i>
        </button>
      </td>
    </tr>
  <?php endforeach; ?>
<?php endif; ?>

<script>
  var base_url = '<?= base_url()?>';
  $(document).ready(function(){
    $('.inp-qty').on('keyup change', function(){
      var el = $(this);
      var regno = $('input[name="input_regno"]').val();
      var notran = $('input[name="no_tran"]').val();
      var kdtarif = el.parent().parent().attr('data-kode_tarif');
      var qty = el.val();
      var data = {
        'regno': regno,
        'notran': notran,
        'kdtarif': kdtarif,
        'qty': qty
      }

      $.getJSON(base_url+'billing/update_qty', data, function(result){
        el.parent().next().empty().append(result.item_detail);
        $('#jumlah_biaya_hide').val(result.num_curr_total);
        $('input[name="jumlah_biaya"]').val(result.curr_total);
        $('#total_biaya').val(result.curr_total_biaya);
      });
    })
  })
</script>