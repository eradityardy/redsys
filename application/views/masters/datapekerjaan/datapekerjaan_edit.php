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
                            <div class="card-title"><strong>Edit Pekerjaan</strong></div>
                        </div>
                        <div class="card-body">
                            <?php echo form_open_multipart('datapekerjaan/editpekerjaan/' . $pekerjaan['id']); ?>
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label for="pekerjaan">Pekerjaan</label>
                                        <input type="text" id="pekerjaan" name="pekerjaan" class="form-control" value="<?php echo $pekerjaan['pekerjaan'] ?>" required>
                                    </div>
                                    <div class="col col-md-6">
                                        <label for="std_harga" class="form-control-label">Harga</label>
                                        <input type="text" id="std_harga" name="std_harga" class="form-control" value="<?php echo $pekerjaan['std_harga'] ?>" required>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-12">
                                        <label for="keterangan" class="form-control-label">Keterangan</label>
                                        <textarea name="keterangan" id="keterangan" rows="5" placeholder="Keterangan" class="form-control"><?php echo $pekerjaan['keterangan'] ?></textarea>
                                    </div>
                                </div>
                                <div class="float-left">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update</button>
                                </div>
                                <div class="float-right">
                                    <a class="btn btn-warning" href="<?php echo base_url ('datapekerjaan') ?>">
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