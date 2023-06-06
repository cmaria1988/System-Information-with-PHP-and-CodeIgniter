<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
          <a class="navbar-brand brand-logo" href="<?=site_url('toko/Home/');?>">
            <!--img src="<?=img_url();?>logos.svg" alt="logo" /--> </a>
          <a class="navbar-brand brand-logo-mini" href="<?=site_url('toko/Home/');?>">
            <img src="<?=img_url();?>logo-mini.svg" alt="logo" /> </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">
          <ul class="navbar-nav">
            <li class="nav-item font-weight-semibold">Toko Cahaya Terang</li>
          </ul>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
              <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <img class="img-xs rounded-circle" src="<?=img_url();?>faces-clipart/pic-1.png" alt="Profile image"> </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="img-md rounded-circle" src="<?=img_url();?>faces-clipart/pic-1.png" alt="Profile image">
                  <p class="mb-1 mt-3 font-weight-semibold"><?=$this->session->userdata('namaadmin');?></p>
                  <p class="font-weight-light text-muted mb-0"><?=$this->session->userdata('email');?></p>
                </div>
                <a class="dropdown-item" href="<?=site_url('toko/Gantipass');?>">Ganti Password<i class="dropdown-item-icon ti-dashboard"></i></a>
                <a class="dropdown-item" href="<?=site_url('toko/Logout');?>">Log Out<i class="dropdown-item-icon ti-power-off"></i></a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
	  <div class="container-fluid page-body-wrapper">