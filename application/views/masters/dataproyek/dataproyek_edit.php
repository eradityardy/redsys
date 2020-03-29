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
                                <div class="card-title"><strong>Edit Proyek</strong></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php echo form_open_multipart('dataproyek/editproyek/' . $proyek['id_pro']); ?>
                                <div class="row form-group">
                                    <div class="col-md-5">
                                        <label for="kode">Kode Proyek</label>
                                        <input type="text" class="form-control" id="kode" name="kode" value="<?php echo $proyek['kode']; ?>" required>
                                    </div>
                                    <div class="col-md-7">
                                        <label for="nama_pro">Nama Proyek</label>
                                        <input type="text" class="form-control" id="nama_pro" name="nama_pro" value="<?php echo $proyek['nama_pro']; ?>" required>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label for="lokasi">Lokasi Proyek</label>
                                        <input type="text" class="form-control" id="lokasi" name="lokasi" value="<?php echo $proyek['lokasi']; ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="owner">Owner</label>
                                        <input type="text" class="form-control" id="owner" name="owner" value="<?php echo $proyek['owner']; ?>" required>
                                    </div>
                                    <div class="col col-md-4">
                                        <label for="anggaran">Anggaran</label>
                                        <input type="number" id="anggaran" name="anggaran" class="form-control" value="<?php echo $proyek['anggaran']; ?>" required>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label for="tgl_mulai">Tanggal Mulai</label>
                                        <input type="date" id="tgl_mulai" name="tgl_mulai" placeholder="Mulai" class="form-control" value="<?php echo $proyek['tgl_mulai']; ?>" required>
                                    </div>
                                    <div class="col col-md-6">
                                        <label for="tgl_selesai">Tanggal Selesai</label>
                                        <input type="date" id="tgl_selesai" name="tgl_selesai" placeholder="Selesai" class="form-control" value="<?php echo $proyek['tgl_selesai']; ?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-12">
                                        <label for="status">Status</label>
                                        <select name="status" class="form-control" required>
                                            <?php
                                            if ($proyek['status'] == 'Aktif'){
                                                print('<option value="Aktif" selected="selected">Aktif</option>');
                                            }else{
                                                print('<option value="Aktif">Aktif</option>');
                                            }
                                            if ($proyek['status'] == 'Selesai'){
                                                print('<option value="Selesai" selected="selected">Selesai</option>');
                                            }else{
                                                print('<option value="Selesai">Selesai</option>');
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="float-left">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update</button>
                                </div>
                                <div class="float-right">
                                    <a class="btn btn-warning" href="<?php echo base_url ('dataproyek') ?>">
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