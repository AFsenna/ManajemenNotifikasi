<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <style>
        @page {
            margin: 100px 25px;
        }

        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            /* background-color: lightblue; */
            height: 110px;
        }

        main {
            position: relative;
            top: 50px;
            left: 0px;
            height: 820px;
            /* background-color: #ff0080; */
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            /* background-color: lightblue; */
            height: 110px;
            text-align: center;
        }
    </style>
</head>

<body>
    <header>
        <div class="row mb-3">
            <div class="judul ml-3">
                <h1>Laporan Admin</h1>
                <span class="text-secondary">Diekspor Pada : <?= date('d-M-Y H:i:s') ?></span>
            </div>
            <img class="img float-right mr-3" style="width: 90px;" src="<?= base_url('assets/') ?>img/images.jpg">
        </div>
        <hr color="secondary" style="height: 1px; width: 100%;">
    </header>
    <footer>
        <hr color="secondary" style="height: 1px; width: 100%;">
        <p>© Notifbell 2021</p>
    </footer>
    <main>

        <div class="datapengguna">
            <div class="card-header" align="center" style="height: 20px;">
                <h6>Data User</h6>
            </div>
            <table class="table table-striped mt-2 table-bordered">
                <thead class="text-light" style="background-color: #36b9cc;">
                    <tr>
                        <th scope="col">No</th>
                        <th>Nama Lengkap</th>
                        <th>No HP</th>
                        <th>Email</th>
                        <th>Aplikasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($user as $us) : ?>
                        <tr>
                            <th scope="row"><?= $no ?></th>
                            <td><?= ucwords($us['nama_lengkap']) ?></td>
                            <td><?= $us['notelp'] ?></td>
                            <td><?= $us['email'] ?></td>
                            <td>
                                <?php $number = 1;
                                foreach ($aplikasi as $app) {
                                    if ($app['user_id'] == $us['id_user']) {
                                        echo $app['nama_aplikasi'] . ',<br>';
                                    }
                                    $number++;
                                } ?>
                            </td>
                        </tr>
                    <?php $no++;
                    endforeach; ?>
                </tbody>
            </table>

            <div class="card-header" align="center" style="height: 20px; page-break-before:always;">
                <h6>Data Aplikasi</h6>
            </div>
            <table class="table table-striped mt-2 table-bordered">
                <thead class="text-light" style="background-color: #36b9cc;">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Aplikasi</th>
                        <th scope="col">Status</th>
                        <th scope="col">Jumlah Pengguna</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($aplikasi as $app) :
                    ?>
                        <tr>
                            <th scope="row"><?= $no ?></th>
                            <td><?= ucfirst($app['nama_aplikasi']) ?></td>
                            <td>
                                <?php if ($app['status'] == 1) : ?>
                                    <div class="badge badge-pill badge-success" style="min-width: 100px; font-size:15px">Aktif</div>
                                <?php elseif ($app['status'] == 0) : ?>
                                    <div class="badge badge-pill badge-danger" style="min-width: 100px; font-size:15px">Non-Aktif</div>
                                <?php endif; ?>
                            </td>
                            <td><?= $app['jumlah_pengguna']; ?></td>
                        </tr>
                    <?php $no++;
                    endforeach; ?>
                </tbody>
            </table>

        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>

</html>