<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">Aplikasi</h1>
    <?= form_error('aplikasi', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?= $this->session->flashdata('message'); ?>
    <?php if ($role_id == 2) : ?>
        <div class="mb-3">
            <button class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#newAplikasi">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Aplikasi</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Data Aplikasi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Aplikasi</th>
                            <th>Status</th>
                            <?php if ($role_id == 1) : ?>
                                <th>Jumlah Pengguna</th>
                            <?php elseif ($role_id == 2) : ?>
                                <th style="max-width: 300px;">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($allApp as $app) : ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= ucfirst($app['nama_aplikasi']) ?></td>
                                <td>
                                    <?php if ($app['status'] == 1) : ?>
                                        <div class="badge badge-pill badge-success" style="min-width: 100px; font-size:15px">Aktif</div>
                                    <?php elseif ($app['status'] == 0) : ?>
                                        <div class="badge badge-pill badge-danger" style="min-width: 100px; font-size:15px">Non-Aktif</div>
                                    <?php endif; ?>
                                </td>
                                <?php if ($role_id == 1) : ?>
                                    <td><?= $app['jumlah_pengguna']; ?></td>
                                <?php elseif ($role_id == 2) : ?>
                                    <td>
                                        <?php if ($app['status'] == 1) : ?>
                                            <a href="<?= base_url('Aplikasi/nonAktifkan/' . $app['id_aplikasi']) ?>" class="btn btn-outline-danger btn-icon-split">
                                                <span class="text" data-toggle="tooltip" title="Non-Aktifkan Aplikasi">
                                                    <i class="fas fa-fw fa-times"></i>
                                                </span>
                                            </a>
                                        <?php elseif ($app['status'] == 0) : ?>
                                            <a href="<?= base_url('Aplikasi/aktifkan/' . $app['id_aplikasi']) ?>" class="btn btn-outline-success btn-icon-split">
                                                <span class="text" data-toggle="tooltip" title="Aktifkan Aplikasi">
                                                    <i class="fas fa-fw fa-check"></i>
                                                </span>
                                            </a>
                                        <?php endif; ?>
                                        <button class="btn btn-warning btn-icon-split" data-toggle="modal" data-target="#editAplikasi<?= $app['id_aplikasi'] ?>">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-fw fa-edit"></i>
                                            </span>
                                            <span class="text">Edit</span>
                                        </button>
                                        <a href="<?= base_url('Aplikasi/deleteAplikasi/' . $app['id_aplikasi']) ?>" class="btn btn-danger btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-fw fa-trash"></i>
                                            </span>
                                            <span class="text">Hapus</span>
                                        </a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php $no++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<!-- Modal tambah Aplikasi-->
<div class="modal fade" id="newAplikasi" data-backdrop="static" tabindex="-1" aria-labelledby="newAplikasiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newAplikasiLabel">Tambah Aplikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Aplikasi/addAplikasi') ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="aplikasi" class="form-control" id="aplikasi" placeholder="Nama Aplikasi">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- endmodal -->

<!-- Modal edit Aplikasi-->
<?php foreach ($allApp as $app) : ?>
    <div class="modal fade" id="editAplikasi<?= $app['id_aplikasi'] ?>" data-backdrop="static" tabindex="-1" aria-labelledby="editAplikasiLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAplikasiLabel">Edit Aplikasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('Aplikasi/editAplikasi/' . $app['id_aplikasi']) ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" name="aplikasi" class="form-control" id="newaplikasi" placeholder="Nama Aplikasi" value="<?= ucfirst($app['nama_aplikasi']) ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<!-- endmodal -->