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
                        <div class="card-title"><strong>Data Unit Rumah</strong></div>
                    </div>
                    <div class="float-right">
                        <a type="button" href="<?php echo base_url('dataunitrumah/exportexcel'); ?>" class="btn btn-sm bg-maroon">
                            <i class="fas fa-file-excel"></i> Download Excel
                        </a>
                        <button type="button" class="btn btn-sm bg-purple" data-toggle="modal" data-target="#modal-sm">
                            <i class="fas fa-file-excel"></i> Upload Excel
                        </button>
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-lg">
                            <i class="fas fa-plus"></i> Tambah Unit Rumah
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
                                    <th>Type</th>
                                    <th>Blok</th>
                                    <th>Alamat</th>
                                    <th>Status Pekerjaan</th>
                                    <th>Status Progress</th>
                                    <th>Status Pembelian</th>
                                    <th>Pekerja</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($unitrumah as $u) : ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $u['nama_pro']; ?></td>
                                        <td><?php echo $u['nama_type']; ?></td>
                                        <td><?php echo $u['nama_blok']; ?></td>
                                        <td><?php echo $u['alamat']; ?></td>
                                        <td><?php echo $u['status_pekerjaan']; ?></td>
                                        <td><?php echo $u['status_progress']; ?></td>
                                        <td><?php echo $u['status_beli']; ?></td>
                                        <td><?php echo $u['nama_pek']; ?></td>
                                        <td align="center">
                                            <div class="btn-group-vertical">
                                                <a href="<?php echo base_url('dataunitrumah/lihatunitrumah/' . $u['id_unit']); ?>" class="btn btn-sm btn-warning"><i class="fas fa-eye"></i></a>
                                                <a href="<?php echo base_url('dataunitrumah/editunitrumah/' . $u['id_unit']); ?>" class="tombol-edit btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                                <a href="<?php echo base_url('dataunitrumah/hapusunitrumah/' . $u['id_unit']); ?>" class="tombol-hapus btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
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
                <h5 class="modal-title"><strong>Tambah Unit Rumah</strong></h5>
            </div>
            <div class="modal-body">
                <form role="form" action="<?php echo base_url('dataunitrumah'); ?>" method="post" class="form-horizontal">
                    <div class="row form-group">
                        <div class="col col-md-6">
                            <label for="proyek_id">Proyek</label>
                            <select name="proyek_id" id="proyek_id" class="form-control" required>
                                <option value="">- Pilih Proyek -</option>
                                <?php                                
                                foreach ($data_pro as $row) {  
                                    echo "<option value='".$row->id_pro."'>".$row->nama_pro."</option>";
                                    }
                                    echo"</select>"
                                ?>
                        </div>
                        <div class="col col-md-6">
                            <label for="blok_id1">Blok Rumah</label>
                            <select name="blok_id1" id="blok_id1" class="form-control" required>
                                <option value="">- Pilih Blok Rumah -</option>
                                <?php                                
                                foreach ($data_blok as $row)
                                {  
                                    printf("<option value='%s|%s|%s|%s|%s|%s' class='%s'>%s</option>",$row->id_blok,$row->type_id,$row->luas_tanah,$row->luas_bangunan,$row->harga_tyrum,$row->status,$row->proyek_id,$row->nama_blok);
                                }
                                echo"</select>" ?>
                            <input type="hidden" id="blok_id" name="blok_id" value="">
                            <input type="hidden" id="type_id" name="type_id" value="">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-12">
                            <label for="alamat" class="form-control-label">Alamat</label>
                            <textarea name="alamat" id="alamat" rows="2" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="luas_bangunan">Luas Bangunan</label>
                            <input type="number" id="luas_bangunan" name="luas_bangunan" class="form-control" readonly>
                        </div>
                        <div class="col col-md-3">
                            <label for="luas_tanah">Luas Tanah</label>
                            <input type="number" id="luas_tanah" name="luas_tanah" class="form-control" readonly>
                        </div>
                        <div class="col col-md-3">
                            <label for="harga_rum">Harga</label>
                            <input type="number" id="harga_rum" name="harga_rum" class="form-control" readonly>
                        </div>
                        
                        <div class="col col-md-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="">- Pilih Status -</option>
                                <option value="Subkon">Subkon</option>
                                <option value="Kontraktor">Kontraktor</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-4">
                            <label for="pekerja_id1">Pekerja</label>
                            <select name="pekerja_id1" id="pekerja_id1" class="form-control" required>
                                <option value="">- Pilih Pekerja -</option>
                                <?php                                
                                foreach ($data_pek as $row)
                                {  
                                    printf("<option value='%s' class='%s'>%s</option>",$row->id_pek,$row->status,$row->nama_pek);
                                }
                                echo"</select>" ?>
                            <input type="hidden" id="pekerja_id" name="pekerja_id" value="">
                        </div>
                        <div class="col col-md-4">
                            <label for="status_pekerjaan">Status Pekerjaan</label>
                            <select name="status_pekerjaan" class="form-control" required>
                                <option value="">- Pilih Status Pekerjaan -</option>
                                <option value="Standar">Standar</option>
                                <option value="Perluasan/Penambahan">Perluasan/Penambahan</option>
                            </select>
                        </div>
                        <div class="col col-md-4">
                            <label for="status_progress">Status Progress</label>
                            <select name="status_progress" id="status_progress" class="form-control" required>
                                <option value="">- Pilih Status Progress -</option>
                                <option value="Belum_Dibangun">Belum Dibangun</option>
                                <option value="Progress">Progress</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-12">
                            <label for="status_beli">Status Beli</label>
                            <select name="status_beli" class="form-control" required>
                                <option value="">- Pilih Status Pembelian -</option>
                                <option value="Stock">Stock</option>
                                <option value="Booking">Booking</option>
                                <option value="Terjual">Terjual</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-4" id="mulai_bangun">
                            <label for="mulai_bangun">Mulai Bangun</label>
                            <input type="date" id="mulai_bangun" name="mulai_bangun" class="form-control">
                        </div>
                        <div class="col col-md-4" id="selesai_bangun">
                            <label for="selesai_bangun">Selesai Bangun</label>
                            <input type="date" id="selesai_bangun" name="selesai_bangun" class="form-control">
                        </div>
                        <div class="col col-md-4" id="tst_kunci">
                            <label for="tst_kunci">Serah Terima Kunci</label>
                            <input type="date" id="tst_kunci" name="tst_kunci" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-4">
                            <label for="marketing_id">Marketing</label>
                            <select name="marketing_id" id="marketing_id" class="form-control" required>
                                <option value="">- Pilih Marketing -</option>
                                <?php                                
                                foreach ($data_marketing as $row) {  
                                    echo "<option value='".$row->id_kar."'>".$row->nama_kar."</option>";
                                    }
                                    echo"</select>"
                                ?>
                        </div>
                        <div class="col col-md-4">
                            <label for="pengawas_id">Pengawas</label>
                            <select name="pengawas_id" id="pengawas_id" class="form-control" required>
                                <option value="">- Pilih Pengawas -</option>
                                <?php                                
                                foreach ($data_pengawas as $row) {  
                                    echo "<option value='".$row->id_kar."'>".$row->nama_kar."</option>";
                                    }
                                    echo"</select>"
                                ?>
                        </div>
                        <div class="col col-md-4">
                            <label for="arsitek_id">Arsitek</label>
                            <select name="arsitek_id" id="arsitek_id" class="form-control" required>
                                <option value="">- Pilih Arsitek -</option>
                                <?php                                
                                foreach ($data_arsitek as $row) {  
                                    echo "<option value='".$row->id_kar."'>".$row->nama_kar."</option>";
                                    }
                                    echo"</select>"
                                ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-12">
                            <label for="keterangan" class="form-control-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" rows="2" class="form-control"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
                </form>
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
                <h5 class="modal-title"><strong>Upload Excel Data Unit Rumah</strong></h5>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url() ?>index.php/dataunitrumah/importexcel" enctype="multipart/form-data">
                    <div class="row form-group">
                        <div class="col col-md-12">
                            <label for="userfile" class="form-control-label">1. Silahkan Download template dokumen Excel terlebih dahulu untuk melihat struktur tabel yang benar untuk diupload.</label>
                            <a href="<?php echo base_url().'index.php/dataunitrumah/downloadtemplate' ?>">Download Template Data Unit Rumah</a>
                            <br> <br>
                            <label for="userfile" class="form-control-label">2. Selanjutnya Upload dokumen Excel Data Unit Rumah yang sudah disesuaikan dengan struktur tabel template yang sudah di Download diatas.</label> <br>
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

