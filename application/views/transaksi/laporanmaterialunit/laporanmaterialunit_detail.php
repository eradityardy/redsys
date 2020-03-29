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
                            <div class="card-title"><strong>Detail Laporan Pemakaian Material</strong> - <i><?php echo $unitrum['alamat'] ?></i></div>
                        </div>
                        <div class="float-right">
                            <div class="btn-group">
                                <a class="btn btn-sm bg-navy" href="<?php echo base_url ('laporanmaterialunit/DetaillaporanPDF/'.$id_unit) ?>">
                                    <i class="fa fa-print"></i>&nbsp; Cetak PDF
                                </a>
                                <a class="btn btn-sm btn-warning float-right" href="<?php echo base_url() ?>laporanmaterialunit">
                                    Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-id" class="table table-bordered table-striped" style="font-size:15px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Material</th>
                                        <th>Material</th>
                                        <th>Gudang</th>
                                        <th>Tanggal Pemakaian</th>
                                        <th>Quantity</th>
                                        <th>Harga</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($detaillaporan as $m) : ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $m['kode']; ?></td>
                                            <td><?php echo $m['nama_brg']; ?></td>
                                            <td><?php echo $m['nama_gud']; ?></td>
                                            <td><?php echo $m['tgl_pake']; ?></td>
                                            <td><?php echo $m['qty']; ?></td>
                                            <td align='right'><?php echo 'Rp. '.number_format($m['price'],0); ?></td>
                                            <td align='right'><?php echo 'Rp. '.number_format($m['total_harga'],0); ?></td>
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