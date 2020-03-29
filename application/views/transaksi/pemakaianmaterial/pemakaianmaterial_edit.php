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
                                <div class="card-title"><strong>Edit Master Pemakaian</strong></div>
                            </div>
                            <div class="card-body">
                                <form id="form_master" class="form-horizontal">
                                    <div id="tampil_hasil"></div>
                                    <div class="row form-group">
                                        <input type="hidden" name="id_pake" value="<?php echo $id_pake ?>">
                                        <div class="col col-md-4">
                                            <label for="no_pemakaian">No Pemakaian</label>
                                            <input type="text" id="no_pemakaian1" name="no_pemakaian" class="form-control" value="<?php echo $no_pemakaian; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-6">
                                            <label for="tgl_pake">Tanggal Pemakaian</label>
                                            <input type="date" id="tgl_pake" name="tgl_pake" class="form-control" value="<?php echo $tgl_pake ?>" required>
                                        </div>
                                        <div class="col col-md-6">
                                            <label for="unit_id1">Unit Rumah</label>
                                            <select name="unit_id1" id="unit_id1" class="form-control" readonly>
                                                <option value="">- Pilih Unit Rumah -</option>
                                                <?php                                
                                                foreach ($data_unit as $row)
                                                {
                                                    if ($row->id_unit == $unit_id){
                                                        echo "<option value='".$row->unit_id."' selected='selected'>".$row->alamat."</option>";
                                                    }else{
                                                        echo "<option value='".$row->unit_id."'>".$row->alamat."</option>";
                                                    }
                                                }
                                                echo"</select>" ?>
                                                <input type="hidden" name="unit_id" id="unit_id" value="<?php echo $unit_id ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="float-left">
                                            <button id="update" class="btn btn-primary">
                                                Update
                                            </button>
                                        </div>
                                        <div class="float-right">
                                            <a class="btn btn-warning float-right" href="<?php echo base_url() ?>pemakaianmaterial">
                                                Kembali
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12" id="detail_pemakaian">
                <div class="card card-success card-outline">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title"><strong>Detail Pemakaian</strong></div>
                        </div>
                        <div class="card-body">
                            <form id="form_detail" class="form-horizontal">
                                <div id="tampil_hasil_detail"></div>
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label for="material_id1">Material</label>
                                        <select name="material_id1" id="material_id1" class="form-control" required>
                                            <option value="">- Pilih Material -</option>
                                            <?php                                
                                            foreach ($data_material as $row)
                                            {  
                                                printf("<option value='%s'>%s</option>",$row->material_id,$row->nama_brg);
                                            }
                                            echo"</select>" ?>
                                            <input type="hidden" name="material_id" id="material_id" value="">
                                            <input type="hidden" name="no_pemakaian" id="no_pemakaian2" value="<?php echo $no_pemakaian; ?>">
                                    </div>
                                    <div class="col col-md-6">
                                        <label for="stock_id1">Gudang</label>
                                        <select name="stock_id1" id="stock_id1" class="form-control" required>
                                            <option value="">- Pilih Gudang Stock -</option>
                                            <?php                                
                                            foreach ($data_stock as $row)
                                            {  
                                                printf("<option value='%s|%s|%s|%s|%s' class='%s'>%s - %s - %s</option>",$row->id_stomat,$row->satuan,$row->harga,$row->qty_stock,$row->qty_anggaran,$row->material_id,$row->nama_gud,$row->nama_type,$row->nama_brg);
                                            }
                                            echo"</select>" ?>
                                            <input type="hidden" name="stock_id" id="stock_id" value="">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="qty">Qty</label>
                                        <input type="number" id="qty" name="qty" class="form-control" required>
                                    </div>
                                    <div class="col col-md-3">
                                        <label for="satuan">Satuan</label>
                                        <input type="text" id="satuan" name="satuan" class="form-control" readonly>
                                    </div>
                                    <div class="col col-md-3">
                                        <label for="price">Price</label>
                                        <input type="number" id="price" name="price" class="form-control" readonly>
                                    </div>
                                    <div class="col col-md-3">
                                        <label for="tot_price">Total Price</label>
                                        <input type="number" id="tot_price" name="tot_price" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label for="qty_anggaran">Anggaran Material</label>
                                        <input type="number" id="qty_anggaran" name="qty_anggaran" class="form-control" readonly>
                                    </div>
                                    <div class="col col-md-6">
                                        <label for="stock_qty">Stock Material</label>
                                        <input type="number" id="stock_qty" name="stock_qty" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-6"> 
                                        <div class="float-left">
                                            <button id="submitdetail" class="btn btn-success">
                                                Simpan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Material</th>
                                        <th>Anggaran</th>
                                        <th>Quantity</th>
                                        <th>Satuan</th>
                                        <th>Harga</th>
                                        <th>Gudang</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody id="list_material">
                                    <?php
                                        foreach($data_detail->result_array() as $k):
                                            $material_id = $k['material_id'];
                                            $nama_brg = $k['nama_brg'];
                                            $qty_anggaran = $k['qty_anggaran'];
                                            $qty = $k['qty'];
                                            $satuan = $k['satuan'];
                                            $price = $k['price'];
                                            $nama_gud = $k['nama_gud'];
                                    ?>
                                    <tr>
                                        <td><?php echo $nama_brg ?></td>
                                        <td align='right'><?php echo number_format($qty_anggaran,0); ?></td>
                                        <td align='right'><?php echo number_format($qty,0); ?></td>
                                        <td><?php echo $satuan ?></td>
                                        <td align='right'><?php echo 'Rp. '.number_format($price,0); ?></td>
                                        <td><?php echo $nama_gud?></td>
                                        <td>
                                            <a href="<?php echo base_url('index.php/pemakaianmaterial/hapusdetail/'.$id_pake.'/'.$k['id_pakedetail']) ?>" class="tombol-hapus btn btn-danger">
                                                <span class="fa fa-trash"></span> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="<?php echo base_url().'assets/dist/js/jquery.chained.min.js'?>"></script>
