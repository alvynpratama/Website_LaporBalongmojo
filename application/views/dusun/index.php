<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <?= $this->session->flashdata('message'); ?>
            
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newDusunModal">Tambah Dusun Baru</a>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Dusun</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($dusun as $d) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $d['nama_dusun']; ?></td>
                            <td>
                                <a href="<?= base_url('dusun/hapus/') . $d['id_dusun']; ?>" class="badge badge-danger" onclick="return confirm('Yakin ingin menghapus dusun ini?');">hapus</a>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<div class="modal fade" id="newDusunModal" tabindex="-1" role="dialog" aria-labelledby="newDusunModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newDusunModalLabel">Tambah Dusun Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('dusun/tambah'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama_dusun" name="nama_dusun" placeholder="Nama Dusun">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>