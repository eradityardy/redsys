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
                                <div class="card-title"><strong>Tambah Opname Progress</strong></div>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo base_url() ?>opnameprogress/simpanprogress" method="post" class="form-horizontal">
                                    <div class="row form-group">
                                        <div class="col col-md-6">
                                            <label for="tgl_progress">Tanggal Pengerjaan</label>
                                            <input type="date" id="tgl_progress" name="tgl_progress" class="form-control" required>
                                        </div>
                                        <div class="col col-md-6">
                                            <label for="unit_id1">Unit Rumah</label>
                                            <select name="unit_id1" id="unit_id1" class="form-control" required>
                                                <option value="">- Pilih Unit Rumah -</option>
                                                <?php                                
                                                foreach ($data_unit as $row)
                                                {  
                                                    printf("<option value='%s'>%s</option>",$row->unit_id,$row->alamat);
                                                }
                                                echo"</select>" ?>
                                                <input type="hidden" name="unit_id" id="unit_id" value="">
                                        </div>
                                    </div>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Pekerjaan</th>
                                                <th>Persentase</th>
                                                <th>Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select name="pekerjaan_id1" id="pekerjaan_id1" class="form-control" required>
                                                        <option value="">- Pilih Pekerjaan -</option>
                                                        <?php                                
                                                        foreach ($data_pekerjaan as $row)
                                                        {  
                                                            printf("<option value='%s|%s|%s' class='%s'>%s</option>",$row->pekerjaan_id,$row->std_harga,$row->id_rpbu,$row->unit_id,$row->pekerjaan);
                                                        }
                                                        echo"</select>" ?>
                                                    <input type="hidden" id="pekerjaan_id" name="pekerjaan_id" class="form-control" value="">
                                                    <input type="hidden" name="rpbu_id" id="rpbu_id" value="">
                                                </td>
                                                <td>
                                                    <input type="number" id="persentase" name="persentase" class="form-control" min="0" max="100" required>
                                                </td>
                                                <td>
                                                    <input type="number" id="price" name="price" class="form-control" Readonly>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="form-group">
                                        <div class="float-right">
                                            <a class="btn btn-warning float-right" href="<?php echo base_url() ?>opnameprogress">
                                                Kembali
                                            </a>
                                        </div>
                                        <div class="float-left">
                                            <input type="submit" name="simpan" class="btn btn-primary" value="Simpan">
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
            var idval = arval[0];
            $("#unit_id").val(idval);
        });

        $("#pekerjaan_id1").change(function(){
            var dtval = this.value;
            var arval = dtval.split('|');
            var idval = arval[0];
            var axval = arval[1];
            var ioval = arval[2];
            $("#pekerjaan_id").val(idval);
            $("#price").val(axval);
            $("#rpbu_id").val(ioval);
        });

        $("#persentase").change(function()
        { 
            var nof = this.value;
            if (nof > 99){
                alert("Progress tidak boleh melebihi dari 99%");
            }
        });

        $("#pekerjaan_id1").chained("#unit_id1");
    });
</script>