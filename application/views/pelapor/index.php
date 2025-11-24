<div class="container">
    <div class="row justify-content-center py-3">
        <div class="col-lg">
            <h3><i class="fas fa-fw fa-tachometer-alt"></i> Dasbor</h3>
        </div>
    </div>

    <div class="row my-3">
        
        <div class="col-lg-3">
            <div class="card shadow">
                <div class="card-body">
                    <h5><i class="fas fa-fw fa-times"></i> Belum ditanggapi</h5>
                    <h6 class="text-muted mt-3">Jumlah data: 
                        <span class="bg-info py-1 px-2 rounded">
                            <?= count($pengaduan_belum_ditanggapi_pelapor); ?>
                        </span>
                    </h6>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card shadow">
                <div class="card-body">
                    <h5><i class="fas fa-fw fa-sync"></i> Proses</h5>
                    <h6 class="text-muted mt-3">Jumlah data: 
                        <span class="bg-info py-1 px-2 rounded">
                            <?= count($pengaduan_proses_pelapor); ?>
                        </span>
                    </h6>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card shadow">
                <div class="card-body">
                    <h5><i class="fas fa-fw fa-check"></i> Valid</h5>
                    <h6 class="text-muted mt-3">Jumlah data: 
                        <span class="bg-info py-1 px-2 rounded">
                            <?= count($pengaduan_valid_pelapor); ?>
                        </span>
                    </h6>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card shadow">
                <div class="card-body">
                    <h5><i class="fas fa-fw fa-hammer"></i> Pengerjaan</h5>
                    <h6 class="text-muted mt-3">Jumlah data: 
                        <span class="bg-info py-1 px-2 rounded">
                            <?= count($pengaduan_pengerjaan_pelapor); ?>
                        </span>
                    </h6>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card shadow">
                <div class="card-body">
                    <h5><i class="fas fa-fw fa-check-double"></i> Selesai</h5>
                    <h6 class="text-muted mt-3">Jumlah data: 
                        <span class="bg-info py-1 px-2 rounded">
                            <?= count($pengaduan_selesai_pelapor); ?>
                        </span>
                    </h6>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card shadow">
                <div class="card-body">
                    <h5><i class="fas fa-fw fa-times"></i> Tidak Valid</h5>
                    <h6 class="text-muted mt-3">Jumlah data: 
                        <span class="bg-info py-1 px-2 rounded">
                            <?= count($pengaduan_tolak_pelapor); ?>
                        </span>
                    </h6>
                </div>
            </div>
        </div>

    </div>
    <hr>

    <div class="row my-3">
        <div class="col-lg">
            <h4><i class="fas fa-fw fa-times"></i> Laporan yang belum ditanggapi</h4>
            <div class="table-responsive">
                <table class="table table-bordered" id="table_id">
                    <thead class="thead-dark">
                        <tr>
                            <th class="align-middle">No.</th>
                            <th class="align-middle">Tanggal Pengaduan</th>
                            <th class="align-middle">Isi Laporan</th>
                            <th class="align-middle">Lokasi</th>
                            <th class="align-middle">Foto</th>
                            <th class="align-middle">Pelapor</th>
                            <th class="align-middle">Status</th>
                            <th class="align-middle">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($pengaduan_belum_ditanggapi_pelapor as $dp): ?>
                            <tr>
                                <td class="align-middle"><?= $i++; ?></td>
                                <td class="align-middle"><?= $dp['tgl_pengaduan']; ?></td>
                                <td class="align-middle"><?= $dp['isi_laporan']; ?></td>
                                <td class="align-middle"><?= $dp['nama_dusun']; ?></td>
                                <td class="align-middle text-center">
                                    <a href="<?= base_url('assets/img/img_pengaduan/') . $dp['foto']; ?>" class="enlarge">
                                        <img src="<?= base_url('assets/img/img_pengaduan/') . $dp['foto']; ?>" class="img-fluid img-w-75-hm-100" alt="<?= $dp['foto']; ?>">
                                    </a>
                                </td>
                                <td class="align-middle"><?= $dp['username']; ?></td>
                                <td class="align-middle"><button type="button" class="btn text-center btn-sm btn-secondary"><i class="fas fa-fw fa-times"></i> Belum ditanggapi</button></td>
                                
                                <td class="align-middle text-center">
                                    <a href="<?= base_url('tanggapan/index/' . $dp['id_pengaduan']); ?>" class="btn btn-sm btn-info m-1"><i class="fas fa-fw fa-reply"></i></a>
                                    
                                    <?php if ($dp['status_pengaduan'] == 'Belum ditanggapi') : ?>
                                        <a href="<?= base_url('pelapor/editPengaduan/' . $dp['id_pengaduan']); ?>" class="btn btn-sm btn-warning m-1" title="Ubah"><i class="fas fa-fw fa-edit text-white"></i></a>
                                        <a href="<?= base_url('pelapor/hapusPengaduan/' . $dp['id_pengaduan']); ?>" class="btn btn-sm btn-danger m-1" title="Hapus" onclick="return confirm('Yakin ingin menghapus?');"><i class="fas fa-fw fa-trash"></i></a>
                                    <?php endif; ?>
                                </td>

                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
