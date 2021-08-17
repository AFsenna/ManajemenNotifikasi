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
    <div class="mb-3">
        <button class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#newNotifikasi">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Notifikasi</span>
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
                            <th>Judul</th>
                            <th>Isi Notifikasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Pergantian Nama Aplikasi</td>
                            <td style="max-width: 300px;">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Pariatur inventore, laudantium tempore suscipit ipsa non error!</td>
                            <td>
                                <div class="badge badge-pill badge-success" style="max-width: 150px; font-size:15px">Terkirim</div>
                            </td>
                            <td>
                                <button href="#" class="btn btn-warning" data-toggle="modal" data-target="#editNotifikasi">
                                    <span class="icon text-white" data-toggle="tooltip" title="Edit Notifikasi">
                                        <i class="fas fa-fw fa-edit"></i>
                                    </span>
                                </button>
                                <a href="#" class="btn btn-danger" data-toggle="tooltip" title="Delete Notifikasi">
                                    <span class="icon text-white">
                                        <i class="fas fa-fw fa-trash"></i>
                                    </span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Pengumuman Gaji</td>
                            <td style="max-width: 300px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem ad sequi dignissimos laudantium impedit aliquam. Ut, deserunt. Repudiandae, itaque, blanditiis hic enim doloribus ullam iure, dignissimos numquam quam iusto reiciendis?</td>
                            <td>
                                <div class="badge badge-pill badge-danger" style="max-width: 150px; font-size:15px">Belum Terkirim</div>
                            </td>
                            <td>
                                <button href="#" class="btn btn-warning" data-toggle="modal" data-target="#editNotifikasi">
                                    <span class="icon text-white" data-toggle="tooltip" title="Edit Notifikasi">
                                        <i class="fas fa-fw fa-edit"></i>
                                    </span>
                                </button>
                                <a href="#" class="btn btn-danger" data-toggle="tooltip" title="Delete Notifikasi">
                                    <span class="icon text-white">
                                        <i class="fas fa-fw fa-trash"></i>
                                    </span>
                                </a>
                                <button class="btn btn-info" data-toggle="tooltip" title="Kirimkan Notifikasi">
                                    <span class="icon text-white">
                                        <i class="fas fa-fw fa-share-square"></i>
                                    </span>
                                </button>
                            </td>
                        </tr>
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
            <form action="<?= base_url('User/notifikasi') ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="judul" class="form-control" id="judul" placeholder="Judul Notifikasi">
                    </div>
                    <div class="form-group">
                        <input type="textarea" id="summernote" name="isinotif" placeholder="Isi Notifikasi"></input>
                    </div>
                    <div class="form-group">
                        <div class="card">
                            <div class="card-body text-dark">
                                <h4> Pilih Penerima Notifikasi</h4>
                                <p>
                                <div class="btn btn-success" onclick="checkAll()">Pilih Semua</div>
                                </p>
                                <span class="text-dark mr-2"><input type="checkbox" id="check1" class="pl" value="Senna"> Senna </span>
                                <span class="text-dark mr-2"><input type="checkbox" id="check2" class="pl" value="Michael"> Michael </span>
                                <span class="text-dark mr-2"><input type="checkbox" id="check3" class="pl" value="Fadia"> Fadia </span>
                                <span class="text-dark mr-2"><input type="checkbox" class="pl" id="check4" value="Corrine"> Corrine </span>
                                <!-- <div class="btn btn-danger" onclick="getCheckboxValue()">hasil</div> -->
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
<div class="modal fade" id="editNotifikasi" data-backdrop="static" aria-labelledby="editNotifikasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editNotifikasiLabel">Edit Notifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('User/notifikasi') ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="judul" class="form-control" id="newjudul" placeholder="Judul Notifikasi">
                    </div>
                    <div class="form-group">
                        <input type="textarea" id="summernoteedit" name="isinotif" placeholder="Isi Notifikasi"></input>
                    </div>
                    <div class="form-group">
                        <div class="card">
                            <div class="card-body text-dark">
                                <h4> Penerima Notifikasi</h4>
                                <p>
                                <div class="btn btn-success" onclick="checkAll()">Pilih Semua</div>
                                </p>
                                <span class="text-dark mr-2"><input type="checkbox" id="newcheck1" class="pl" value="Senna"> Senna </span>
                                <span class="text-dark mr-2"><input type="checkbox" id="newcheck2" class="pl" value="Michael"> Michael </span>
                                <span class="text-dark mr-2"><input type="checkbox" id="newcheck3" class="pl" value="Fadia"> Fadia </span>
                                <span class="text-dark mr-2"><input type="checkbox" id="newcheck4" class="pl" value="Corrine"> Corrine </span>
                                <!-- <div class="btn btn-danger" onclick="getCheckboxValue2()">hasil</div> -->
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
<!-- endmodal -->

<script>
    $('#summernote').summernote({
        placeholder: 'Isi Notifikasi',
        tabsize: 2,
        height: 120,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']],
            ['view', ['codeview', 'help']]
        ]
    });
    $('#summernoteedit').summernote({
        placeholder: 'Isi Notifikasi',
        tabsize: 2,
        height: 120,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
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

    function getCheckboxValue() {

        var l1 = document.getElementById("check1");
        var l2 = document.getElementById("check2");
        var l3 = document.getElementById("check3");
        var l4 = document.getElementById("check4");

        var res = " ";

        if (l1.checked == true) {
            var pl1 = document.getElementById("check1").value;
            res = res + pl1;
        }
        if (l2.checked == true) {
            var pl2 = document.getElementById("check2").value;
            res = res + " " + pl2;
        }
        if (l3.checked == true) {
            var pl3 = document.getElementById("check3").value;
            res = res + " " + pl3;
        }
        if (l4.checked == true) {
            var pl4 = document.getElementById("check4").value;
            res = res + " " + pl4;
        }
        console.log(res);
    }

    function getCheckboxValue2() {

        var l1 = document.getElementById("newcheck1");
        var l2 = document.getElementById("newcheck2");
        var l3 = document.getElementById("newcheck3");
        var l4 = document.getElementById("newcheck4");

        var res = " ";

        if (l1.checked == true) {
            var pl1 = document.getElementById("newcheck1").value;
            res = res + pl1;
        }
        if (l2.checked == true) {
            var pl2 = document.getElementById("newcheck2").value;
            res = res + " " + pl2;
        }
        if (l3.checked == true) {
            var pl3 = document.getElementById("newcheck3").value;
            res = res + " " + pl3;
        }
        if (l4.checked == true) {
            var pl4 = document.getElementById("newcheck4").value;
            res = res + " " + pl4;
        }
        console.log(res);
    }
</script>