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
                            <div class="card-title"><strong>Edit Blok Rumah</strong></div>
                        </div>
                        <div class="card-body">
                            <?php echo form_open_multipart('datablokrumah/editblokrumah/' . $blokrumah['id_blok']); ?>
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label for="proyek_id">Proyek</label>
                                        <select name="proyek_id" class="form-control" required>
                                        <option value="">- Pilih Proyek -</option>
                                            <?php                                
                                            foreach ($data_pro as $row)
                                            {
                                                if ($row->id_pro == $blokrumah['proyek_id']){
                                                    echo "<option value='".$row->id_pro."' selected='selected'>".$row->nama_pro."</option>";
                                                }else{
                                                    echo "<option value='".$row->id_pro."'>".$row->nama_pro."</option>";
                                                }
                                            }
                                            echo"</select>" ?>
                                    </div>
                                    <div class="col col-md-6">
                                        <label for="type_id">Type Rumah</label>
                                        <select name="type_id" class="form-control" required>
                                        <option value="">- Pilih Type -</option>
                                            <?php                                
                                            foreach ($data_type as $row)
                                            {
                                                if ($row->id_type == $blokrumah['type_id']){
                                                    echo "<option value='".$row->id_type."' selected='selected'>".$row->nama_type."</option>";
                                                }else{
                                                    echo "<option value='".$row->id_type."'>".$row->nama_type."</option>";
                                                }
                                            }
                                            echo"</select>" ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-7">
                                        <label for="nama_blok">Nama Blok</label>
                                        <input type="text" id="nama_blok" name="nama_blok" class="form-control" value="<?php echo $blokrumah['nama_blok'] ?>" required>
                                    </div>
                                    <div class="col col-md-5">
                                    <label for="status">Status</label>
                                        <select name="status" id="status" class="form-control" required>
                                            <?php
                                            if ($blokrumah['status'] == 'Subkon'){
                                                print('<option value="Subkon" selected="selected">Subkon</option>');
                                            }else{
                                                print('<option value="Subkon">Subkon</option>');
                                            }
                                            if ($blokrumah['status'] == 'Kontraktor'){
                                                print('<option value="Kontraktor" selected="selected">Kontraktor</option>');
                                            }else{
                                                print('<option value="Kontraktor">Kontraktor</option>');
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-12">
                                        <label for="keterangan" class="form-control-label">Keterangan</label>
                                        <textarea name="keterangan" id="keterangan" rows="3" placeholder="Keterangan" class="form-control"><?php echo $blokrumah['keterangan'] ?></textarea>
                                    </div>
                                </div>
                                <div class="float-left">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update</button>
                                </div>
                                <div class="float-right">
                                    <a class="btn btn-warning" href="<?php echo base_url ('datablokrumah') ?>">
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