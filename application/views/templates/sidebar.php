<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-black elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="<?php echo base_url('assets/'); ?>dist/img/rekasys.jpg" alt="REKASYS Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-bold ml-2">RedSys</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?php echo base_url('dashboard'); ?>" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p class="text">Dashboard</p>
                    </a>
                </li>
                <li class="nav-header">DATA</li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-clone"></i>
                        <p>
                            Master Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url('databank'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> Data Bank
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('dataproyek'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> Data Proyek
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('datapekerjaan'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> Data Pekerjaan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('datamaterial'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> Data Material
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('datapekerja'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> Data Pekerja
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('datacustomer'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> Data Customer
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('datasupplier'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> Data Supplier
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('datakaryawan'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> Data Karyawan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('datagudang'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> Data Gudang
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('datatyperumah'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> Data Type Rumah
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('datablokrumah'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> Data Blok Rumah
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('dataunitrumah'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> Data Unit Rumah
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('rabmaterialbytype'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> RAB Material Type Rumah
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('rabpekerjaanbytype'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> RAB Pekerjaan Type Rumah
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-calendar"></i>
                        <p>
                            Transaksi Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url('transaksipembelian'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> Pembelian Material
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('pemakaianmaterial'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> Pemakaian Material
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('opnameprogress'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> Opname Progress
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('bookingrumah'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> Booking Rumah
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('stockmaterial'); ?>" class="nav-link">
                        <i class="nav-icon fas fa-inbox"></i>
                        <p class="text">Stock Material</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('stockrumah'); ?>" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p class="text">Stock Rumah</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-calendar"></i>
                        <p>
                            Laporan Material
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url('laporanmaterialproyek'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> Laporan Material Proyek
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('laporanmaterialunit'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> Laporan Material Unit Rumah
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">USER</li>
                <li class="nav-item">
                    <a href="<?php echo base_url('users'); ?>" id="tombol-profile" class="nav-link">
                        <i class="nav-icon fas fa-user"></i> Users
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('auth/logout'); ?>" id="tombol-logout" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt text-danger"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>