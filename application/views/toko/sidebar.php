<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="profile-image">
                  <img class="img-xs rounded-circle" src="<?=img_url();?>faces-clipart/pic-1.png" alt="profile image">
                  <div class="dot-indicator bg-success"></div>
                </div>
                <div class="text-wrapper">
                  <p class="profile-name"><?=$this->session->userdata('namaadmin');?></p>
                  <p class="designation"><?=$this->session->userdata('nmlevel');?></p>
                </div>
              </a>
            </li>
            <li class="nav-item nav-category">Menu</li>
            <li class="nav-item">
              <a class="nav-link" href="<?=site_url('toko/Home');?>">
                <i class="menu-icon typcn typcn-document-text"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
			<?php
				// data main menu
				$main_menu = $this->db->get_where('menuadmin', array('parent' => 0,'active'=>1));
				foreach ($main_menu->result() as $main) {
					// Query untuk mencari data sub menu
					$sub_menu = $this->db->get_where('menuadmin', array('parent' => $main->id,'active'=>1));
					// periksa apakah ada sub menu
					if ($sub_menu->num_rows() > 0) {
						// main menu dengan sub menu
						echo "<li class='nav-item'>
					  <a class='nav-link' data-toggle='collapse' href='#ui-".$main->id."' aria-expanded='false' aria-controls='ui-".$main->id."'>
						<span class='menu-title'>".$main->name."</span>
						<i class='menu-arrow'></i>
					  </a>
					  <div class='collapse' id='ui-".$main->id."'>
						<ul class='nav flex-column sub-menu'>";
						foreach ($sub_menu->result() as $sub) {
							echo "<li class='nav-item'><a class='nav-link' href='".site_url('toko/').$sub->url."'>".$sub->name."</a></li>";
						}
						echo"</ul></li>";
					} else {
						// main menu tanpa sub menu
						echo "<li class='nav-item'><a class='nav-link' href='".site_url('toko/').$main->url."'><span class='menu-title'>" .$main->name. "</span></a></li>";
					}
				}
				?>
            <li class="nav-item">
              <a class="nav-link" href="<?=site_url('toko/Logout');?>">
                <span class="menu-title">Logout</span>
              </a>
            </li>
          </ul>
        </nav>
	<div class="main-panel">