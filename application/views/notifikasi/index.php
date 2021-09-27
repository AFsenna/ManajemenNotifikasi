<!-- include summernote css/js -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    var clicked = false;
</script>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">Notifikasi</h1>
    <?= form_error('judul', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?= form_error('isinotif', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?= $this->session->flashdata('message'); ?>
    <div class="mb-3">
        <button class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#newNotifikasi">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Notifikasi</span>
        </button>
        <button class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#panduan">
            <span class="icon text-white-50">
                <i class="fas fa-exclamation-circle"></i>
            </span>
            <span class="text">Panduan</span>
        </button>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary mb-2">Tabel Data Notifikasi</h6>
            <h6 class="m-0 font-weight-bold text-danger float-right">Milik Aplikasi : <?= $namaAplikasi ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Dibuat</th>
                            <th>Judul</th>
                            <th>Notifikasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($notifikasi as $row) : ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= date('d-M-Y', strtotime($row['tanggalDibuat'])); ?></td>
                                <td><?= ucwords($row['judul']) ?></td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#daftarPenerima<?= $row['id_notifikasi'] ?>">
                                        <span class="icon text-white">
                                            Detail
                                        </span>
                                    </button>
                                </td>
                                <td>
                                    <?php if ($row['status'] == 0) : ?>
                                        <div class="badge badge-pill badge-danger" style="max-width: 150px; font-size:15px">Belum Terkirim</div>
                                    <?php elseif ($row['status'] == 1) : ?>
                                        <div class="badge badge-pill badge-success" style="max-width: 150px; font-size:15px">Sudah Terkirim</div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['status'] == 0) : ?>
                                        <button class="btn btn-sm btn-warning mb-2" data-toggle="modal" data-target="#editNotifikasi<?= $row['id_notifikasi'] ?>">
                                            <span class="icon text-white" data-toggle="tooltip" title="Edit Notifikasi">
                                                <i class="fas fa-fw fa-edit"></i>
                                            </span>
                                        </button>
                                        <a href="<?= base_url('Notifikasi/deleteNotifikasi/' . $id_aplikasi . '/' . $row['id_notifikasi']) ?>" class="btn btn-sm btn-danger mb-2" data-toggle="tooltip" title="Hapus Notifikasi">
                                            <span class="icon text-white">
                                                <i class="fas fa-fw fa-trash"></i>
                                            </span>
                                        </a>
                                        <button class="btn btn-sm btn-success mb-2" data-toggle="modal" data-target="#kirimkanModal<?= $row['id_notifikasi'] ?>">
                                            <span class="icon text-white">
                                                <i class="fas fa-fw fa-share-square"></i> Kirimkan
                                            </span>
                                        </button>
                                    <?php elseif ($row['status'] == 1) : ?>
                                        <button class="btn btn-sm btn-info mb-2" data-toggle="modal" data-target="#detailPengiriman<?= $row['id_notifikasi'] ?>">
                                            <span class="icon text-white" data-toggle="tooltip" title="Detail Pengiriman">
                                                <i class="fas fa-fw fa-eye"></i>
                                            </span>
                                        </button>
                                    <?php endif; ?>
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

<!-- Modal tambah Notifikasi-->
<div class="modal fade" id="newNotifikasi" data-backdrop="static" tabindex="-1" aria-labelledby="newNotifikasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newNotifikasiLabel">Tambah Notifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Notifikasi/tambahNotifikasi/' . $id_aplikasi) ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="tanggal" class="form-control" value="<?= date("Y-m-d"); ?>">
                        <input type="text" name="judul" class="form-control" id="judul" placeholder="Judul Notifikasi">
                    </div>
                    <div class="form-group">
                        <textarea class="summernote" name="isinotif" placeholder="Isi Notifikasi" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <select name="media_id" id="media_id" class="form-control">
                            <option value="" disabled selected>-- Select Media --</option>
                            <?php foreach ($media as $m) : ?>
                                <option value="<?= $m['id_media'] ?>"><?= $m['nama_media'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="card">
                            <div class="card-body text-dark">
                                <h4> Pilih Penerima Notifikasi</h4>
                                <p>
                                <div class="btn btn-success" onclick="checkAll()">Pilih Semua</div>
                                </p>
                                <?php foreach ($pengguna as $row) : ?>
                                    <span class="text-dark mr-3"><input type="checkbox" name="penerima[]" id="check<?= $row['id_pengguna'] ?>" class="pl" value="<?= $row['id_pengguna'] ?>"> <?= ucwords($row['nama_pengguna']) . '(' . $row['email_pengguna'] . ')' ?> </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
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

<!-- Modal edit Notifikasi-->
<?php foreach ($notifikasi as $row) : ?>
    <div class="modal fade" id="editNotifikasi<?= $row['id_notifikasi'] ?>" data-backdrop="static" aria-labelledby="editNotifikasiLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editNotifikasiLabel">Edit Notifikasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('Notifikasi/editNotifikasi/' . $id_aplikasi) ?>" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="tanggal" class="form-control" value="<?= date("Y-m-d"); ?>">
                        <input type="hidden" name="idnotif" class="form-control" value="<?= $row['id_notifikasi'] ?>">
                        <div class="form-group">
                            <input type="text" name="judul" class="form-control" placeholder="Judul Notifikasi" value="<?= $row['judul'] ?>">
                        </div>
                        <div class="form-group">
                            <textarea class="summernote" name="isinotif" placeholder="Isi Notifikasi" cols="30" rows="10"><?= $row['isi'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <select name="media_id" id="media_id" class="form-control">
                                <option value="" disabled selected>-- Select Media --</option>
                                <?php foreach ($media as $m) : ?>
                                    <option value="<?= $m['id_media'] ?>" <?php if ($row['media_id'] == $m['id_media']) : ?>selected<?php endif ?>>
                                        <?= ucfirst($m['nama_media']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class=" form-group">
                            <div class="card">
                                <div class="card-body text-dark">
                                    <h4> Penerima Notifikasi</h4>
                                    <p>
                                    <div class="btn btn-success" onclick="checkAll()">Pilih Semua</div>
                                    </p>
                                    <?php foreach ($pengguna as $us) : ?>
                                        <span class="text-dark mr-3"><input type="checkbox" <?= checkPengguna($us['id_pengguna'], $row['id_notifikasi']) ?> name="penerima[]" class="pl" value="<?= $us['id_pengguna'] ?>"> <?= ucwords($us['nama_pengguna']) . '(' . $us['email_pengguna'] . ')' ?> </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
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

<!-- Modal list aplikasi-->
<?php $no = 1;
foreach ($notifikasi as $row) : ?>
    <div class="modal fade" id="daftarPenerima<?= $row['id_notifikasi'] ?>" tabindex="-1" aria-labelledby="daftarPenerimaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="daftarPenerimaLabel">Detail Notifikasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> </br>
                </div>
                <div class="modal-body">
                    <h6 class="mb-3 text-danger">Notifikasi No : <?= $no ?></h6>
                    <h6>Media Pengiriman : <?= ucfirst($row['nama_media']); ?></h6>
                    <div>
                        <div class="card mb-4">
                            <div class="card-header">
                                Isi Notifikasi
                            </div>
                            <div class="card-body">
                                <?= $row['isi'] ?>
                            </div>
                        </div>

                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered tablepengguna" id="dataTable" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Penerima</th>
                                    <th>Email Penerima</th>
                                    <th>Notelp Penerima</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $num = 1;
                                foreach ($penerima as $us) :
                                    if ($us['notifikasi_id'] == $row['id_notifikasi']) :
                                ?>
                                        <tr>
                                            <td><?= $num ?></td>
                                            <td><?= ucwords($us['nama_pengguna']) ?></td>
                                            <td><?= $us['email_pengguna'] ?></td>
                                            <td><?= $us['notelp_pengguna'] ?></td>
                                        </tr>
                                <?php
                                        $num++;
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
<?php $no++;
endforeach; ?>
<!-- endmodal -->

<!-- kirimkan Modal-->
<?php foreach ($notifikasi as $row) : ?>
    <div class="modal fade" id="kirimkanModal<?= $row['id_notifikasi'] ?>" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Verifikasi pengiriman notifikasi</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong>
                        <h6 style="color:crimson">Judul Notifikasi : <?= $row['judul'] ?> </h6>
                    </strong>
                    <h6 style="color:crimson">Media Pengiriman : <?= $row['nama_media'] ?> </h6>
                    Apakah anda yakin akan mengirim notifikasi ke penerima?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <?php if ($row['nama_media'] == 'telegram') : ?>
                        <button class="btn btn-primary" id="btnKirim<?= $row['id_notifikasi'] ?>" onclick="useridTele(`<?= $row['id_notifikasi'] ?>`,`<?= $id_aplikasi ?>`)">Kirimkan</button>
                    <?php elseif ($row['nama_media'] == 'email') : ?>
                        <a href="<?= base_url('Notifikasi/kirimNotifikasi/' .  $id_aplikasi . '/' . $row['id_notifikasi']) ?>" class="btn btn-primary" id="btnKirim<?= $row['id_notifikasi'] ?>">Kirimkan</a>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<!-- endmodal -->

<!-- Modal detail notifikasi-->
<?php $no = 1;
foreach ($notifikasi as $row) : ?>
    <div class="modal fade" id="detailPengiriman<?= $row['id_notifikasi'] ?>" tabindex="-1" aria-labelledby="daftarPenerimaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="daftarPenerimaLabel">Detail Notifikasi No <?= $no ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> </br>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 text-info d-flex justify-content-between">
                        <h6>Tanggal dikirimkan : <?= date('d-M-Y', strtotime($row['tanggalTerkirim'])); ?></h6>
                        <h6>Media Pengiriman : <?= ucfirst($row['nama_media']); ?></h6>
                    </div>
                    <hr class="mb-5">
                    <div class="table-responsive">
                        <table class="table table-bordered tablepengguna" id="dataTable" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Penerima</th>
                                    <th>Email Penerima</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $num = 1;
                                foreach ($penerima as $us) :
                                    if ($us['notifikasi_id'] == $row['id_notifikasi']) :
                                ?>
                                        <tr>
                                            <td><?= $num ?></td>
                                            <td><?= $us['nama_pengguna'] ?></td>
                                            <td><?= $us['email_pengguna'] ?></td>
                                            <td>
                                                <?php if ($us['status'] == 0) : ?>
                                                    <div class="badge badge-pill badge-danger" style="max-width: 200px; font-size:15px">Tidak Ditemukan</div>
                                                <?php elseif ($us['status'] == 1) : ?>
                                                    <div class="badge badge-pill badge-success" style="max-width: 200px; font-size:15px">Berhasil Terkirim</div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                <?php
                                        $num++;
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
<?php $no++;
endforeach; ?>
<!-- endmodal -->

<!-- Modal panduan-->
<div class="modal fade" id="panduan" data-backdrop="static" tabindex="-1" aria-labelledby="panduanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="panduanLabel">Panduan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <ol class="mt-3" type="1">
                <div class="mb-3">
                    <li class="text-info">Untuk pengiriman notifikasi dengan media email</li>
                    <ul>
                        <li>Pastikan data email sudah terisi dengan benar</li>
                    </ul>
                </div>
                <div class="mb-2">
                    <li class="text-info">Untuk pengiriman notifikasi dengan media telegram</li>
                    <ul>
                        <li>Pastikan pengguna aplikasi sudah follow / start bot @Notifbell di telegram</li>
                        <li>Pastikan data nomor telepon terisi dengan benar</li>
                        <li>Pastikan data username telegram sudah terisi dengan benar</li>
                        <li>Telegram hanya dapat menggunakan sedikit tag HTML jadi pastikan tidak ada tag p dan br pada notifikasi anda</li>
                    </ul>
                </div>
            </ol>
            <span class="text-danger ml-2">*Apabila ada data yang kurang maka pengguna aplikasi anda tidak akan mendapatkan notifikasi</span>
        </div>
    </div>
</div>
<!-- endmodal -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
    <?php foreach ($notifikasi as $row) : ?>
        $('#btnKirim<?= $row['id_notifikasi'] ?>').click(function() {
            Swal.fire({
                title: 'Proses pengiriman notifikasi',
                text: 'Jangan close page ini sampai proses pengiriman selesai! Pengiriman notifikasi membutuhkan waktu cukup lama mohon ditunggu.',
                allowEscapeKey: false,
                allowOutsideClick: false,
                onOpen: () => {
                    Swal.showLoading();
                }
            })
        });
    <?php endforeach; ?>
    $('.summernote').summernote({
        placeholder: 'Isi Notifikasi',
        tabsize: 2,
        height: 120,
        toolbar: [
            // ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            // ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
            ['view', ['codeview', 'help']]
        ]
    });

    function checkAll() {
        var inputs = document.querySelectorAll('.pl');
        if (clicked == false) {
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].checked = true;
            }
            clicked = true;
        } else if (clicked == true) {
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].checked = false;
            }
            clicked = false;
        }
        return clicked;
    }


    function useridTele(idnotif, idapk) {
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>Notifikasi/selectUser/" + idnotif,
            async: true,
            cache: false,
            success: function(result) {
                var obj = $.parseJSON(result);
                // var user_id = [];
                // console.log(obj);
                for (let i = 0; i < obj.length; ++i) {
                    // console.log(obj[i]['nama_pengguna']);
                    if (obj[i]['userid_telegram'] == null) {
                        $.get('https://api.telegram.org/bot1962226292:AAGcBqfrYjaZi9ViByYFmIRLxXh-LgC-u-A/sendContact?chat_id=1626261247&phone_number=' + obj[i]['notelp_pengguna'] + '&first_name=' + obj[i]['username_telegram'], function(data) {
                            // console.log(data.result.contact.user_id);
                            // user_id.push(data.result.contact.user_id);
                            $.ajax({
                                type: "POST",
                                url: "<?= base_url(); ?>Notifikasi/storeIdtele",
                                data: {
                                    userid_telegram: data.result.contact.user_id, // Second add quotes on the value.
                                    user_id: obj[i]['id_pengguna'],
                                },
                                cache: false,
                                dataType: 'json',
                            });
                        });
                    }
                    // else {
                    //     user_id.push(obj[i]['userid_telegram']);
                    // }
                }
                // console.log(user_id);
            }
        });
        window.location.replace(`<?= base_url('Notifikasi/kirimNotifikasi/') ?>${idapk}<?= '/' ?>${idnotif}`);
        // `<?= base_url('Notifikasi/kirimNotifikasi/') ?>${idapk}<?= '/' ?>${idnotif}`;
    }

    $(document).ready(function() {
        $('.tablepengguna').dataTable();
    });
</script>