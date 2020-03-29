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
                            <div class="float-left">
                                <div class="card-title"><strong>Edit Bank</strong></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php echo form_open_multipart('databank/editbank/' . $bank['id_bank']); ?>
                                <div class="row form-group">
                                    <div class="col-md-5">
                                        <label for="kode_bank">Kode Bank</label>
                                        <input type="text" class="form-control" id="kode_bank" name="kode_bank" value="<?php echo $bank['kode_bank']; ?>" required>
                                    </div>
                                    <div class="col-md-7">
                                        <label for="nama_bank">Nama Bank</label>
                                        <input type="text" class="form-control" id="nama_bank" name="nama_bank" value="<?php echo $bank['nama_bank']; ?>" required>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label for="plafond_kredit">Plafond Kredit</label>
                                        <input type="text" class="form-control" id="plafond_kredit" name="plafond_kredit" value="<?php echo $bank['plafond_kredit']; ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="dana_jaminan">Dana Jaminan</label>
                                        <input type="text" class="form-control" id="dana_jaminan" name="dana_jaminan" value="<?php echo $bank['dana_jaminan']; ?>" required>
                                    </div>
                                    <div class="col col-md-4">
                                        <label for="jangka_waktu">Jangka Waktu</label>
                                        <input type="number" id="jangka_waktu" name="jangka_waktu" class="form-control" value="<?php echo $bank['jangka_waktu']; ?>" required>
                                    </div>
                                </div>
                                <div class="float-left">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update</button>
                                </div>
                                <div class="float-right">
                                    <a class="btn btn-warning" href="<?php echo base_url ('databank') ?>">
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