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
                        <div class="card-header">
                            <div class="card-title"><strong>Master Pembelian</strong></div>
                        </div>
                        <div class="card-body">
                            <form id="form_master" class="form-horizontal">
                                <div id="tampil_hasil"></div>
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label for="no_faktur">No Faktur</label>
                                        <input type="text" id="no_faktur1" name="no_faktur" placeholder="Nomor Faktur" class="form-control" required>
                                    </div>
                                    <div class="col col-md-4">
                                        <label for="tgl_beli">Tanggal Faktur</label>
                                        <input type="date" id="tgl_beli" name="tgl_beli" class="form-control" required>
                                    </div>
                                    <div class="col col-md-2">
                                        <label for="jatuh_tempo">Lama Kredit</label>
                                        <input type="number" id="jatuh_tempo" name="jatuh_tempo" class="form-control" placeholder="Jumlah Hari Jatuh Tempo Bayar">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label for="gudang_id">Gudang</label>
                                        <select name="gudang_id" id="gudang_id" class="form-control" required>
                                            <option value="">- Pilih Gudang -</option>
                                            <?php                                
                                            foreach ($data_gud as $row) {  
                                                echo "<option value='".$row->id_gud."'>".$row->nama_gud."</option>";
                                                }
                                                echo"</select>"
                                            ?>
                                    </div>
                                    <div class="col col-md-6">
                                        <label for="supplier_id">Supplier</label>
                                        <select name="supplier_id" id="supplier_id" class="form-control" required>
                                            <option value="">- Pilih Supplier -</option>
                                            <?php                                
                                            foreach ($data_sup as $row) {  
                                                echo "<option value='".$row->id."'>".$row->nama."</option>";
                                                }
                                                echo"</select>"
                                            ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-12">
                                        <label for="keterangan" class="form-control-label">Keterangan</label>
                                        <textarea name="keterangan" id="keterangan" rows="2" placeholder="Keterangan" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="float-left">
                                        <button id="submit" class="btn btn-primary">
                                            Simpan
                                        </button>
                                    </div>
                                    <div class="float-right">
                                        <a class="btn btn-warning float-right" href="<?php echo base_url() ?>transaksipembelian">
                                            Kembali
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

                <div class="col-md-12" id="detail_pembelian">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <div class="card-title"><strong>Detail Pembelian</strong></div>
                        </div>
                        <div class="card-body">
                            <form id="form_detail" class="form-horizontal">
                                <div id="tampil_hasil_detail"></div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="material_id1">Material</label>
                                        <select name="material_id1" id="material_id1" class="form-control" required>
                                            <option value="">- Pilih Material -</option>
                                            <?php                                
                                            foreach ($data_mat as $row)
                                            {  
                                                printf("<option value='%s|%s|%s'>%s</option>",$row->id,$row->harga,$row->satuan,$row->nama_brg);
                                            }
                                            echo"</select>" ?>
                                            <input type="hidden" name="material_id" id="material_id" value="">
                                            <input type="hidden" name="no_faktur" id="no_faktur2" value="">
                                            <input type="hidden" name="supplier_id1" id="supplier_id1" value="">
                                    </div>
                                    <div class="col col-md-2">
                                        <label for="qty">Quantity</label>
                                        <input type="number" id="qty" name="qty" class="form-control" min="0" placeholder="Qty" required>
                                    </div>
                                    <div class="col col-md-2">
                                        <label for="qty">Satuan</label>
                                        <input type="text" id="satuan" name="satuan" class="form-control" placeholder="Satuan" Readonly>
                                    </div>
                                    <div class="col col-md-2">
                                        <label for="price">Harga</label>
                                        <input type="number" id="price" name="price" class="form-control" placeholder="Harga" Readonly>
                                    </div>
                                    <div class="col col-md-3">
                                        <label for="stock_id">Total Harga</label>
                                        <input type="number" id="tot_price" name="tot_price" class="form-control" placeholder="Total" Readonly>
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
                            <table class="table table-bordered" id="table_detail">
                                <thead>
                                    <tr>
                                        <th>Material</th>
                                        <th>Quantity</th>
                                        <th>Satuan</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody id="list_material">
                                    
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
<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        //Untuk simpan Master
        $("#detail_pembelian").hide();
        $("#submit").click(function(){
            $("#detail_pembelian").show();
            $.ajax({
                url : "<?php echo base_url(); ?>index.php/Transaksipembelian/simpantransaksi", 
                type: "POST", 
                data: $("#form_master").serialize(),
                success: function(data)
                {
                    $('#tampil_hasil').html(data);
                    document.getElementById('no_faktur2').value = document.getElementById('no_faktur1').value;
                }
            });
            return false;
        });

        $("#no_faktur1").change(function()
        { 
            var nof = this.value;
            var url = "<?php echo base_url(); ?>index.php/Transaksipembelian/CheckFaktur";
            $.post(url,{no_faktur: nof}, function(data, status){
                if (data > 0){
                    alert("No Faktur : " + nof + " sudah ada!");
                }
            });
        });

        //untuk simpan detail
        $("#table_detail").hide();
        $(document).on('click','#submitdetail',function(){
            $("#table_detail").show();
            var gudangId = $("#gudang_id").val();
            $.ajax({
                url : "<?php echo base_url(); ?>index.php/Transaksipembelian/simpandetail/"+gudangId, 
                type: "POST", 
                data: $("#form_detail").serialize(),
                success: function(data)
                {
                    $('#list_material').html(data);
                    $('#material_id1').val('');
                    $('#qty').val('');
                    $('#price').val('');
                    $('#tot_price').val('');
                    $('#satuan').val('');
                }
            });
            return false;
        });

        //untuk load list barang di awal
        $('#list_material').load("<?php echo base_url();?>index.php/Transaksipembelian/tampilkantabel");

        $("#no_faktur1").keyup(function(){
            document.getElementById('no_faktur2').value = document.getElementById('no_faktur1').value;
        });

        $("#material_id1").change(function() {
            var dtval = this.value;
            var arval = dtval.split('|');
            var idval = arval[0];
            var hrval = arval[1];
            var opval = arval[2];
            $("#material_id").val(idval);
            $("#price").val(hrval);
            $("#satuan").val(opval);
        });

        $("#supplier_id").change(function(){
            var supplier = parseInt($('#supplier_id').val());
            $('#supplier_id1').val(supplier);
        });

        $("#qty").keyup(function(){
            var qty1 = parseInt($('#qty').val());
            var price1 = parseInt($('#price').val());

            var tot = qty1*price1;
            $('#tot_price').val(tot);
        });
    });
</script>