<script src="<?php echo base_url().'assets/dist/js/jquery.chained.min.js'?>"></script>
<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        $("#mulai_bangun").hide();
        $("#selesai_bangun").hide();
        $("#tst_kunci").hide();

        $("#status_progress").change(function(){
            var supplier = this.value;
            if (supplier == "Progress"){
                $("#mulai_bangun").show();
            }
            else if (supplier == "Selesai"){
                $("#mulai_bangun").show();
                $("#selesai_bangun").show();
                $("#tst_kunci").show();
            }
            else if (supplier == "Belum_Dibangun"){
                $("#mulai_bangun").hide();
                $("#selesai_bangun").hide();
                $("#tst_kunci").hide();
            }
        });

        $("#blok_id1").change(function(){
            var dtval = this.value;
            var arval = dtval.split('|');
            var idval = arval[0];
            var axval = arval[1];
            var ioval = arval[2];
            var olval = arval[3];
            var pnval = arval[4];
            var krval = arval[5];
            $("#blok_id").val(idval);
            $("#type_id").val(axval);
            $("#luas_tanah").val(ioval);
            $("#luas_bangunan").val(olval);
            $("#harga_rum").val(pnval);

            alert("Status : " + krval);
        });

        $("#pekerja_id1").change(function(){
            var dtval = this.value;
            var arval = dtval.split('|');
            var idval = arval[0];
            $("#pekerja_id").val(idval);
        });

        $("#blok_id1").chained("#proyek_id");
    });

    $(function(){
        $("#pekerja_id1").chained("#status");
    });
</script>