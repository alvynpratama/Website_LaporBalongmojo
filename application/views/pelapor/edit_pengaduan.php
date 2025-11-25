<div class="container">
    <div class="row justify-content-center py-3">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="m-0"><i class="fas fa-fw fa-edit"></i> Ubah Laporan</h5>
                </div>
                <div class="card-body">
                    <?= form_open_multipart('pelapor/editPengaduan/' . $pengaduan['id_pengaduan']); ?>
                    
                    <div class="form-group">
                        <label for="isi_laporan">Isi Laporan</label>
                        <textarea class="form-control" id="isi_laporan" name="isi_laporan" rows="4"><?= $pengaduan['isi_laporan']; ?></textarea>
                        <?= form_error('isi_laporan', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>

                    <div class="form-group">
                        <label for="foto">Foto Bukti</label>
                        <div class="row">
                            <div class="col-sm-3">
                                <img src="<?= base_url('assets/img/img_pengaduan/') . $pengaduan['foto']; ?>" class="img-thumbnail">
                            </div>
                            <div class="col-sm-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="foto" name="foto">
                                    <label class="custom-file-label" for="foto">Pilih file baru (jika ingin ganti)</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <a href="<?= base_url('pelapor'); ?>" class="btn btn-secondary">Batal</a>
                        <a href="<?= base_url('pelapor/hapusPengaduan/' . $pengaduan['id_pengaduan']); ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?');">Hapus Laporan</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>

                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
