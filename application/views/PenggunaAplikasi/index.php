<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">Pengguna Aplikasi</h1>

    <?= form_error('nama', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?= form_error('email', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?= form_error('phone', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?= form_error('filename', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?= form_error('noIsi', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?= form_error('noNama', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?= form_error('noHP', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?= form_error('noEmail', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?= $this->session->flashdata('message'); ?>

    <div class="mb-3">
        <button class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#newPengguna">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Pengguna</span>
        </button>
        <button class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#imporExcel">
            <span class="icon text-white-50">
                <i class="fas fa-file-excel"></i>
            </span>
            <span class="text">Impor Excel</span>
        </button>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary mb-2">Tabel Data Pengguna</h6>
            <h6 class="m-0 font-weight-bold text-danger float-right">Milik Aplikasi : <?= $namaAplikasi ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Dibuat</th>
                            <th>Nama</th>
                            <th>No HP</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($pengguna as $row) : ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= date('d-M-Y', strtotime($row['tanggal_dibuat'])); ?></td>
                                <td><?= ucfirst($row['nama_pengguna']) ?></td>
                                <td><?= $row['notelp_pengguna'] ?></td>
                                <td><?= $row['email_pengguna'] ?></td>
                                <td>
                                    <button class="btn btn-sm btn-warning mb-2" data-toggle="modal" data-target="#editPengguna<?= $row['id_pengguna'] ?>">
                                        <span class="icon text-white" data-toggle="tooltip" title="Edit Pengguna">
                                            <i class="fas fa-fw fa-edit"></i>
                                        </span>
                                    </button>
                                    <a href="<?= base_url('PenggunaAplikasi/deletePengguna/' . $namaAplikasi . '/' . $id_aplikasi . '/' . $row['id_pengguna']) ?>" class="btn btn-sm btn-danger mb-2" data-toggle="tooltip" title="Hapus Pengguna">
                                        <span class="icon text-white">
                                            <i class="fas fa-fw fa-trash"></i>
                                        </span>
                                    </a>
                                </td>
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

<!-- Modal tambah pengguna-->
<div class="modal fade" id="newPengguna" data-backdrop="static" tabindex="-1" aria-labelledby="newPenggunaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newPenggunaLabel">Tambah Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('PenggunaAplikasi/storePengguna/' . $namaAplikasi . '/' . $id_aplikasi) ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="nama" name="nama" placeholder="Nama" value="">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Email" value="">
                    </div>
                    <div class="form-group">
                        <input type="tel" class="form-control form-control-user" id="phone" name="phone" placeholder="Nomor Telepon" value="">
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

<!-- Modal edit pengguna-->
<?php foreach ($pengguna as $row) : ?>
    <div class="modal fade" id="editPengguna<?= $row['id_pengguna'] ?>" data-backdrop="static" aria-labelledby="editPenggunaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPenggunaLabel">Edit Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('PenggunaAplikasi/editPengguna/' . $namaAplikasi . '/' . $id_aplikasi . '/' . $row['id_pengguna']) ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="nama" placeholder="Nama" value="<?= ucfirst($row['nama_pengguna']) ?>">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control form-control-user" name="email" placeholder="Email" value="<?= $row['email_pengguna'] ?>">
                        </div>
                        <div class="form-group">
                            <input type="tel" class="form-control form-control-user" name="phone" placeholder="Nomor Telepon" value="<?= $row['notelp_pengguna'] ?>">
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

<!-- Modal impor excel-->
<div class="modal fade" id="imporExcel" data-backdrop="static" tabindex="-1" aria-labelledby="imporExcelLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imporExcelLabel">Impor Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('PenggunaAplikasi/storeExcel/' . $namaAplikasi . '/' . $id_aplikasi); ?>
            <!-- <form action="<?= base_url('PenggunaAplikasi/storeExcel/' . $namaAplikasi . '/' . $id_aplikasi) ?>" method="POST"> -->
            <div class="modal-body">
                <div class="form-group">
                    <label for="berkas">File (.xlsx atau .csv) </label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="berkas" name="berkas">
                        <label class="custom-file-label" for="berkas">Choose file</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="noIsi">Isi data dimulai dari baris ke </label>
                    <input type="number" class="form-control form-control-user" id="noIsi" name="noIsi" value="2">
                </div>
                <div class="form-group">
                    <label for="noNama">Kolom nama ada di </label>
                    <input type="number" class="form-control form-control-user" id="noNama" name="noNama" value="1">
                </div>
                <div class="form-group">
                    <label for="noHP">Kolom notelp ada di </label>
                    <input type="number" class="form-control form-control-user" id="noHP" name="noHP" value="2">
                </div>
                <div class="form-group">
                    <label for="noEmail">Kolom email ada di </label>
                    <input type="number" class="form-control form-control-user" id="noEmail" name="noEmail" value="3">
                </div>
                <h6 class="text-danger" style="font-weight: bold;">Silahkan download contoh file <a href="<?= base_url('assets\excel\contoh.xlsx') ?>" download>disini</a></h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Impor</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- endmodal -->