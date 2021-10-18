<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">Role</h1>
    <?= form_error('role', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?= $this->session->flashdata('message'); ?>
    <div class="mb-3">
        <button class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#newRole">
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
                        <?php $no = 1;
                        foreach ($roles as $row) :
                        ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= ucfirst($row['nama']) ?></td>
                                <td>
                                    <button class="btn btn-sm btn-warning mb-2" data-toggle="modal" data-target="#editRole<?= $row['id_role'] ?>">
                                        <span class="icon text-white" data-toggle="tooltip" title="Edit Role">
                                            <i class="fas fa-fw fa-edit"></i>
                                        </span>
                                    </button>
                                    <a href="<?= base_url('Role/deleteRole/' . $row['id_role']) ?>" class="btn btn-sm btn-danger mb-2" data-toggle="tooltip" title="Hapus Role">
                                        <span class="icon text-white">
                                            <i class="fas fa-fw fa-trash"></i>
                                        </span>
                                    </a>
                                </td>
                            </tr>
                        <?php $no++;
                        endforeach;
                        ?>
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
            <form action="<?= base_url('Role/storeRole') ?>" method="POST">
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
<?php foreach ($roles as $row) : ?>
    <div class="modal fade" id="editRole<?= $row['id_role'] ?>" data-backdrop="static" tabindex="-1" aria-labelledby="editRoleLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoleLabel">Edit Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('Role/editRole/') . $row['id_role'] ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" name="role" class="form-control" id="newrole" placeholder="Nama Role" value="<?= ucfirst($row['nama']) ?>">
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