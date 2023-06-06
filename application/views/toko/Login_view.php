<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Silakan Login</title>
  <link href="<?=asset_url()?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="<?=css_url()?>adm/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
  <div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Silakan Login</h1>
                  </div>
                  <?php 
						$atribut = array('class' => 'user', 'id' => 'login-form', 'name' => 'login-form');
						echo form_open('toko/Login/submit',$atribut);
							 
						if(isset($error))
						{
							echo '<div class="alert alert-danger alert-dismissible">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong>'.$error.'</strong>
								</div>';
						}
					?> 
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Enter Username" required>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" name="password" id="password" placeholder="Enter Password" required>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="rememberme">
                        <label class="custom-control-label" for="rememberme">Remember Me</label>
                      </div>
                    </div>
					<input type='submit' class="btn btn-primary btn-user btn-block" value="Login" name="Login">
					<hr>
					<div class="row center"><small>Copyright &copy; 2020 <a href='' target='_blank'>Maria Virgini Claudya Tuerah</a></small></div>
					<?php
					echo form_close();
					?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="<?=asset_url()?>vendor/jquery/jquery.min.js"></script>
  <script src="<?=asset_url()?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?=js_url()?>adm/sb-admin-2.min.js"></script>
</body>
</html>