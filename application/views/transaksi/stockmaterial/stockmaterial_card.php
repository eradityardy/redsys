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
                            <a class="btn btn-sm bg-navy" href="<?php echo base_url ('stockmaterial/KartuStockPDF/'.$id_stomat) ?>">
                                <i class="fa fa-print"></i>&nbsp; Cetak PDF
                            </a>
                            <a class="btn btn-sm btn-warning float-right" href="<?php echo base_url() ?>stockmaterial">
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
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <div class="card-title"><strong><?php echo $stock['kode'] ?></strong></div> <br>
                            <div class="card-title"><?php echo $stock['nama_brg'] ?></div>
                        </div>
                        <div class="float-right">
                            <br>
                            <div class="card-title"><?php echo $stock['nama_gud'] ?></div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-id" class="table table-bordered table-striped" style="font-size:15px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Relasi</th>
                                        <th>No Dokumen</th>
                                        <th>Masuk</th>
                                        <th>Keluar</th>
                                        <th>Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if ($stockcard != null){
                                        $i = 1;
                                        $saldo = 0;
                                        foreach ($stockcard->result_array() as $l): 
                                            $tanggal = $l['tanggal'];
                                            $relasi = $l['relasi'];
                                            $no_document = $l['no_document'];
                                            $masuk = $l['masuk'];
                                            $keluar = $l['keluar'];
                                            $saldo = $saldo + ($masuk - $keluar);
                                    ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $tanggal; ?></td>
                                            <td><?php echo $relasi; ?></td>
                                            <td><?php echo $no_document; ?></td>
                                            <td><?php echo $masuk; ?></td>
                                            <td><?php echo $keluar; ?></td>
                                            <td><?php echo $saldo; ?></td>
                                        </tr>
                                    <?php endforeach; 
                                    } ?>
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