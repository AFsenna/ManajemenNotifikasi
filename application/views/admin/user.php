<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 text-gray-800 mb-3">User</h1>

    <!-- DataTables Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Data User</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>No HP</th>
                            <th>Email</th>
                            <th>Aplikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($dataUser as $row) : ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= ucwords($row['nama_lengkap']) ?></td>
                                <td><?= $row['notelp'] ?></td>
                                <td><?= $row['email'] ?></td>
                                <td>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#list<?= $row['id_user'] ?>">List Aplikasi</button>
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

<!-- Modal list aplikasi-->
<?php foreach ($dataUser as $row) : ?>
    <div class="modal fade" id="list<?= $row['id_user'] ?>" tabindex="-1" aria-labelledby="listLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="listLabel">List Aplikasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> </br>
                </div>
                <div class="modal-body">
                    <h6 class="mb-3 text-danger">Nama User : <?= ucwords($row['nama_lengkap']) ?></h6>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Aplikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($aplikasi as $app) :
                                    if ($app['user_id'] == $row['id_user']) : ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $app['nama_aplikasi'] ?></td>
                                        </tr>
                                <?php $no++;
                                    endif;
                                endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<!-- endmodal -->