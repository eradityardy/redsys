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
                        <div class="card-title"><strong>Data Proyek</strong></div>
                    </div>
                    <div class="float-right">
                        <a type="button" href="<?php echo base_url('dataproyek/exportexcel'); ?>" class="btn btn-sm bg-maroon">
                            <i class="fas fa-file-excel"></i> Download Excel
                        </a>
                        <button type="button" class="btn btn-sm bg-purple" data-toggle="modal" data-target="#modal-sm">
                            <i class="fas fa-file-excel"></i> Upload Excel
                        </button>
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-lg">
                            <i class="fas fa-plus"></i> Tambah Proyek
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
                                    <th>Kode Proyek</th>
                                    <th>Nama Proyek</th>
                                    <th>Lokasi</th>
                                    <th>Pemilik</th>
                                    <th>Anggaran</th>
                                    <th>Mulai</th>
                                    <th>Selesai</th>
                                    <th>Status</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($proyek as $p) : ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $p['kode']; ?></td>
                                        <td><?php echo $p['nama_pro']; ?></td>
                                        <td><?php echo $p['lokasi']; ?></td>
                                        <td><?php echo $p['owner']; ?></td>
                                        <td align="right"><?php echo 'Rp. '.number_format($p['anggaran'],2); ?></td>
                                        <td><?php echo $p['tgl_mulai']; ?></td>
                                        <td><?php echo $p['tgl_selesai']; ?></td>
                                        <td><?php echo $p['status']; ?></td>
                                        <td align="center">
                                            <div class="btn-group-vertical">
                                                <a href="<?php echo base_url('dataproyek/editproyek/' . $p['id_pro']); ?>" class="tombol-edit btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                                <a href="<?php echo base_url('dataproyek/hapusproyek/' . $p['id_pro']); ?>" class="tombol-hapus btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                            </div>
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
                <h5 class="modal-title"><strong>Tambah Proyek</strong></h5>
            </div>
            <div class="modal-body">
                <form role="form" action="<?php echo base_url('dataproyek'); ?>" method="post" class="form-horizontal">
                    <div class="row form-group">
                        <div class="col-md-5">
                            <label for="kode">Kode Proyek</label>
                            <input type="text" class="form-control" id="kode" name="kode" required>
                        </div>
                        <div class="col-md-7">
                            <label for="nama_pro">Nama Proyek</label>
                            <input type="text" class="form-control" id="nama_pro" name="nama_pro" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label for="lokasi">Lokasi Proyek</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                        </div>
                        <div class="col-md-4">
                            <label for="owner">Owner</label>
                            <input type="text" class="form-control" id="owner" name="owner" required>
                        </div>
                        <div class="col col-md-4">
                            <label for="anggaran">Anggaran</label>
                            <input type="number" id="anggaran" name="anggaran" class="form-control" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-6">
                            <label for="tgl_mulai">Tanggal Mulai</label>
                            <input type="date" id="tgl_mulai" name="tgl_mulai" placeholder="Mulai" class="form-control" required>
                        </div>
                        <div class="col col-md-6">
                            <label for="tgl_selesai">Tanggal Selesai</label>
                            <input type="date" id="tgl_selesai" name="tgl_selesai" placeholder="Selesai" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-12">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="">- Pilih Status Proyek -</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Selesai">Selesai</option>
                            </select>
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
                <h5 class="modal-title"><strong>Upload Excel Data Proyek</strong></h5>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url() ?>index.php/dataproyek/importexcel" enctype="multipart/form-data">
                    <div class="row form-group">
                        <div class="col col-md-12">
                            <label for="userfile" class="form-control-label">1. Silahkan Download template dokumen Excel terlebih dahulu untuk melihat struktur tabel yang benar untuk diupload.</label>
                            <a href="<?php echo base_url().'index.php/dataproyek/downloadtemplate' ?>">Download Template Data Proyek</a>
                            <br> <br>
                            <label for="userfile" class="form-control-label">2. Selanjutnya Upload dokumen Excel Data Proyek yang sudah disesuaikan dengan struktur tabel template yang sudah di Download diatas.</label> <br>
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