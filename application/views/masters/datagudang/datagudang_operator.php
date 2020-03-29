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
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title"><strong>Data Gudang</strong></div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class=" table table-bordered table-hover" id="table-id" style="font-size:15px;">
                                    <thead>
                                        <th>#</th>
                                        <th>Gudang</th>
                                        <th>Keterangan</th>
                                        <th>Edit</th>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($gudang as $g) : ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $g['nama_gud']; ?></td>
                                                <td><?php echo $g['keterangan']; ?></td>
                                                <td align="center"><button type="button" class="tombol-edit btn btn-primary btn-sm" data-id="<?php echo $g['id_gud']; ?>" data-toggle="modal" data-target="#edit-jab"><i class="fas fa-edit"></button></td>
                                            </tr>
                                            <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title"><strong>Tambah Gudang</strong></div>
                        </div>
                        <div class="card-body">
                            <form role="form" action="<?php echo base_url('datagudang'); ?>" method="post">
                                <div class="form-group">
                                    <label for="nama_gud">Gudang</label>
                                    <input type="text" class="form-control" id="nama_gud" name="nama_gud" required>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" rows="5" class="form-control"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan Data</button>
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

<div class="modal fade" id="edit-jab">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Gudang</h4>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <form action="<?php echo base_url('datagudang/proses_edit_gudang'); ?>" method="post" id="form_id">
                        <div class="form-group">
                            <label for="nama_gud">Gudang</label>
                            <input type="hidden" name="id_gud" id="id_gud1">
                            <input type="text" class="form-control" name="nama_gud" id="nama_gud1">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan1" rows="5" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary pull-right">Simpan Perubahan</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

<script>
    $('.tombol-edit').on('click', function() {
        const id_gud = $(this).data('id');
        $.ajax({
            url: '<?php echo base_url('datagudang/editgudang'); ?>',
            // id kiri data yg dikirimkan, yang kanan isi datanya
            data: {
                id_gud: id_gud
            },
            method: 'post',
            dataType: 'json',
            success: function(data) {
                $('#id_gud1').val(data.id_gud);
                $('#nama_gud1').val(data.nama_gud);
                $('#keterangan1').val(data.keterangan);
            }
        });
    });
</script>