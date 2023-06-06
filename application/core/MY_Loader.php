<?php
class MY_Loader extends CI_Loader {    
	public function template_adm($template_name, $vars = array(), $return = FALSE)
    {
        //panggil beberapa view ke dalam sebuah function.
        if($return):
        $content  = $this->view('toko/head', $vars, $return);
		$content  = $this->view('toko/header', $vars, $return);
		$content  = $this->view('toko/sidebar', $vars, $return);
        $content .= $this->view('toko/'.$template_name, $vars, $return);
        $content .= $this->view('toko/footer', $vars, $return);
		$content .= $this->view('toko/foot', $vars, $return);

        return $content;
    else:
        $this->view('toko/head', $vars);
		$this->view('toko/header', $vars);
		$this->view('toko/sidebar', $vars);
        $this->view('toko/'.$template_name, $vars);
        $this->view('toko/footer', $vars);
		$this->view('toko/foot', $vars);
    endif;
    }
}

