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
                <div class="col-sm-12">
                    <div class="float-left">
                        <h1><?php echo $title; ?></h1>
                    </div>
                    <div class="float-right">
                        
                        <div class="btn-group">
                            <a class="btn btn-sm bg-navy" href="<?php echo base_url ('transaksipembelian/DetailPembelianPDF/'.$no_faktur) ?>">
                                <i class="fa fa-print"></i>&nbsp; Cetak PDF
                            </a>
                            <a class="btn btn-sm btn-warning float-right" href="<?php echo base_url() ?>transaksipembelian">
                                Kembali
                            </a>
                        </div>
                    </div>
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
                        <div class="card-title"><strong><?php echo $no_faktur ?></strong></div> <br>
                        <div class="card-title"><?php echo $nama_gud ?></div>
                    </div>
                    <div class="float-right">
                        <div class="card-title"><strong><?php echo $tgl_beli ?></strong></div> <br>
                        <div class="card-title"><?php echo $nama ?></div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-id" class="table table-bordered table-striped" style="font-size:15px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Material</th>
                                    <th>Quantity</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                    <th>Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($detailpembelian as $c) : ?>
                                    <?php
                                        $qty = $c['qty'];
                                        $price = $c['price'];
                                        $sub_total = $c['sub_total'];
                                        $satuan = $c['satuan'];
                                    ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $c['nama_brg']; ?></td>
                                        <td align='right'><?php echo number_format($qty,0); ?></td>
                                        <td><?php echo $c['satuan']; ?></td>
                                        <td align='right'><?php echo 'Rp. '.number_format($price,0); ?></td>
                                        <td align='right'><?php echo 'Rp. '.number_format($sub_total,0); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="float-left">
                            Total Harga: <strong><?php echo 'Rp. '.number_format($total,0) ?></strong>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->