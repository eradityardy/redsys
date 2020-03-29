<style>
    .dataTables_wrapper {
        font-size: 16px
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo $title; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    </ol>
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
            <div class="card card-primary card-outline">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <div class="card-title"><strong>Detail RAB Pekerjaan</strong> - <i><?php echo $unitrum['alamat'] ?></i></div>
                        </div>
                        <div class="float-right">
                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-lg">
                                <i class="fas fa-plus"></i> Tambah Pekerjaan
                            </button>
                            <a href="<?php echo base_url('index.php/rabpekerjaanbyunit/') ?>" class="btn btn-sm btn-warning">Kembali</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-id" class="table table-bordered table-striped" style="font-size:15px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Pekerjaan</th>
                                        <th>Harga</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($detailrab as $c) : ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $c['pekerjaan']; ?></td>
                                            <td align='right'><?php echo 'Rp. '.number_format($c['price'],0); ?></td>
                                            <td>
                                                <a href="<?php echo base_url('rabpekerjaanbyunit/hapusrab/'.$unit_id.'/'.$c['id']); ?>" class="tombol-hapus btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<div class="modal fade" id="modal-lg">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Tambah RAB Pekerjaan</strong></h5>
            </div>
            <div class="modal-body">
                <form role="form" action="<?php echo base_url('rabpekerjaanbyunit/detailrab/'.$unit_id); ?>" method="post" class="form-horizontal">
                    <div class="row form-group">
                        <div class="col col-md-12">
                            <label for="unit_id1">Unit Rumah</label>
                            <select name="unit_id1" class="form-control" Disabled>
                                <option selected>- Pilih Unit -</option>
                                <?php                                
                                foreach ($data_unit as $row)
                                {  
                                    if ($row->id_unit == $unit_id){
                                        echo "<option value='".$row->id_unit."' selected='selected'>".$row->alamat."</option>";
                                    }else{
                                        echo "<option value='".$row->id_unit."'>".$row->alamat."</option>";
                                    }
                                }
                                echo"</select>" ?>
                                <input type="hidden" name="unit_id" value="<?php echo $unit_id ?>"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-12">
                            <label for="pekerjaan_id1">Pekerjaan</label>
                            <select id="pekerjaan_id1" name="pekerjaan_id1" class="form-control" required>
                                <option value="">- Pilih Pekerjaan -</option>
                                <?php                                
                                foreach ($data_pekerjaan as $row)
                                {  
                                    printf("<option value='%s|%s'>%s</option>",$row->id,$row->std_harga,$row->pekerjaan);
                                }
                                echo"</select>" ?>
                                <input type="hidden" name="pekerjaan_id" id="pekerjaan_id" value=""/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-12">
                            <label for="price">Price</label>
                            <input type="number" id="price" name="price" class="form-control" placeholder="Harga" readonly>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script type="text/javascript">
    $(function(){
        $("#pekerjaan_id1").change(function(){
            var dtval = this.value;
            var arval = dtval.split('|');
            var idval = arval[0];
            var hrval = arval[1];
            $("#pekerjaan_id").val(idval);
            $("#price").val(hrval);
        });
    });
</script>