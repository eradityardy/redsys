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
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-teal">
                                <div class="inner">
                                    <h3><?php echo $count_proyek; ?></h3>
                                    <p>Jumlah Proyek</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-home"></i>
                                </div>
                                <a href="<?php echo base_url('dataproyek'); ?>" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3><?php echo $count_unitrumah; ?></h3>
                                    <p>Jumlah Unit Rumah</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-home"></i>
                                </div>
                                <a href="<?php echo base_url('dataunitrumah'); ?>" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3><?php echo $count_pekerja; ?></h3>
                                    <p>Jumlah Pekerja</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <a href="<?php echo base_url('datapekerja'); ?>" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-purple">
                                <div class="inner">
                                    <h3><?php echo $count_karyawan; ?></h3>
                                    <p>Jumlah Karyawan</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <a href="<?php echo base_url('datakaryawan'); ?>" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="<?php echo base_url('assets/dist/img/profile/' . $users['image']); ?>" alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center"><?php echo $users['fullname']; ?></h3>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Tgl Register</b> <a class="float-right"><?php echo format_indo($users['usersdate_created']); ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Level</b> <a class="float-right"><?php echo ucfirst($users['role']); ?></a>
                                </li>
                            </ul>
                            <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#edit-profile"><b>Ubah Profile</b></button>
                            <button type="button" class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#edit-pass"><b>Ubah Password</b></button>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->

                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">List User</a></li>
                                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">List Karyawan</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" id="table-id" style="font-size:14px;">
                                            <thead>
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>Username</th>
                                                <th>Role</th>
                                                <th>Tanggal Buat</th>
                                                <th>Status</th>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                <?php foreach ($list_user as $lu) : ?>
                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td><?php echo $lu['fullname']; ?></td>
                                                        <td><?php echo $lu['username']; ?></td>
                                                        <td><?php echo $lu['role']; ?></td>
                                                        <td><?php echo format_indo($lu['usersdate_created']); ?></td>
                                                        <?php if ($lu['is_active'] == 1) : ?>
                                                            <td>Aktif</td>
                                                        <?php else : ?>
                                                            <td>Tidak Aktif</td>
                                                        <?php endif; ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane" id="timeline">
                                    <div class="table-responsive">
                                        <table id="id-table" class="table table-bordered table-hover" style="font-size:13px;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Lengkap</th>
                                                    <th>Bagian</th>
                                                    <th>Alamat</th>
                                                    <th>Nomor HP</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                <?php foreach ($list_karyawan as $p) : ?>
                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td><?php echo $p['nama_kar']; ?></td>
                                                        <td><?php echo $p['nama_bag']; ?></td>
                                                        <td><?php echo $p['alamat']; ?></td>
                                                        <td><?php echo $p['hp_no']; ?></td>
                                                        <td><?php echo $p['keterangan']; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="edit-profile">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Profile</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart('dashboard/index'); ?>
                <div class="form-group row">
                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <input type="hidden" name="id_users" value="<?php echo $users['username']; ?>">
                        <input type="text" class="form-control" id="username" value="<?php echo $users['username']; ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="fullname" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $users['fullname']; ?>">
                    </div>
                </div>
                <button type="button" class="btn btn-default float-right ml-1" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary float-right">Simpan Perubahan</button>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="edit-pass">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ubah Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('dashboard/ubah_password'); ?>" method="post">
                    <div class="form-group">
                        <label for="current_password">Password Lama</label>
                        <input type="password" class="form-control" id="current_password" name="current_password">
                    </div>
                    <div class="form-group">
                        <label for="new_password1">Password Baru</label>
                        <input type="password" class="form-control" id="new_password1" name="new_password1">
                    </div>
                    <div class="form-group">
                        <label for="new_password2">Ulang Password Baru</label>
                        <input type="password" class="form-control" id="new_password2" name="new_password2" placeholder="Ketik ulang password baru">
                    </div>
                    <button type="button" class="btn btn-default float-right ml-1" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary float-right">Simpan Perubahan</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>