<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        //Untuk update Master
        //$("#detail_pemakaian").hide();
        $("#update").click(function(){
            $("#detail_pemakaian").show();
            $.ajax({
                url : "<?php echo base_url(); ?>index.php/Pemakaianmaterial/updatemaster", 
                type: "POST", 
                data: $("#form_master").serialize(),
                success: function(data)
                {
                    $('#tampil_hasil').html(data);
                    document.getElementById('no_pemakaian2').value = document.getElementById('no_pemakaian1').value;
                }
            });
            return false;
        });

        //untuk simpan Detail
        $("#submitdetail").click(function(){
            $.ajax({
                url : "<?php echo base_url(); ?>index.php/Pemakaianmaterial/updatedetail/", 
                type: "POST", 
                data: $("#form_detail").serialize(),
                success: function(data)
                {
                    $('#tampil_hasil_detail').html(data);
                    location.reload(true);
                }
            });
            return false;
        });
        
        $("#unit_id1").change(function(){
            var dtval = this.value;
            var arval = dtval.split('|');
            var idval = arval[0];
            $("#unit_id").val(idval);
        });

        $("#material_id1").change(function(){
            var dtval = this.value;
            var arval = dtval.split('|');
            var idval = arval[0];
            $("#material_id").val(idval);
        });

        $('#qty').keyup(function(){
            //Ambil Nilai
            var qty1 = parseInt($('#qty').val());
            var sisa1 = parseInt($('#anggaran_qty').val());
            var sisa2 = parseInt($('#stock_qty').val());
            var price1 = parseInt($('#price').val());

            //Perhitungan
            var sisamat = sisa1-qty1;
            var sisastok = sisa2-qty1;
            var totpak = qty1*price1;
            $('#anggaran_qty').val(sisamat);
            $('#stock_qty').val(sisastok);
            $('#tot_price').val(totpak);

            if (qty1 > sisa1){
                alert("Jumlah Penggunaan Material tidak boleh melebihi jumlah yang dianggarkan");
            } else if (qty1 > sisa2){
                alert("Jumlah Penggunaan Material tidak boleh melebihi jumlah Stock")
            }
        });

        $('#no_pemakaian1').keyup(function(){
            document.getElementById('no_pemakaian2').value = document.getElementById('no_pemakaian1').value;
        });

        $("#stock_id1").chained("#material_id1");
    });

    $(function(){
        $("#stock_id1").change(function(){
            var akval = this.value;
            var adval = akval.split('|');
            var lsval = adval[0];
            var arval = adval[1];
            var fjval = adval[2];
            var gdval = adval[3];
            var mhval = adval[4];
            $("#stock_id").val(lsval);
            $("#satuan").val(arval);
            $("#price").val(fjval);
            $("#stock_qty").val(gdval);
            $("#qty_anggaran").val(mhval);

            $('#qty').val('');
        });
    });
</script>