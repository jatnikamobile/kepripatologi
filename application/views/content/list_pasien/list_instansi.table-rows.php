<?php if(empty($data)): ?>
  <tr>
    <td colspan="100%" style="text-align: center; font-style: italic;">
      (Tidak ada data)
    </td>
  </tr>
<?php else: ?>
  <?php foreach ($data as $item): ?>
    <tr data-regno="<?= $item->No_register ?>">
      <td><?= $item->No_register ?></td>
      <td><?= date('d/m/Y', strtotime($item->Regdate)) ?></td>
      <td><?= $item->Nama_perusahaan ?> - <?= $item->NmUnit ?></td>
      <td><?= $item->jumlah_peserta ?></td>
      <td><?= $item->NMDetail ?></td>
      <td>
        <?php if($item->tgl_upload == null) {?>
            <span style="color: red;">Belum Upload</span>
        <?php } else{ echo "Sudah Upload Bukti Tanggal ".date("d-m-Y", strtotime($item->tgl_upload)); } ?>
      </td>
      <td>
        <?php if ($this->session->userdata('grup') == 'INSTANSI') { ?>
            <a href="<?= base_url('registrasi/detail_instansi?regno='.$item->No_register) ?>" class="btn btn-warning btn-minier btn-round">
                <i class="fa fa-eye"></i> Upload Bukti
              </a>
        <?php }else{?>
          <div class="center">
				<a href="<?= base_url('registrasi/detail_instansi?regno='.$item->No_register) ?>" class="btn btn-warning btn-minier btn-round">
                <i class="fa fa-eye"></i> Upload Bukti
              </a>
              <a href="<?= base_url('registrasi/bill_instansi?regno='.$item->No_register) ?>" class="btn btn-warning btn-minier btn-round">
                <i class="fa fa-pencil"></i> Edit
              </a>
          </div>
        <?php } ?>
      </td>
    </tr>
  <?php endforeach?>
<?php endif; ?>