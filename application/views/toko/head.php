<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin</title>
    <link rel="stylesheet" href="<?=asset_url();?>vendors/iconfonts/mdi/css/materialdesignicons.min.css">
	<link rel="stylesheet" href="<?=asset_url();?>vendors/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?=asset_url();?>iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?=asset_url();?>vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?=css_url();?>shared/style.css">
    <link rel="stylesheet" href="<?=css_url();?>demo_1/style.css">
    <link rel="shortcut icon" href="<?=img_url();?>favicon.png" />
	<?php 
	if(isset($css_files)):
		foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
  <?php 
  endforeach; 
   endif;
  ?>
  <script type='text/javascript'>
  var base_url = '<?php echo site_url();?>';
  </script>
  </head>
  <body>
    <div class="container-scroller">

      