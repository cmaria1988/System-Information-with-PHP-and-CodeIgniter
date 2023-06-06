</div>
</div>
</div>
<script src="<?=asset_url();?>vendors/js/vendor.bundle.base.js"></script>
<script src="<?=js_url();?>shared/off-canvas.js"></script>
<?php 
if(isset($js_files)):
	foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php 
    endforeach; 
endif;
?>
</body>
</html>