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
                        <div class="card-title"><strong>Data Customer</strong></div>
                    </div>
                    <div class="float-right">
                        <a type="button" href="<?php echo base_url('datacustomer/exportexcel'); ?>" class="btn btn-sm bg-maroon">
                            <i class="fas fa-file-excel"></i> Download Excel
                        </a>
                        <button type="button" class="btn btn-sm bg-purple" data-toggle="modal" data-target="#modal-sm">
                            <i class="fas fa-file-excel"></i> Upload Excel
                        </button>
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-lg">
                            <i class="fas fa-plus"></i> Tambah Customer
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
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>No KTP</th>
                                    <th>No NPWP</th>
                                    <th>No HP</th>
                                    <th>Tempat Bekerja</th>
                                    <th>Keterangan</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($customer as $c) : ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $c['nama_cus']; ?></td>
                                        <td><?php echo $c['alamat']; ?></td>
                                        <td><?php echo $c['no_ktp']; ?></td>
                                        <td><?php echo $c['no_npwp']; ?></td>
                                        <td><?php echo $c['hp_no']; ?></td>
                                        <td><?php echo $c['tmpt_kerja']; ?></td>
                                        <td><?php echo $c['keterangan']; ?></td>
                                        <td align="center">
                                            <div class="btn-group-vertical">
                                                <a href="<?php echo base_url('datacustomer/lihatcustomer/' . $c['id_cus']); ?>" class="btn btn-sm btn-warning"><i class="fas fa-eye"></i></a>
                                                <a href="<?php echo base_url('datacustomer/editcustomer/' . $c['id_cus']); ?>" class="tombol-edit btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
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
                <h5 class="modal-title"><strong>Tambah Customer</strong></h5>
            </div>
            <div class="modal-body">
                <form role="form" action="<?php echo base_url('datacustomer'); ?>" method="post" class="form-horizontal">
                    <div class="row form-group">
                        <div class="col col-md-6">
                            <label for="nama_cus">Nama</label>
                            <input type="text" id="nama_cus" name="nama_cus" class="form-control" required>
                        </div>
                        <div class="col col-md-3">
                            <label for="hp_no">Nomor HP</label>
                            <input type="number" id="hp_no" name="hp_no" class="form-control" required>
                        </div>
                        <div class="col col-md-3">
                            <label for="telp_no">Nomor Telp</label>
                            <input type="number" id="telp_no" name="telp_no" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-4">
                            <label for="no_ktp">Nomor KTP</label>
                            <input type="number" id="no_ktp" name="no_ktp" class="form-control" required>
                        </div>
                        <div class="col col-md-4">
                            <label for="no_npwp">Nomor NPWP</label>
                            <input type="number" id="no_npwp" name="no_npwp" class="form-control" required>
                        </div>
                        <div class="col col-md-4">
                            <label for="bank_id">Bank Pelaksana</label>
                            <select name="bank_id" class="form-control" required>
                                <option value="">- Pilih Bank -</option>
                                <?php                                
                                foreach ($data_bank as $row) {  
                                    echo "<option value='".$row->id_bank."'>".$row->nama_bank."</option>";
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
                                foreach ($data_mark as $row) {  
                                    echo "<option value='".$row->id_kar."'>".$row->nama_kar."</option>";
                                    }
                            echo"</select>" ?>
                        </div>
                        <div class="col col-md-4">
                            <label for="unitrumah_id">Unit Rumah</label>
                            <select name="unitrumah_id" class="form-control" required>
                                <option value="">- Pilih Rumah -</option>
                                <?php                                
                                foreach ($data_unit as $row) {  
                                    echo "<option value='".$row->id_unit."'>".$row->alamat."</option>";
                                    }
                            echo"</select>" ?>
                        </div>
                        <div class="col col-md-4">
                            <label for="tmpt_kerja">Tempat Bekerja</label>
                            <input type="text" id="tmpt_kerja" name="tmpt_kerja" class="form-control" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-6">
                            <label for="alamat_kerja" class="form-control-label">Alamat Kantor</label>
                            <textarea name="alamat_kerja" id="alamat_kerja" rows="2" class="form-control"></textarea>
                        </div>
                        <div class="col col-md-6">
                            <label for="alamat" class="form-control-label">Alamat Rumah</label>
                            <textarea name="alamat" id="alamat" rows="2" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-6">
                            <label for="nama_pasangan">Nama Pasangan</label>
                            <input type="text" id="nama_pasangan" name="nama_pasangan" class="form-control" required>
                        </div>
                        <div class="col col-md-6">
                            <label for="hp_no_pasangan">Nomor HP Pasangan</label>
                            <input type="number" id="hp_no_pasangan" name="hp_no_pasangan" class="form-control" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-6">
                            <label for="no_ktp_pasangan">Nomor KTP Pasangan</label>
                            <input type="number" id="no_ktp_pasangan" name="no_ktp_pasangan" class="form-control" required>
                        </div>
                        <div class="col col-md-6">
                            <label for="no_kk">Nomor Kartu Keluarga</label>
                            <input type="text" id="no_kk" name="no_kk" class="form-control" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-12">
                            <label for="keterangan" class="form-control-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" rows="2" class="form-control"></textarea>
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
                <h5 class="modal-title"><strong>Upload Excel Data Customer</strong></h5>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url() ?>index.php/datacustomer/importexcel" enctype="multipart/form-data">
                    <div class="row form-group">
                        <div class="col col-md-12">
                            <label for="userfile" class="form-control-label">1. Silahkan Download template dokumen Excel terlebih dahulu untuk melihat struktur tabel yang benar untuk diupload.</label>
                            <a href="<?php echo base_url().'index.php/datacustomer/downloadtemplate' ?>">Download Template Data Customer</a>
                            <br> <br>
                            <label for="userfile" class="form-control-label">2. Selanjutnya Upload dokumen Excel Data Customer yang sudah disesuaikan dengan struktur tabel template yang sudah di Download diatas.</label> <br>
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