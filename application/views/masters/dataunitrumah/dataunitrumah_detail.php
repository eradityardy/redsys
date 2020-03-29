<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo $title; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                    <?php echo $this->session->flashdata('msg'); ?>
                    <?php if (validation_errors()) { ?>
                        <div class="alert alert-danger">
                            <strong><?php echo strip_tags(validation_errors()); ?></strong>
                            <a href="" class="float-right text-decoration-none" data-dismiss="alert"><i class="fas fa-times"></i></a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="float-left">
                        <div class="card-title"><strong>Detail Unit Rumah - <?php echo $alamat ?></strong></div>
                    </div>
                    <div class="float-right">
                    <a href="<?php echo base_url('dataunitrumah/editunitrumah/' . $id_unit); ?>" class="tombol-edit btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit Unit Rumah</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="float-left">
                        <strong>Proyek</strong> : <?php echo $nama_pro ?> <br>
                        <strong>Type Rumah</strong> : <?php echo $nama_type ?> <br>
                        <strong>Blok Rumah</strong> : <?php echo $nama_blok ?> <br>
                        <strong>Status</strong> : <?php echo $status ?> <br>
                        <strong>Alamat</strong> : <?php echo $alamat ?> <br>
                        <strong>Luas Tanah</strong> : <?php echo $luas_tanah ?> <br>
                        <strong>Luas Bangunan</strong> : <?php echo $luas_bangunan ?> <br>
                        <strong>Harga Rumah</strong> : <?php echo $harga_rum ?> <br> <p></p>
                        <strong>Status Pekerjaan</strong> : <?php echo $status_pekerjaan ?> <br>
                        <strong>Status Progress</strong> : <?php echo $status_progress ?> <br>
                        <strong>Status Pembelian</strong> : <?php echo $status_beli ?> <br>
                        <strong>Mulai Bangun</strong> : <?php echo $mulai_bangun ?> <br>
                        <strong>Selesai Bangun</strong> : <?php echo $selesai_bangun ?> <br>
                        <strong>Serah Terima Kunci</strong> : <?php echo $tst_kunci ?> <br>
                        <strong>Pekerja</strong> : <?php echo $nama_pek ?> <br>
                        <strong>Keterangan</strong> : <?php echo $nama_arsitek ?> <br>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="float-right">
                        <a class="btn btn-sm btn-warning" href="<?php echo base_url ('dataunitrumah') ?>">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->