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
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title"><strong>Tambah Booking Rumah</strong></div>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo base_url() ?>bookingrumah/updatebooking" method="post" class="form-horizontal">
                                    <div class="row form-group">
                                        <input type="hidden" name="id_booking" value="<?php echo $id_booking ?>">
                                        <div class="col col-md-6">
                                            <label for="bank_id">Bank</label>
                                            <select name="bank_id" class="form-control" required>
                                                <option value="">- Pilih Bank -</option>
                                                <?php                                
                                                foreach ($data_bank as $row)
                                                {
                                                    if ($row->id_bank == $bank_id){
                                                        echo "<option value='".$row->id_bank."' selected='selected'>".$row->nama_bank."</option>";
                                                    }else{
                                                        echo "<option value='".$row->id_bank."'>".$row->nama_bank."</option>";
                                                    }
                                                }
                                                echo"</select>" ?>
                                        </div>
                                        <div class="col col-md-6">
                                            <label for="proyek_id">Proyek</label>
                                            <select name="project_id" id="proyek_id" class="form-control" required>
                                                <option value="">- Pilih Proyek -</option>
                                                <?php                                
                                                foreach ($data_pro as $row)
                                                {
                                                    if ($row->id_pro == $project_id){
                                                        echo "<option value='".$row->id_pro."' selected='selected'>".$row->nama_pro."</option>";
                                                    }else{
                                                        echo "<option value='".$row->id_pro."'>".$row->nama_pro."</option>";
                                                    }
                                                }
                                                echo"</select>" ?>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-6">
                                            <label for="unit_id1">Unit Rumah</label>
                                            <select name="unit_id1" id="unit_id1" class="form-control" required>
                                                <option value="">- Pilih Unit Rumah -</option>
                                                <?php                                
                                                foreach ($data_unit as $row)
                                                {  
                                                    printf("<option value='%s|%s|%s' class='%s'>%s</option>",$row->id_unit,$row->customer_id,$row->nama_cus,$row->proyek_id,$row->alamat);
                                                }
                                            echo"</select>" ?>
                                            <input type="hidden" name="unitrumah_id" id="unit_id" value="<?php echo $unitrumah_id ?>">
                                        </div>
                                        <div class="col col-md-6">
                                            <label for="customer_id_nama">Customer</label>
                                            <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer_id ?>">
                                            <input type="text" name="customer_id_nama" id="customer_id_nama" class="form-control" value="<?php echo $nama_cus ?> " readonly>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label for="tgl_berkaskebank">Serah Berkas ke Bank</label>
                                            <input type="date" id="tgl_berkaskebank" name="tgl_berkaskebank" class="form-control" value="<?php echo $tgl_berkaskebank ?>">
                                        </div>
                                        <div class="col col-md-4">
                                            <label for="tgl_akad">Akad</label>
                                            <input type="date" id="tgl_akad" name="tgl_akad" class="form-control" value="<?php echo $tgl_akad ?>">
                                        </div>
                                        <div class="col col-md-4">
                                            <label for="tgl_berkastolak">Berkas Ditolak</label>
                                            <input type="date" id="tgl_berkastolak" name="tgl_berkastolak" class="form-control" value="<?php echo $tgl_berkastolak ?>">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-12">
                                            <label for="alasan_tolak" class="form-control-label">Alasan Ditolak</label>
                                            <textarea name="alasan_tolak" id="alasan_tolak" rows="2" class="form-control" value="<?php echo $alasan_tolak ?>"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="float-right">
                                            <a class="btn btn-warning float-right" href="<?php echo base_url() ?>bookingrumah">
                                                Kembali
                                            </a>
                                        </div>
                                        <div class="float-left">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="<?php echo base_url().'assets/dist/js/jquery.chained.min.js'?>"></script>
<script type="text/javascript" language="javascript">
    $(function(){
        $("#unit_id1").change(function(){
            var dtval = this.value;
            var arval = dtval.split('|');
            var adval = arval[0];
            var lsval = arval[1];
            var bdval = arval[2];
            $("#unit_id").val(adval);
            $("#customer_id").val(lsval);
            $("#customer_id_nama").val(bdval);
        });

        $("#unit_id1").chained("#proyek_id");
    });
</script>