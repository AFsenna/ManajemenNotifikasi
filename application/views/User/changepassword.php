<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">Change Password</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="<?= base_url('User/changepassword') ?>" method="POST">
                <div class="form-group">
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password saat ini">
                </div>
                <div class="form-group">
                    <input type="password" name="newpassword" class="form-control" id="newpassword" placeholder="Password baru">
                </div>
                <button type="submit" class="btn btn-primary">Change</button>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->