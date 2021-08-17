<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">Change Password</h1>
    <?= form_error('password', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?= form_error('newpassword1', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?= form_error('newpassword2', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?= $this->session->flashdata('message'); ?>

    <!-- Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="<?= base_url('User/updatePassword') ?>" method="POST">
                <div class="form-group">
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password saat ini">
                </div>
                <div class="form-group">
                    <input type="password" name="newpassword1" class="form-control" id="newpassword" placeholder="Password baru">
                </div>
                <div class="form-group">
                    <input type="password" name="newpassword2" class="form-control" id="newpassword" placeholder="Konfirmasi password baru">
                </div>
                <button type="submit" class="btn btn-primary">Change</button>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->