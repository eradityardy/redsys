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
                        <div class="card-title"><strong>Data RAB Pekerjaan Unit Rumah</strong></div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-id" class="table table-bordered table-striped" style="font-size:15px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Proyek</th>
                                        <th>Unit Rumah</th>
                                        <th>Customer</th>
                                        <th>Akumulasi Biaya</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $i = 1;
                                        $pemakaian = 0; ?>
                                    <?php foreach ($rabpekbyunit as $c) : ?>
                                        <?php $sumprice = $c['sum_rab'] ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $c['nama_pro']; ?></td>
                                            <td><?php echo $c['alamat']; ?></td>
                                            <td><?php echo $c['nama_cus']; ?></td>
                                            <td align="right"><?php echo 'Rp. '.number_format($sumprice,2); ?></td>
                                            <td>
                                                <a href="<?php echo base_url('rabpekerjaanbyunit/detailrab/' . $c['id_unit']); ?>" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Detail</a>
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