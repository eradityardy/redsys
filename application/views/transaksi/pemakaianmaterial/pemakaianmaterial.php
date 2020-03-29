<style>
    .dataTables_wrapper {
        font-size: 16px
    }
</style>

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
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <div class="card-title"><strong>Data Pemakaian Material</strong></div>
                        </div>
                        <div class="float-right">
                            <a type="button" href="<?php echo base_url('pemakaianmaterial/exportexcel'); ?>" class="btn btn-sm bg-maroon">
                                <i class="fas fa-file-excel"></i> Cetak Excel
                            </a>
                            <a class="btn btn-sm bg-navy" href="<?php echo base_url ('pemakaianmaterial/PemakaianMaterialPDF') ?>">
                                <i class="fa fa-print"></i>&nbsp; Cetak PDF
                            </a>
                            <a class="btn btn-sm btn-success" href="<?php echo base_url ('pemakaianmaterial/tambahpemakaian') ?>">
                                <i class="fa fa-plus"></i>&nbsp; Tambah Pemakaian
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-id" class="table table-bordered table-striped" style="font-size:15px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nomor</th>
                                        <th>Tanggal Pemakaian</th>
                                        <th>Proyek</th>
                                        <th>Unit Rumah</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($pemakaianmaterial as $p) : ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $p['no_pemakaian']; ?></td>
                                            <td><?php echo $p['tgl_pake']; ?></td>
                                            <td><?php echo $p['nama_pro']; ?></td>
                                            <td><?php echo $p['alamat']; ?></td>
                                            <td align="center">
                                                <div class="btn-group-vertical">
                                                    <a href="<?php echo base_url('pemakaianmaterial/editpemakaian/' . $p['id_pake']); ?>" class="tombol-edit btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="<?php echo base_url('pemakaianmaterial/hapuspemakaian/'.$p['id_pake']); ?>" class="tombol-hapus btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->