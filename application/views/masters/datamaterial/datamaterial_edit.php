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
                    <div class="card card-primary card-outline"></div>
                        <div class="card-header">
                            <div class="float-left">
                                <div class="card-title"><strong>Edit Material</strong></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php echo form_open_multipart('datamaterial/editmaterial/' . $material['id']); ?>
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label for="kode">Kode</label>
                                        <input type="text" id="kode" name="kode" class="form-control" value="<?php echo $material['kode'] ?>" required>
                                    </div>
                                    <div class="col col-md-6">
                                        <label for="pekerjaan_id">Pekerjaan</label>
                                        <select name="pekerjaan_id" class="form-control" required>
                                        <option value="">- Pilih Pekerjaan -</option>
                                            <?php                                
                                            foreach ($data_pek as $row)
                                            {
                                                if ($row->id == $material['pekerjaan_id']){
                                                    echo "<option value='".$row->id."' selected='selected'>".$row->pekerjaan."</option>";
                                                }else{
                                                    echo "<option value='".$row->id."'>".$row->pekerjaan."</option>";
                                                }
                                            }
                                            echo"</select>" ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-12">
                                        <label for="nama_brg">Nama Material</label>
                                        <input type="text" id="nama_brg" name="nama_brg" class="form-control" value="<?php echo $material['nama_brg'] ?>" required>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label for="satuan" class="form-control-label">Satuan</label>
                                        <input type="text" id="satuan" name="satuan" class="form-control" value="<?php echo $material['satuan'] ?>" required>
                                    </div>
                                    <div class="col col-md-6">
                                        <label for="harga" class="form-control-label">Harga</label>
                                        <input type="text" id="harga" name="harga" class="form-control" value="<?php echo $material['harga'] ?>" required>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-12">
                                        <label for="keterangan" class="form-control-label">Keterangan</label>
                                        <textarea name="keterangan" id="keterangan" rows="3" placeholder="Keterangan" class="form-control"><?php echo $material['keterangan'] ?></textarea>
                                    </div>
                                </div>
                                <div class="float-left">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update</button>
                                </div>
                                <div class="float-right">
                                    <a class="btn btn-warning" href="<?php echo base_url ('datamaterial') ?>">
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