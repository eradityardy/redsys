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
                        <div class="card-title"><strong>Detail Customer - <?php echo $nama_cus ?></strong></div>
                    </div>
                    <div class="float-right">
                    <a href="<?php echo base_url('datacustomer/editcustomer/' . $id_cus); ?>" class="tombol-edit btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit Customer</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="float-left">
                        <strong>Nama</strong> : <?php echo $nama_cus ?> <br>
                        <strong>Alamat</strong> : <?php echo $alamat_tinggal ?> <br>
                        <strong>Nomor KTP</strong> : <?php echo $no_ktp ?> <br>
                        <strong>Nomor NPWP</strong> : <?php echo $no_npwp ?> <br>
                        <strong>Bank</strong> : <?php echo $nama_bank ?> <br>
                        <strong>Nomor Handphone</strong> : <?php echo $hp_no ?> <br>
                        <strong>Nomor Telephone</strong> : <?php echo $telp_no ?> <br>
                        <strong>Tempat Bekerja</strong> : <?php echo $tmpt_kerja ?> <br>
                        <strong>Alamat Bekerja</strong> : <?php echo $alamat_kerja ?> <br> <p></p>

                        <strong>Unit Rumah</strong> : <?php echo $alamat ?> <br>
                        <strong>Marketing</strong> : <?php echo $nama_kar ?> <br>

                        <strong>Nama Pasangan</strong> : <?php echo $nama_pasangan ?> <br>
                        <strong>Nomor Handphone Pasangan</strong> : <?php echo $hp_no_pasangan ?> <br>
                        <strong>Nomor KTP Pasangan</strong> : <?php echo $no_ktp_pasangan ?> <br>
                        <strong>Nomor Kartu Keluarga</strong> : <?php echo $no_kk ?> <br>
                        <strong>Keterangan</strong> : <?php echo $keterangan ?>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="float-right">
                        <a class="btn btn-warning" href="<?php echo base_url ('datacustomer') ?>">
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