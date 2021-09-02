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
                <h1>Data Laporan</h1>
                <span class="text-secondary"><?= date('d-M-Y', strtotime($tanggalAwal)); ?> s/d <?= date('d-M-Y', strtotime($tanggalAkhir)); ?></span>
            </div>
            <img class="img float-right mr-3" style="width: 90px;" src="<?= base_url('assets/') ?>img/images.jpg">
        </div>
        <hr color="secondary" style="height: 1px; width: 100%;">
    </header>
    <footer>
        <hr color="secondary" style="height: 1px; width: 100%;">
        <p>© Notifbell 2021</p> Diberikan Untuk : <?= $namaUser; ?>
        || Diekspor Pada : <?= date('d-M-Y H:i:s') ?>
    </footer>
    <main>
        <?php
        $count = 0;
        foreach ($aplikasi as $row) :
        ?>
            <div class="datapengguna">
                <div class="card-header">
                    <h5 class="text-info">Aplikasi : <?= $row['nama_aplikasi'] ?></h5>
                </div>
                <div class="card-body">
                    <div class="card-header" align="center" style="height: 20px;">
                        <h6>Data Pengguna Aplikasi</h6>
                    </div>
                    <table class="table table-striped mt-2 table-bordered">
                        <thead class="text-light" style="background-color: #36b9cc;">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col" style="width: 100px;">Tanggal dibuat</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Nomor telepon</th>
                                <th scope="col">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($penggunaApp as $pengguna) :
                                if ($pengguna['aplikasi_id'] == $row['id_aplikasi']) :
                            ?>
                                    <tr>
                                        <th scope="row"><?= $no ?></th>
                                        <td><?= date('d-M-Y', strtotime($pengguna['tanggal_dibuat'])); ?></td>
                                        <td><?= $pengguna['nama_pengguna']; ?></td>
                                        <td><?= $pengguna['notelp_pengguna']; ?></td>
                                        <td><?= $pengguna['email_pengguna']; ?></td>
                                    </tr>
                                <?php $no++;
                                endif;
                            endforeach;
                            if ($no == 1) : ?>
                                <tr>
                                    <td colspan="5" align="center" class="text-secondary">- Tidak ada data -</td>
                                </tr>
                            <?php endif;
                            ?>
                        </tbody>
                    </table>

                    <div class="card-header" align="center" style="height: 20px;">
                        <h6>Data Notifikasi</h6>
                    </div>
                    <table class="table mt-2 table-bordered">
                        <thead class="text-light" style="background-color: #36b9cc;">
                            <tr>
                                <th scope="col" style="width: 50px;">No</th>
                                <th scope="col" style="width: 95px;">Tanggal Dibuat</th>
                                <th scope="col" style="width: 95px;">Tanggal Terkirim</th>
                                <th scope="col">Judul</th>
                                <th>Penerima</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $nomor = 1;
                            foreach ($notifikasi as $notif) :
                                if ($notif['aplikasi_id'] == $row['id_aplikasi']) : ?>
                                    <tr>
                                        <th scope="row" rowspan="2"><?= $nomor; ?></th>
                                        <td><?= date('d-M-Y', strtotime($notif['tanggalDibuat'])); ?></td>
                                        <?php if ($notif['tanggalTerkirim'] != '0000-00-00') : ?>
                                            <td><?= date('d-M-Y', strtotime($notif['tanggalTerkirim'])); ?></td>
                                        <?php else : ?>
                                            <td align="center" class="text-secondary">-</td>
                                        <?php endif; ?>
                                        <td><?= $notif['judul']; ?></td>
                                        <td>
                                            <?php $number = 1;
                                            foreach ($penerima as $nerima) {
                                                if ($nerima['notifikasi_id'] == $notif['id_notifikasi']) {
                                                    echo $nerima['email_pengguna'], ',<br>';
                                                    $number++;
                                                }
                                            }
                                            if ($number == 1) : ?>
                                                <span align="center" class="text-secondary">- Tidak ada data -</span>
                                            <?php endif;
                                            ?>
                                        </td>
                                    <tr>
                                        <td colspan="2" align="center">Isi Notifikasi : </td>
                                        <td colspan="2"><?= $notif['isi']; ?></td>
                                    </tr>
                                    </tr>
                                <?php $nomor++;
                                endif;
                            endforeach;
                            if ($nomor == 1) : ?>
                                <tr>
                                    <td colspan="5" align="center" class="text-secondary">- Tidak ada data -</td>
                                </tr>
                            <?php endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
            $count++;
            if ($count == count($aplikasi)) : ?>
                <div style="page-break-after: never;"></div>
            <?php
            else : ?>
                <div style="page-break-after: always;"></div>
        <?php
            endif;
        endforeach; ?>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>

</html>