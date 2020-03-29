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
                            <div class="card-title"><strong>Edit Pekerja</strong></div>
                        </div>
                        <div class="card-body">
                            <?php echo form_open_multipart('datapekerja/editpekerja/' . $pekerja['id_pek']); ?>
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label for="nama_pek">Nama</label>
                                        <input type="text" id="nama_pek" name="nama_pek" class="form-control" value="<?php echo $pekerja['nama_pek'] ?>" required>
                                    </div>
                                    <div class="col col-md-6">
                                        <label for="hp_no">Nomor HP</label>
                                        <input type="number" id="hp_no" name="hp_no" class="form-control" value="<?php echo $pekerja['hp_no'] ?>" required>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="status">Status</label>
                                        <select name="status" class="form-control" required>
                                            <?php
                                            if ($pekerja['status'] == 'Subkon'){
                                                print('<option value="Subkon" selected="selected">Subkon</option>');
                                            }else{
                                                print('<option value="Subkon">Subkon</option>');
                                            }
                                            if ($pekerja['status'] == 'Kontraktor'){
                                                print('<option value="Kontraktor" selected="selected">Kontraktor</option>');
                                            }else{
                                                print('<option value="Kontraktor">Kontraktor</option>');
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col col-md-4">
                                        <label for="perusahaan_pek">Perusahaan</label>
                                        <input type="text" id="perusahaan_pek" name="perusahaan_pek" class="form-control" value="<?php echo $pekerja['perusahaan_pek'] ?>" required>
                                    </div>
                                    <div class="col col-md-4">
                                        <label for="pemilik_perusahaan">Pemilik</label>
                                        <input type="text" id="pemilik_perusahaan" name="pemilik_perusahaan" class="form-control" value="<?php echo $pekerja['pemilik_perusahaan'] ?>" required>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label for="alamat" class="form-control-label">Alamat</label>
                                        <textarea name="alamat" id="alamat" rows="5" placeholder="Alamat" class="form-control" required><?php echo $pekerja['alamat'] ?></textarea>
                                    </div>
                                    <div class="col col-md-6">
                                        <label for="keterangan" class="form-control-label">Keterangan</label>
                                        <textarea name="keterangan" id="keterangan" rows="5" placeholder="Keterangan" class="form-control"><?php echo $pekerja['keterangan'] ?></textarea>
                                    </div>
                                </div>
                                <div class="float-left">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update</button>
                                </div>
                                <div class="float-right">
                                    <a class="btn btn-warning" href="<?php echo base_url ('datapekerja') ?>">
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