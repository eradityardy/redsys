<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo $title; ?></h1>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title"><strong>Edit Supplier</strong></div>
                        </div>
                        <div class="card-body">
                            <?php echo form_open_multipart('datasupplier/editsupplier/' . $supplier['id']); ?>
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label for="nama">Nama</label>
                                        <input type="text" id="nama" name="nama" class="form-control" value="<?php echo $supplier['nama'] ?>" required>
                                    </div>
                                    <div class="col col-md-6">
                                        <label for="hp_no">Nomor HP</label>
                                        <input type="number" id="hp_no" name="hp_no" class="form-control" value="<?php echo $supplier['hp_no'] ?>" required>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label for="alamat" class="form-control-label">Alamat</label>
                                        <textarea name="alamat" id="alamat" rows="5" placeholder="Alamat" class="form-control" required><?php echo $supplier['alamat'] ?></textarea>
                                    </div>
                                    <div class="col col-md-6">
                                        <label for="keterangan" class="form-control-label">Keterangan</label>
                                        <textarea name="keterangan" id="keterangan" rows="5" placeholder="Keterangan" class="form-control"><?php echo $supplier['keterangan'] ?></textarea>
                                    </div>
                                </div>
                                <div class="float-left">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update</button>
                                </div>
                                <div class="float-right">
                                    <a class="btn btn-warning" href="<?php echo base_url ('datasupplier') ?>">
                                        Kembali
                                    </a>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->