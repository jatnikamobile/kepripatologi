<?php if(empty($data)): ?>
  <tr>
    <td colspan="100%" style="text-align: center; font-style: italic;">
      (Tidak ada data)
    </td>
  </tr>
<?php else: ?>
  <?php foreach ($data as $item): ?>
    <tr data-notran="<?= $item->NoTran ?>">
      <td><?= $item->NoTran ?></td>
      <td><?= $item->NoLab ?></td>
      <td><?= $item->Regno ?></td>
      <td><?= $item->Medrec ?></td>
      <td><?= date('d/m/Y', strtotime($item->Regdate)) ?></td>
      <td><?= $item->Firstname ?></td>
      <td><?= $item->NmKategori ?></td>
      <td><?= $item->Instalasi ?></td>
      <td>
        <?php if(!empty($item->NmPoli) && !empty($item->NmBangsal)): ?>
          <?= $item->NmPoli ?> / <?= $item->NmBangsal ?>
        <?php elseif(!empty($item->NmPoli)): ?>
          <?= $item->NmPoli ?>
        <?php elseif(!empty($item->NmBangsal)): ?>
          <?= $item->NmBangsal ?>
        <?php endif; ?>
      </td>
      <td><?= $item->NmKelas ?></td>
      <td><?= $item->Address ?></td>
      <td><?= $item->Catatan ?></td>
      <td><?php if($item->Tanda != 1){echo 'Sudah Billing';} ?></td>
      <td>
        <div class="pull-right">
          <button class="btn btn-round btn-minier btn-danger btn-delete" onclick="hapus('<?=$item->NoTran?>')">
            <i class="fa fa-trash"></i> Hapus
          </button>
          <a class="btn btn-round btn-minier btn-primary" href="<?= site_url('billing/edit/'.$item->NoTran) ?>">
            <i class="fa fa-folder-open"></i> Billing
          </a>
        </div>
      </td>
    </tr>
  <?php endforeach?>
<?php endif; ?>