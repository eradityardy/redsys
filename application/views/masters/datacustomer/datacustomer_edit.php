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
                            <div class="card-title"><strong>Edit Customer</strong></div>
                        </div>
                        <div class="card-body">
                            <?php echo form_open_multipart('datacustomer/editcustomer/' . $customer['id_cus']); ?>
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label for="nama_cus">Nama</label>
                                        <input type="text" id="nama_cus" name="nama_cus" class="form-control" value="<?php echo $customer['nama_cus'] ?>" required>
                                    </div>
                                    <div class="col col-md-3">
                                        <label for="hp_no">Nomor HP</label>
                                        <input type="number" id="hp_no" name="hp_no" class="form-control" value="<?php echo $customer['hp_no'] ?>" required>
                                    </div>
                                    <div class="col col-md-3">
                                        <label for="telp_no">Nomor Telp</label>
                                        <input type="number" id="telp_no" name="telp_no" class="form-control" value="<?php echo $customer['telp_no'] ?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="no_ktp">Nomor KTP</label>
                                        <input type="number" id="no_ktp" name="no_ktp" class="form-control" value="<?php echo $customer['no_ktp'] ?>" required>
                                    </div>
                                    <div class="col col-md-4">
                                        <label for="no_npwp">Nomor NPWP</label>
                                        <input type="number" id="no_npwp" name="no_npwp" class="form-control" value="<?php echo $customer['no_npwp'] ?>" required>
                                    </div>
                                    <div class="col col-md-4">
                                        <label for="bank_id">Bank Pelaksana</label>
                                        <select name="bank_id" class="form-control" required>
                                        <option value="">- Pilih Bank -</option>
                                            <?php                                
                                            foreach ($data_bank as $row)
                                            {
                                                if ($row->id_bank == $customer['bank_id']){
                                                    echo "<option value='".$row->id_bank."' selected='selected'>".$row->nama_bank."</option>";
                                                }else{
                                                    echo "<option value='".$row->id_bank."'>".$row->nama_bank."</option>";
                                                }
                                            }
                                            echo"</select>" ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="marketing_id">Marketing</label>
                                        <select name="marketing_id" class="form-control" required>
                                        <option value="">- Pilih Marketing -</option>
                                            <?php                                
                                            foreach ($data_mark as $row)
                                            {
                                                if ($row->id_kar == $customer['marketing_id']){
                                                    echo "<option value='".$row->id_kar."' selected='selected'>".$row->nama_kar."</option>";
                                                }else{
                                                    echo "<option value='".$row->id_kar."'>".$row->nama_kar."</option>";
                                                }
                                            }
                                            echo"</select>" ?>
                                    </div>
                                    <div class="col col-md-4">
                                        <label for="unitrumah_id">Unit Rumah</label>
                                        <select name="unitrumah_id" class="form-control" required>
                                        <option value="">- Pilih Rumah -</option>
                                            <?php                                
                                            foreach ($data_unit as $row)
                                            {
                                                if ($row->id_unit == $customer['unitrumah_id']){
                                                    echo "<option value='".$row->id_unit."' selected='selected'>".$row->alamat."</option>";
                                                }else{
                                                    echo "<option value='".$row->id_unit."'>".$row->alamat."</option>";
                                                }
                                            }
                                            echo"</select>" ?>
                                    </div>
                                    <div class="col col-md-4">
                                        <label for="tmpt_kerja">Tempat Bekerja</label>
                                        <input type="text" id="tmpt_kerja" name="tmpt_kerja" class="form-control" value="<?php echo $customer['tmpt_kerja'] ?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label for="alamat_kerja" class="form-control-label">Alamat Kantor</label>
                                        <textarea name="alamat_kerja" id="alamat_kerja" rows="2" class="form-control" required><?php echo $customer['alamat_kerja'] ?></textarea>
                                    </div>
                                    <div class="col col-md-6">
                                        <label for="alamat" class="form-control-label">Alamat Rumah</label>
                                        <textarea name="alamat" id="alamat" rows="2" class="form-control" required><?php echo $customer['alamat'] ?></textarea>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-65">
                                        <label for="nama_pasangan">Nama Pasangan</label>
                                        <input type="text" id="nama_pasangan" name="nama_pasangan" class="form-control" value="<?php echo $customer['nama_pasangan'] ?>" required>
                                    </div>
                                    <div class="col col-md-6">
                                        <label for="hp_no_pasangan">Nomor HP Pasangan</label>
                                        <input type="number" id="hp_no_pasangan" name="hp_no_pasangan" class="form-control" value="<?php echo $customer['hp_no_pasangan'] ?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label for="no_ktp_pasangan">Nomor KTP Pasangan</label>
                                        <input type="number" id="no_ktp_pasangan" name="no_ktp_pasangan" class="form-control" value="<?php echo $customer['no_ktp_pasangan'] ?>" required>
                                    </div>
                                    <div class="col col-md-6">
                                        <label for="no_kk">Nomor Kartu Keluarga</label>
                                        <input type="text" id="no_kk" name="no_kk" class="form-control" value="<?php echo $customer['no_kk'] ?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-12">
                                        <label for="keterangan" class="form-control-label">Keterangan</label>
                                        <textarea name="keterangan" id="keterangan" rows="2" class="form-control"><?php echo $customer['keterangan'] ?></textarea>
                                    </div>
                                </div>
                                <div class="float-left">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update</button>
                                </div>
                                <div class="float-right">
                                    <a class="btn btn-warning" href="<?php echo base_url ('datacustomer') ?>">
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