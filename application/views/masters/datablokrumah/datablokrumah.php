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
                <div class="card-header">
                    <div class="float-left">
                        <div class="card-title"><strong>Data Blok Rumah</strong></div>
                    </div>
                    <div class="float-right">
                        <a type="button" href="<?php echo base_url('datablokrumah/exportexcel'); ?>" class="btn btn-sm bg-maroon">
                            <i class="fas fa-file-excel"></i> Download Excel
                        </a>
                        <button type="button" class="btn btn-sm bg-purple" data-toggle="modal" data-target="#modal-sm">
                            <i class="fas fa-file-excel"></i> Upload Excel
                        </button>
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-lg">
                            <i class="fas fa-plus"></i> Tambah Blok Rumah
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-id" class="table table-bordered table-striped" style="font-size:15px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Proyek</th>
                                    <th>Type Rumah</th>
                                    <th>Nama Blok</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($blokrumah as $c) : ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $c['nama_pro']; ?></td>
                                        <td><?php echo $c['nama_type']; ?></td>
                                        <td><?php echo $c['nama_blok']; ?></td>
                                        <td><?php echo $c['status']; ?></td>
                                        <td><?php echo $c['keterangan']; ?></td>
                                        <td>
                                            <a href="<?php echo base_url('datablokrumah/editblokrumah/' . $c['id_blok']); ?>" class="tombol-edit btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                            <a href="<?php echo base_url('datablokrumah/hapusblokrumah/' . $c['id_blok']); ?>" class="tombol-hapus btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Tambah Blok Rumah</strong></h5>
            </div>
            <div class="modal-body">
                <form role="form" action="<?php echo base_url('datablokrumah'); ?>" method="post" class="form-horizontal">
                    <div class="row form-group">
                        <div class="col col-md-6">
                            <label for="proyek_id">Proyek</label>
                            <select name="proyek_id" class="form-control" required>
                                <option value="">- Pilih Proyek -</option>
                                <?php                                
                                foreach ($data_pro as $row) {  
                                    echo "<option value='".$row->id_pro."'>".$row->nama_pro."</option>";
                                    }
                                    echo"</select>"
                                ?>
                        </div>
                        <div class="col col-md-6">
                            <label for="type_id">Type Rumah</label>
                            <select name="type_id" class="form-control" required>
                                <option value="">- Pilih Type -</option>
                                <?php                                
                                foreach ($data_type as $row) {  
                                    echo "<option value='".$row->id_type."'>".$row->nama_type."</option>";
                                    }
                                    echo"</select>"
                                ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-7">
                            <label for="nama_blok">Nama Blok</label>
                            <input type="text" id="nama_blok" name="nama_blok" class="form-control" required>
                        </div>
                        <div class="col col-md-5">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="">- Pilih Status -</option>
                                <option value="Subkon">Subkon</option>
                                <option value="Kontraktor">Kontraktor</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-12">
                            <label for="keterangan" class="form-control-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="float-left">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    <div class="float-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-sm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Upload Excel Data Blok Rumah</strong></h5>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url() ?>index.php/datablokrumah/importexcel" enctype="multipart/form-data">
                    <div class="row form-group">
                        <div class="col col-md-12">
                            <label for="userfile" class="form-control-label">1. Silahkan Download template dokumen Excel terlebih dahulu untuk melihat struktur tabel yang benar untuk diupload.</label>
                            <a href="<?php echo base_url().'index.php/datablokrumah/downloadtemplate' ?>">Download Template Data Blok Rumah</a>
                            <br> <br>
                            <label for="userfile" class="form-control-label">2. Selanjutnya Upload dokumen Excel Data Blok Rumah yang sudah disesuaikan dengan struktur tabel template yang sudah di Download diatas.</label> <br>
                            <input type="file" name="userfile" accept=".xlsx">
                        </div>
                    </div>
                    <div class="float-left">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                    <div class="float-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>