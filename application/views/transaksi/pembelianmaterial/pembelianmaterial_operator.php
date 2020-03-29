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
                            <div class="card-title"><strong>Data Pembelian Material</strong></div>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-sm bg-navy" href="<?php echo base_url ('transaksipembelian/TransaksiPembelianPDF') ?>">
                                <i class="fa fa-print"></i>&nbsp; Cetak PDF
                            </a>
                            <a class="btn btn-sm btn-success" href="<?php echo base_url ('transaksipembelian/tambahpembelian') ?>">
                                <i class="fa fa-plus"></i>&nbsp; Tambah Pembelian
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
                                        <th>Faktur</th>
                                        <th>Tanggal Beli</th>
                                        <th>Tanggal Jatuh Tempo</th>
                                        <th>Supplier</th>
                                        <th>Gudang</th>
                                        <th>Total Biaya</th>
                                        <th>Keterangan</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($transaksipem as $t) : ?>
                                        <?php 
                                            $sumprice = $t['sub_total'];
                                            $jth_tmpo = $t['jatuh_tempo'];
                                            $tgl_bli = $t['tgl_beli'];
                                            $tgl_tmpo = date('Y-m-d', strtotime('+'.$jth_tmpo.' days', strtotime($tgl_bli)));
                                        ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $t['no_faktur']; ?></td>
                                            <td><?php echo $t['tgl_beli']; ?></td>
                                            <td><?php echo $tgl_tmpo; ?></td>
                                            <td><?php echo $t['nama']; ?></td>
                                            <td><?php echo $t['nama_gud']; ?></td>
                                            <td align="right"><?php echo 'Rp. '.number_format($sumprice,2); ?></td>
                                            <td><?php echo $t['keterangan']; ?></td>
                                            <td>
                                                <div class="btn-group-vertical">
                                                    <a href="<?php echo base_url('transaksipembelian/lihatpembelian/' . $t['no_faktur']); ?>" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-eye"></i> Detail
                                                    </a>
                                                    <a href="<?php echo base_url('transaksipembelian/editpembelian/' . $t['id_tbm']); ?>" class="tombol-edit btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i> Edit
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