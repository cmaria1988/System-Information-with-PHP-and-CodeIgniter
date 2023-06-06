<div class="content-wrapper">
    <div class="row page-title-header">
        <div class="col-12">
            <div class="page-header">
                <h4 class="page-title">Penjualan</h4>
            </div>
        </div>
    </div>
    <?php
if(isset($message)){
	echo '<div class="alert alert-danger alert-dismissible">
					  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					  <strong>'.$message[1].'</strong>
						</div>';
}
?>
    <div id='divform'>
        <?php echo form_open('toko/Penjualan/save');?>
        <div class="row form-group">
            <label for="nama" class="col-sm-3 control-label">No Penjualan</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="transaksiid" name="transaksiid" placeholder="No Penjualan"
                    required readonly value='<?php if(isset($dataPenjualan)) echo $dataPenjualan['transaksiid'];?>'>
            </div>
            <div class="col-sm-1"><input type='button' class='btn btn-info btn-sm' value='Cari No Penjualan'
                    id='carinofpb' onclick="carinopenjualan()"></div>
        </div>
        <div class="row form-group">
            <label for="nama" class="col-sm-3 control-label">Pembayaran</label>
            <div class="col-sm-5">
                <select name='pembayaranid' id='pembayaranid' class='form-control'>
                    <option value=""></option>
                    <?php
	foreach($listpembayaran as $pembayaran):
  ?>
                    <option value='<?php echo $pembayaran['pembayaranid'];?>'
                        <?php if(isset($dataPenjualan) && $dataPenjualan['pembayaranid']==$pembayaran['pembayaranid']) echo "selected";?>>
                        <?php echo $pembayaran['pembayaran'];?></option>
                    <?php
	endforeach;
  ?>
                </select>
            </div>
        </div>
        <div class="row form-group">
            <label for="nama" class="col-sm-3 control-label">Tanggal</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="tanggal" name="tanggal" required readonly
                    value='<?php if(isset($dataPenjualan)) echo $dataPenjualan['tanggal'];?>'>
            </div>
        </div>

        <hr>
        <div class='row text-left'>
            <div class='col-sm-3'>
                <select name='produkid' id='produkid' class='form-control'>
                    <option value=""></option>
                    <?php
	foreach($listproduk as $produk):
  ?>
                    <option value='<?php echo $produk['produkid'];?>'><?php echo $produk['nama'];?></option>
                    <?php
	endforeach;
  ?>
                </select>
            </div>
            <div class='col-sm-2'><input type='number' width='10' class='form-control' placeholder='Qty' id='quantity'></div>
            <div class='col-sm-1'><input type='button' class='btn btn-info btn-sm' name='inputbarang' id='inputbarang'
                    value='Input Barang' onclick='inputbarangx()'></div>
        </div>
        <a name='linkdata'></a>
        <table class='table' id='tabeldata'>
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <th>Harga Satuan</th>
                    <th>Sub Total</th>
                    <th>Action</th>
            </thead>
            <tbody>
                <?php
  //print_r($dataDetilfpb);
  if(isset($dataDetilJual)){
  $qtyx = 0;
$grandtotal = 0;
  foreach($dataDetilJual as $detil):
  $grandtotal = $grandtotal + ($detil['hargasat']*$detil['quantity']);
  ?>
                <tr id="listbrg_<?php echo $detil['produkid'];?>">
                    <td><?php echo $detil['produkid'];?><input type="hidden" name="kdbrgjual[]"
                            id="kdbrgjual_<?php echo $detil['produkid'];?>" value="<?php echo $detil['produkid'];?>"
                            readonly></td>
                    <td><?php echo $detil['nama'];?></td>
                    <td><input type="number" width="4" size="4" name="qtyjual[]"
                            id="qtyjual_<?php echo $detil['produkid'];?>" value="<?php echo $detil['quantity'];?>"></td>
                    <td><?php echo $detil['hargasat'];?><input type="hidden" name="hargajual[]"
                            id="hargajual_<?php echo $detil['hargasat'];?>" readonly
                            value="<?php echo $detil['hargasat'];?>"></td>
                    <td align="right"><span id="spantotaljual_<?php echo $detil['produkid'];?>"
                            class="totaljual"><?php echo $detil['hargasat']*$detil['quantity'];?></span></td>
                    <td><a href="#linkdata" onclick=hapuslist('<?php echo $detil['produkid'];?>') alt='hapus'
                            title='hapus'><i class="fas fa-trash"></i></a>&nbsp;&nbsp;<a href="#linkdata"
                            onclick=savelist('<?php echo $detil['produkid'];?>') alt='simpan' title='simpan'><i
                                class="fas fa-save"></i></a>&nbsp;&nbsp;</td>
                </tr>
                <?php
  endforeach;
  }
  ?>
            </tbody>
            <tfoot>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Total</td>
                    <td>&nbsp;</td>
                    <td id='grandtotal' align='right'><?php if(isset($dataPenjualan)) echo $grandtotal;?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </tfoot>
        </table>
        <input type='hidden' id='hidgrandtotal' value='0' name="hidgrandtotal">
    </div>
    <div class="form-group">
        <label for="simpan" class="col-sm-3 control-label"></label>
        <div class="col-sm-5">
            <input type='hidden' id='chidIdpo' name='chidIdpo' readonly>
            <?php
	  if(isset($dataPenjualan)){
		  $transaksiid = $dataPenjualan['transaksiid'];
	  ?>
            <input type="submit" class="btn btn-primary  btn-sm" name="tblubah" id="tblubah" value="Save">
            <?php
	}else{
	  ?>
            <input type="submit" class="btn btn-primary btn-sm" name="tblsimpan" id="tblsimpan" value="Save">

            <?php
	  }
	  ?>
            <input type="button" class="btn btn-info btn-sm" name="tblreset" id="tblreset" value="Reset"
                onclick='backbutton()'>

        </div>
    </div>
    <?php echo form_close();?>
</div>
<!-- pop up no penjualan-->
<div class="modal fade" id="divpopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog wide-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Pilih Data Penjualan</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-condensed table-hover table-striped" id='tabelpopfpb'>
                    <thead>
                        <tr>
                            <th>No Penjualan</th>
                            <th>Tgl</th>
                            <th>Pembayaran</th>
                            <th>Pilih</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
		foreach($listdatapenjualan as $dt):
		?>
                        <tr>
                            <td><?php echo $dt['transaksiid'];?></td>
                            <td><?php echo $this->mylib->tglIndo($dt['tanggal']);?></td>
                            <td><?php echo $dt['pembayaran'];?></td>
                            <td><input type='button' class='btn btn-primary btn-xs' value='Pilih'
                                    onclick="pilihpenjualan('<?php echo $dt['transaksiid'];?>')"></td>
                        </tr>
                        <?php
		endforeach;
		?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>