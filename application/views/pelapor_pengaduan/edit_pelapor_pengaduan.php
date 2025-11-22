<?php if (validation_errors()): ?>
  <div class="toast bg-danger" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false" style="z-index: 999999; position: fixed; right: 1.5rem; bottom: 3.5rem">
    <div class="toast-header">
      <strong class="mr-auto">Gagal!</strong>
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="toast-body">
      <?= validation_errors(); ?>
    </div>
  </div>
<?php endif ?>

<div class="container">
    <div class="row">
        <div class="col-lg-6 p-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="my-auto"><i class="fas fa-fw fa-edit"></i> Ubah Pengaduan</h3>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('pelaporPengaduan/editPelaporPengaduan/' . $pengaduan['id_pengaduan']); ?>" method="post" enctype="multipart/form-data">
                        
                        <div class="form-group">
                            <label for="isi_laporan">Isi Laporan</label>
                            <textarea id="isi_laporan" class="form-control <?= (form_error('isi_laporan')) ? 'is-invalid' : ''; ?>" name="isi_laporan" required><?= set_value('isi_laporan', $pengaduan['isi_laporan']); ?></textarea>
                            <div class="invalid-feedback">
                                <?= form_error('isi_laporan'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="id_dusun">Dusun</label>
                            <select class="custom-select <?= (form_error('id_dusun')) ? 'is-invalid' : ''; ?>" id="id_dusun" name="id_dusun">
                                <option value="">Pilih Dusun</option>
                                <?php 
                                foreach ($dusun as $d) :
                                    // Memastikan pilihan lama (dari DB) atau pilihan terakhir (dari form) tetap terpilih
                                    $selected_id = (form_error('id_dusun')) ? set_value('id_dusun') : $pengaduan['id_dusun'];
                                    $selected = ($d['id_dusun'] == $selected_id) ? 'selected' : '';
                                ?>
                                <option value="<?= $d['id_dusun']; ?>" <?= $selected; ?>>Dusun <?= $d['nama_dusun']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= form_error('id_dusun'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="foto">Foto</label> <br>
                            <a href="<?= base_url('assets/img/img_pengaduan/' . $pengaduan['foto']); ?>" class="enlarge" id="check_enlarge_photo">
                                <img class="img-fluid rounded img-w-150 border border-dark" id="check_photo" src="<?= base_url('assets/img/img_pengaduan/' . $pengaduan['foto']); ?>" alt="Foto Pengaduan">
                            </a>
                            <br>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Upload Foto Baru (Opsional)</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="foto" aria-describedby="foto" name="foto">
                                <label class="custom-file-label" for="foto">Pilih file</label>
                            </div>
                        </div>
                        
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>