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
                            <div class="card-title"><strong>Edit Type Rumah</strong></div>
                        </div>
                        <div class="card-body">
                            <?php echo form_open_multipart('datatyperumah/edittyperumah/' . $typerumah['id_type']); ?>
                                <div class="row form-group">
                                    <div class="col col-md-12">
                                        <label for="nama_type">Type Rumah</label>
                                        <input type="text" id="nama_type" name="nama_type" class="form-control" value="<?php echo $typerumah['nama_type'] ?>" required>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="luas_bangunan">Luas Bangunan</label>
                                        <input type="number" id="luas_bangunan" name="luas_bangunan" class="form-control" value="<?php echo $typerumah['luas_bangunan'] ?>" required>
                                    </div>
                                    <div class="col col-md-4">
                                        <label for="luas_tanah">Luas Tanah</label>
                                        <input type="number" id="luas_tanah" name="luas_tanah" class="form-control" value="<?php echo $typerumah['luas_tanah'] ?>" required>
                                    </div>
                                    <div class="col col-md-4">
                                        <label for="harga_tyrum">Harga</label>
                                        <input type="number" id="harga_tyrum" name="harga_tyrum" class="form-control" value="<?php echo $typerumah['harga_tyrum'] ?>" required>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-12">
                                        <label for="keterangan" class="form-control-label">Keterangan</label>
                                        <textarea name="keterangan" id="keterangan" rows="3" placeholder="Keterangan" class="form-control"><?php echo $typerumah['keterangan'] ?></textarea>
                                    </div>
                                </div>
                                <div class="float-left">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update</button>
                                </div>
                                <div class="float-right">
                                    <a class="btn btn-warning" href="<?php echo base_url ('datatyperumah') ?>">
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