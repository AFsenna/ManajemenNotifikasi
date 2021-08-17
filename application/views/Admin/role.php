<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">Role</h1>
    <div class="mb-3">
        <button class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#newRole">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Role</span>
        </button>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Data Role</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Admin</td>
                            <td>
                                <button class="btn btn-warning btn-icon-split" data-toggle="modal" data-target="#editRole">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-fw fa-edit"></i>
                                    </span>
                                    <span class="text">Edit</span>
                                </button>
                                <a href="#" class="btn btn-danger btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-fw fa-trash"></i>
                                    </span>
                                    <span class="text">Hapus</span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>User</td>
                            <td>
                                <button href="#" class="btn btn-warning btn-icon-split" data-toggle="modal" data-target="#editRole">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-fw fa-edit"></i>
                                    </span>
                                    <span class="text">Edit</span>
                                </button>
                                <a href="#" class="btn btn-danger btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-fw fa-trash"></i>
                                    </span>
                                    <span class="text">Hapus</span>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<!-- Modal tambah role-->
<div class="modal fade" id="newRole" data-backdrop="static" tabindex="-1" aria-labelledby="newRoleLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleLabel">Tambah Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Admin/role') ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="role" class="form-control" id="role" placeholder="Nama Role">
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

<!-- Modal edit role-->
<div class="modal fade" id="editRole" data-backdrop="static" tabindex="-1" aria-labelledby="editRoleLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoleLabel">Edit Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Admin/role') ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="role" class="form-control" id="newrole" placeholder="Nama Role" value="Admin">
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