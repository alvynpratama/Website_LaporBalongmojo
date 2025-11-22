<div class="container">
    <div class="row">
        <div class="col-lg-6 p-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="my-auto"><i class="fas fa-fw fa-plus"></i> Tambah Pengaduan</h3>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('pelaporPengaduan/addPelaporPengaduan'); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="isi_laporan">Isi Laporan</label>
                            <textarea id="isi_laporan" class="form-control <?= (form_error('isi_laporan')) ? 'is-invalid' : ''; ?>" name="isi_laporan" required><?= set_value('isi_laporan'); ?></textarea>
                            <div class="invalid-feedback"><?= form_error('isi_laporan'); ?></div>
                        </div>

                        <div class="form-group">
                            <label for="id_dusun">Dusun</label>
                            <select class="custom-select <?= (form_error('id_dusun')) ? 'is-invalid' : ''; ?>" id="id_dusun" name="id_dusun">
                                <option value="">Pilih Dusun</option>
                                <?php
                                foreach ($dusun as $d) :
                                    $selected = (set_value('id_dusun') == $d['id_dusun']) ? 'selected' : '';
                                ?>
                                    <option value="<?= $d['id_dusun']; ?>" <?= $selected; ?>>
                                        <?= htmlspecialchars($d['nama_dusun']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= form_error('id_dusun'); ?></div>
                        </div>

                        <div class="form-group">
                            <label for="foto">Foto</label> <br>
                            <a href="<?= base_url('assets/img/img_pengaduan/default.png'); ?>" class="enlarge" id="check_enlarge_photo">
                                <img class="img-fluid rounded img-w-150 border border-dark" id="check_photo" src="<?= base_url('assets/img/img_pengaduan/default.png'); ?>" alt="Foto Pengaduan">
                            </a><br>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend"><span class="input-group-text">Upload Foto</span></div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="foto" name="foto">
                                <label class="custom-file-label" for="foto">Pilih file</label>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (isset($validation_errors) && $validation_errors): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Membersihkan pesan error dari karakter yang merusak JavaScript string
        let errorMessage = '<?= str_replace(array("\r", "\n", "'", '"'), array('', '', "\\'", '\"'), $validation_errors); ?>';
        
        Swal.fire({
            title: 'Gagal!',
            // Hapus tag <p> dan tampilkan pesan
            html: errorMessage.replace(/<\/?p>/g, ''), 
            icon: 'error'
        });
    });
</script>
<?php endif ?>