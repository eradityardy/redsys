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
                            <div class="card-title"><strong>Edit Unit Rumah</strong></div>
                        </div>
                        <div class="card-body">
                            <?php echo form_open_multipart('dataunitrumah/editunitrumah/' . $unitrumah['id_unit']); ?>
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label for="proyek_id">Proyek</label>
                                        <select name="proyek_id" class="form-control" readonly>
                                        <option value="">- Pilih Proyek -</option>
                                            <?php                                
                                            foreach ($data_pro as $row)
                                            {
                                                if ($row->id_pro == $unitrumah['proyek_id']){
                                                    echo "<option value='".$row->id_pro."' selected='selected'>".$row->nama_pro."</option>";
                                                }else{
                                                    echo "<option value='".$row->id_pro."'>".$row->nama_pro."</option>";
                                                }
                                            }
                                            echo"</select>" ?>
                                    </div>
                                    <div class="col col-md-6">
                                        <label for="blok_id">Blok Rumah</label>
                                        <select name="blok_id" id="blok_id" class="form-control" readonly>
                                            <option value="">- Pilih Blok Rumah -</option>
                                            <?php                                
                                            foreach ($data_blok as $row)
                                            {
                                                if ($row->id_blok == $unitrumah['blok_id']){
                                                    echo "<option value='".$row->id_blok."' selected='selected'>".$row->nama_blok."</option>";
                                                }else{
                                                    echo "<option value='".$row->id_blok."'>".$row->nama_blok."</option>";
                                                }
                                            }
                                            echo"</select>" ?>
                                        <input type="hidden" id="type_id" name="type_id" value="<?php echo $unitrumah['type_id'] ?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-12">
                                        <label for="alamat" class="form-control-label">Alamat</label>
                                        <textarea name="alamat" id="alamat" rows="2" placeholder="Keterangan" class="form-control" required><?php echo $unitrumah['alamat'] ?></textarea>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="luas_bangunan">Luas Bangunan</label>
                                        <input type="number" id="luas_bangunan" name="luas_bangunan" class="form-control" value="<?php echo $unitrumah['luas_bangunan'] ?>" readonly>
                                    </div>
                                    <div class="col col-md-4">
                                        <label for="luas_tanah">Luas Tanah</label>
                                        <input type="number" id="luas_tanah" name="luas_tanah" class="form-control" value="<?php echo $unitrumah['luas_tanah'] ?>" readonly>
                                    </div>
                                    <div class="col col-md-4">
                                        <label for="harga_rum">Harga Rumah</label>
                                        <input type="number" id="harga_rum" name="harga_rum" class="form-control" value="<?php echo $unitrumah['harga_rum'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="pekerja_id">Pekerja</label>
                                        <select name="pekerja_id" class="form-control" readonly>
                                        <option value="">- Pilih Pekerja -</option>
                                            <?php                                
                                            foreach ($data_pek as $row)
                                            {
                                                if ($row->id_pek == $unitrumah['pekerja_id']){
                                                    echo "<option value='".$row->id_pek."' selected='selected'>".$row->nama_pek."</option>";
                                                }else{
                                                    echo "<option value='".$row->id_pek."'>".$row->nama_pek."</option>";
                                                }
                                            }
                                            echo"</select>" ?>
                                    </div>
                                    <div class="col col-md-4">
                                        <label for="status_pekerjaan">Status Pekerjaan</label>
                                        <select name="status_pekerjaan" class="form-control" required>
                                            <?php
                                            if ($unitrumah['status_pekerjaan'] == 'Standar'){
                                                print('<option value="Standar" selected="selected">Standar</option>');
                                            }else{
                                                print('<option value="Standar">Standar</option>');
                                            }
                                            if ($unitrumah['status_pekerjaan'] == 'Perluasan/Penambahan'){
                                                print('<option value="Perluasan/Penambahan" selected="selected">Perluasan/Penambahan</option>');
                                            }else{
                                                print('<option value="Perluasan/Penambahan">Perluasan/Penambahan</option>');
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col col-md-4">
                                        <label for="status_progress">Status Progress</label>
                                        <select name="status_progress" id="status_progress" class="form-control" required>
                                            <?php
                                            if ($unitrumah['status_progress'] == 'Belum_Dibangun'){
                                                print('<option value="Belum_Dibangun" selected="selected">Belum Dibangun</option>');
                                            }else{
                                                print('<option value="Belum_Dibangun">Belum Dibangun</option>');
                                            }
                                            if ($unitrumah['status_progress'] == 'Progress'){
                                                print('<option value="Progress" selected="selected">Progress</option>');
                                            }else{
                                                print('<option value="Progress">Progress</option>');
                                            }
                                            if ($unitrumah['status_progress'] == 'Selesai'){
                                                print('<option value="Selesai" selected="selected">Selesai</option>');
                                            }else{
                                                print('<option value="Selesai">Selesai</option>');
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-12">
                                        <label for="status_beli">Status Beli</label>
                                        <select name="status_beli" class="form-control" required>
                                            <?php
                                            if ($unitrumah['status_beli'] == 'Stock'){
                                                print('<option value="Stock" selected="selected">Stock</option>');
                                            }else{
                                                print('<option value="Stock">Stock</option>');
                                            }
                                            if ($unitrumah['status_beli'] == 'Booking'){
                                                print('<option value="Booking" selected="selected">Booking</option>');
                                            }else{
                                                print('<option value="Booking">Booking</option>');
                                            }
                                            if ($unitrumah['status_beli'] == 'Terjual'){
                                                print('<option value="Terjual" selected="selected">Terjual</option>');
                                            }else{
                                                print('<option value="Terjual">Terjual</option>');
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4" id="mulai_bangun">
                                        <label for="mulai_bangun">Mulai Bangun</label>
                                        <input type="date" id="mulai_bangun" name="mulai_bangun" class="form-control" value="<?php echo $unitrumah['mulai_bangun'] ?>">
                                    </div>
                                    <div class="col col-md-4" id="selesai_bangun">
                                        <label for="selesai_bangun">Selesai Bangun</label>
                                        <input type="date" id="selesai_bangun" name="selesai_bangun" class="form-control" value="<?php echo $unitrumah['selesai_bangun'] ?>">
                                    </div>
                                    <div class="col col-md-4" id="tst_kunci">
                                        <label for="tst_kunci">Serah Terima Kunci</label>
                                        <input type="date" id="tst_kunci" name="tst_kunci" class="form-control" value="<?php echo $unitrumah['tst_kunci'] ?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="marketing_id">Marketing</label>
                                        <select name="marketing_id" class="form-control" required>
                                        <option value="">- Pilih Marketing -</option>
                                            <?php                                
                                            foreach ($data_marketing as $row)
                                            {
                                                if ($row->id_kar == $unitrumah['marketing_id']){
                                                    echo "<option value='".$row->id_kar."' selected='selected'>".$row->nama_kar."</option>";
                                                }else{
                                                    echo "<option value='".$row->id_kar."'>".$row->nama_kar."</option>";
                                                }
                                            }
                                            echo"</select>" ?>
                                    </div>
                                    <div class="col col-md-4">
                                        <label for="pengawas_id">Pengawas</label>
                                        <select name="pengawas_id" class="form-control" required>
                                        <option value="">- Pilih Pengawas -</option>
                                            <?php                                
                                            foreach ($data_pengawas as $row)
                                            {
                                                if ($row->id_kar == $unitrumah['pengawas_id']){
                                                    echo "<option value='".$row->id_kar."' selected='selected'>".$row->nama_kar."</option>";
                                                }else{
                                                    echo "<option value='".$row->id_kar."'>".$row->nama_kar."</option>";
                                                }
                                            }
                                            echo"</select>" ?>
                                    </div>
                                    <div class="col col-md-4">
                                        <label for="arsitek_id">Arsitek</label>
                                        <select name="arsitek_id" class="form-control" required>
                                        <option value="">- Pilih Arsitek -</option>
                                            <?php                                
                                            foreach ($data_arsitek as $row)
                                            {
                                                if ($row->id_kar == $unitrumah['arsitek_id']){
                                                    echo "<option value='".$row->id_kar."' selected='selected'>".$row->nama_kar."</option>";
                                                }else{
                                                    echo "<option value='".$row->id_kar."'>".$row->nama_kar."</option>";
                                                }
                                            }
                                            echo"</select>" ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-12">
                                        <label for="keterangan" class="form-control-label">Keterangan</label>
                                        <textarea name="keterangan" id="keterangan" rows="2" placeholder="Keterangan" class="form-control"><?php echo $unitrumah['keterangan'] ?></textarea>
                                    </div>
                                </div>
                                <div class="float-left">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update</button>
                                </div>
                                <div class="float-right">
                                    <a class="btn btn-warning" href="<?php echo base_url ('dataunitrumah') ?>">
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

<script src="<?php echo base_url().'assets/dist/js/jquery.chained.min.js'?>"></script>
<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        $("#blok_id1").chained("#proyek_id");
    });
</script>