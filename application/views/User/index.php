<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">Profile</h1>

    <?= form_error('namalengkap', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?= form_error('username', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?= form_error('email', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?= form_error('phone', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?= $this->session->flashdata('message'); ?>
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profile Saya</h6>
                    <div class="float-right">
                        <button class="btn btn-info" data-toggle="modal" data-target="#editProfile">
                            <span class="icon text-white" data-toggle="tooltip" title="Edit Profile">
                                <i class="fas fa-fw fa-user-edit"></i>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <center>
                        <img class="img-profile rounded-circle mb-2" src="<?= base_url('assets/') ?>img/undraw_mornings_re_cofi.png" style="max-width: 300px; max-height:300px">
                    </center>
                    <div class="deskripsi1 row">
                        <h6 style="min-width: 150px;">Nama Lengkap</h6>
                        <h6 class="isi">
                            : <?= $nama ?>
                        </h6>
                    </div>
                    <div class="deskripsi2 row">
                        <h6 style="min-width: 150px;">Username</h6>
                        <h6 class="isi">
                            : <?= $username ?>
                        </h6>
                    </div>
                    <div class="deskripsi3 row">
                        <h6 style="min-width: 150px;">Email</h6>
                        <h6 class="isi">
                            : <?= $email ?>
                        </h6>
                    </div>
                    <div class="deskripsi4 row">
                        <h6 style="min-width: 150px;">No Telpon</h6>
                        <h6 class="isi">
                            : <?= $notelp ?>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aplikasi Saya</h6>
                </div>
                <div class="card-body">
                    <center>
                        <img class="img-profile rounded-circle mb-2" src="<?= base_url('assets/') ?>img/undraw_Coding_re_iv62.png" style="max-width: 300px; max-height:300px">
                    </center>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Aplikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($aplikasi as $app) : ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $app['nama_aplikasi'] ?></td>
                                </tr>
                            <?php $no++;
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- /.container-fluid -->

<!-- Modal edit profile-->
<div class="modal fade" id="editProfile" data-backdrop="static" aria-labelledby="editProfileLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileLabel">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('User/editProfile') ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="namalengkap" name="namalengkap" placeholder="Nama Lengkap" value="<?= $nama ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username" value="<?= $username ?>">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Email" value="<?= $email ?>">
                    </div>
                    <div class="form-group">
                        <input type="tel" class="form-control form-control-user" id="phone" name="phone" placeholder="Nomor Telepon" value="<?= $notelp ?>">
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
<!-- endmodal -->