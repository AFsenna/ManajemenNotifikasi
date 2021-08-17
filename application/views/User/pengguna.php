<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">Pengguna Aplikasi</h1>
    <div class="mb-3">
        <button class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#newPengguna">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Pengguna</span>
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
                            <th>Nama</th>
                            <th>No HP</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Senna</td>
                            <td>082285132960</td>
                            <td>fgelicia@gmail.com</td>
                            <td>
                                <button class="btn btn-warning btn-icon-split" data-toggle="modal" data-target="#editPengguna">
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
                            <td>Michael</td>
                            <td>083033432932</td>
                            <td>araona@gmail.com</td>
                            <td>
                                <button class="btn btn-warning btn-icon-split" data-toggle="modal" data-target="#editPengguna">
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
            <form action="<?= base_url('User/pengguna/Cabriz') ?>" method="POST">
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
<div class="modal fade" id="editPengguna" data-backdrop="static" aria-labelledby="editPenggunaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPenggunaLabel">Edit Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('User/pengguna/Cabriz') ?>" method="POST">
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
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- endmodal -->