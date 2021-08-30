<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">Report</h1>
    <?= form_error('tanggalAwal', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?= form_error('tanggalAkhir', '<div class="alert alert-danger" role="alert">', '</div>') ?>
    <?= $this->session->flashdata('message'); ?>

    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Report Data</h6>
            </div>
            <div class="card-body">
                <form action="<?= base_url('report/exportPDF') ?>" method="POST" target="_blanks">
                    <div class="form-group">
                        <label for="tanggalAwal">Tanggal Awal</label>
                        <input type="date" name="tanggalAwal" class="form-control" id="tglAwal">
                    </div>
                    <div class="form-group">
                        <label for="tanggalAkhir">Tanggal Akhir</label>
                        <input type="date" name="tanggalAkhir" class="form-control" id="tglAkhir">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->