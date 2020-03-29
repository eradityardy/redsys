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
                                <div class="card-title"><strong>Edit Pengguna</strong></div>
                            </div>
                            <div class="card-body">
                                <?php echo form_open_multipart('users/edituser/' . $user['id_users']); ?>
                                    <div class="row form-group">
                                        <div class="col col-md-6">
                                            <label for="username">Username</label>
                                            <input type="text" id="username" name="username" class="form-control" value="<?php echo $user['username'] ?>" required>
                                        </div>
                                        <div class="col col-md-6">
                                            <label for="fullname">Nama Panjang</label>
                                            <input type="text" id="fullname" name="fullname" class="form-control" value="<?php echo $user['fullname'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-6">
                                            <label for="role">Role</label>
                                            <select name="role" class="form-control" required>
                                                <?php
                                                if ($user['role'] == 'Manager'){
                                                    print('<option value="Manager" selected="selected">Manager</option>');
                                                }else{
                                                    print('<option value="Manager">Manager</option>');
                                                }
                                                if ($user['role'] == 'Supervisor'){
                                                    print('<option value="Supervisor" selected="selected">Supervisor</option>');
                                                }else{
                                                    print('<option value="Supervisor">Supervisor</option>');
                                                }
                                                if ($user['role'] == 'Operator'){
                                                    print('<option value="Operator" selected="selected">Operator</option>');
                                                }else{
                                                    print('<option value="Operator">Operator</option>');
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col col-md-6">
                                        <label for="is_active">Status</label>
                                            <select name="is_active" class="form-control" required>
                                                <?php
                                                if ($user['is_active'] == 1){
                                                    print('<option value="1" selected="selected">Aktif</option>');
                                                }else{
                                                    print('<option value="1">Aktif</option>');
                                                }
                                                if ($user['is_active'] == 2){
                                                    print('<option value="2" selected="selected">Tidak Aktifr</option>');
                                                }else{
                                                    print('<option value="2">Tidak Aktif</option>');
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="float-left">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update</button>
                                    </div>
                                    <div class="float-right">
                                        <a class="btn btn-warning" href="<?php echo base_url ('users') ?>">
                                            Kembali
                                        </a>
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