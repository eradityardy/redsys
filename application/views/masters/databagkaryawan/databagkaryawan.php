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
                            <h3 class="card-title">Data Bagian Karyawan</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class=" table table-bordered table-hover" id="table-id" style="font-size:15px;">
                                    <thead>
                                        <th>#</th>
                                        <th>Bagian Karyawan</th>
                                        <th>keterangan</th>
                                        <th>Edit</th>
                                        <th>Hapus</th>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($bagkaryawan as $bk) : ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $bk['nama_bag']; ?></td>
                                                <td><?php echo $bk['keterangan']; ?></td>
                                                <td align="center"><button type="button" class="tombol-edit btn btn-primary btn-sm" data-id="<?php echo $bk['id_bag']; ?>" data-toggle="modal" data-target="#edit-jab"><i class="fas fa-edit"></button></td>
                                                <td align="center"><a href="<?php echo base_url('databagkaryawan/hapusbagkaryawan/' . $bk['id_bag']); ?>" class="tombol-hapus btn btn-sm btn-danger"><i class="fas fa-trash"></i></a></td>
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
                            <h3 class="card-title">Tambah Bagian
                        </div>
                        <div class="card-body">
                            <form role="form" action="<?php echo base_url('databagkaryawan'); ?>" method="post">
                                <div class="form-group">
                                    <label for="nama_bag">Bagian</label>
                                    <input type="text" class="form-control" id="nama_bag" name="nama_bag" required>
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
                <h4 class="modal-title">Edit Bagian</h4>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <form action="<?php echo base_url('databagkaryawan/proses_edit_bagkaryawan'); ?>" method="post" id="form_id">
                        <div class="form-group">
                            <label for="nama_bag">Nama Bagian</label>
                            <input type="hidden" name="id_bag" id="id_bag1">
                            <input type="text" class="form-control" name="nama_bag" id="nama_bag1">
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
        const id_bag = $(this).data('id');
        $.ajax({
            url: '<?php echo base_url('databagkaryawan/editbagkaryawan'); ?>',
            // id kiri data yg dikirimkan, yang kanan isi datanya
            data: {
                id_bag: id_bag
            },
            method: 'post',
            dataType: 'json',
            success: function(data) {
                $('#id_bag1').val(data.id_bag);
                $('#nama_bag1').val(data.nama_bag);
                $('#keterangan1').val(data.keterangan);
            }
        });
    });
</script>