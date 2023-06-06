<div class="content-wrapper">
    <div class="row page-title-header">
        <div class="col-12">
            <div class="page-header">
                <h4 class="page-title">Laporan Barang Masuk</h4>
            </div>
        </div>
    </div>
    <?php
    if (isset($error)) {
        echo '<div class="alert alert-danger alert-dismissible">
					  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					  <strong>' . $error . '</strong>
						</div>';
    }
    ?>
    <div id='divform'>
        <?php echo form_open('toko/Expire/cetak'); ?>

        <div class="row form-group">
            <label for="nama" class="col-sm-3 control-label">Tanggal Awal</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="tglawal" name="tglawal" required readonly>
            </div>
        </div>
        <br><br>
        <div class="row form-group">
            <label for="nama" class="col-sm-3 control-label">Tanggal Akhir</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="tglakhir" name="tglakhir" required readonly>
            </div>
        </div>
        <div class="row form-group">
            <label for="nama" class="col-sm-3 control-label">Format</label>
            <div class="col-sm-5">
                <label><input type="radio" class="form-control" id="pdf" name="format" value='pdf' checked>PDF</label>
                &nbsp;
                &nbsp;
               <!-- <label><input type="radio" class="form-control" id="xls" name="format" value='xls'>XLS</label> -->            </div>
        </div>
        <div class="row form-group">
            <label for="nama" class="col-sm-3 control-label">&nbsp;</label>
            <div class="col-sm-5">
                <input type="submit" class="btn btn-primary" id="tblcetak" name="tblcetak" value='Cetak'>

            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>