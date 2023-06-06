<div class="content-wrapper">
    <div class="row page-title-header">
        <div class="col-12">
            <div class="page-header">
                <h4 class="page-title">Management Hak Akses Level Menu</h4>
            </div>
        </div>
    </div>
    <?php echo form_open('toko/Levelmenu/simpan'); ?>
    <div class='form-group'>
        <label for="pilihusername">Pilih Level</label>
        <select name='idlevel' id='idlevel' class='form-control' onchange='ubahlevel(this.value)'>
            <option value=''></option>
            <?php

            foreach ($level as $row) {
                $selected = '';
                if ($row['idlevel'] == $levelpilihan) $selected = 'selected';
                echo "<option value='" . $row['idlevel'] . "' $selected>" . $row['namalevel'] . "</option>";
            }
            ?>
        </select>
        <script type='text/javascript'>
            function ubahlevel(isi) {
                if (isi != '') {
                    document.location = base_url + '/toko/Levelmenu/level/' + isi;
                } else {
                    document.location = base_url + '/toko/Levelmenu/';
                }
            }
        </script>
    </div>
    <?php
    if ($levelpilihan != '') {
    ?>
        <table border='1' class='table'>
            <tr>
                <th>Nama Menu</th>
                <th>Create</th>
                <th>Read</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>

            <?php
            $main_menu = $this->db->get_where('menuadmin', array('parent' => 0));
            foreach ($main_menu->result() as $main) {
                // Query untuk mencari data sub menu
                $sub_menu = $this->db->get_where('menuadmin', array('parent' => $main->id));
                $disabledcreate = ($main->create == '0') ? "disabled" : "";
                $disabledread = ($main->read == '0') ? "disabled" : "";
                $disabledupdate = ($main->update == '0') ? "disabled" : "";
                $disableddelete = ($main->del == '0') ? "disabled" : "";
                //cek di level_menuadminchecked atau gak?
                $checkedcreate = "";
                $checkedread = "";
                $checkedupdate = "";
                $checkeddelete = "";
                $cekchecked = $this->db->get_where('level_menuadmin', array('idlevel' => $levelpilihan, 'idadminmenu' => $main->id));
                if ($cekchecked->num_rows() > 0) {
                    $hasil = $cekchecked->result();
                    $hasil = $hasil[0];
                    $checkedcreate = ($hasil->cancreate == '1') ? "checked" : "";
                    $checkedread = ($hasil->canread == '1') ? "checked" : "";
                    $checkedupdate = ($hasil->canupdate == '1') ? "checked" : "";
                    $checkeddelete = ($hasil->candelete == '1') ? "checked" : "";
                }

                echo "<tr><td><b>--" . $main->name . "</b></td><td><input type='checkbox' name=cancreate_" . $main->id . " value='1' $disabledcreate $checkedcreate></td><td><input type='checkbox' name=canread_" . $main->id . " value='1' $disabledread $checkedread></td><td><input type='checkbox' name=canupdate_" . $main->id . " value='1' $disabledupdate $checkedupdate></td><td><input type='checkbox' name=candelete_" . $main->id . " value='1' $disableddelete $checkeddelete></td></tr>";
                // periksa apakah ada sub menu
                if ($sub_menu->num_rows() > 0) {
                    // main menu dengan sub menu

                    foreach ($sub_menu->result() as $sub) {
                        $disabledcreate = ($sub->create == '0') ? "disabled" : "";
                        $disabledread = ($sub->read == '0') ? "disabled" : "";
                        $disabledupdate = ($sub->update == '0') ? "disabled" : "";
                        $disableddelete = ($sub->del == '0') ? "disabled" : "";
                        //cek di level_menuadmin checked atau gak?
                        $checkedcreate = "";
                        $checkedread = "";
                        $checkedupdate = "";
                        $checkeddelete = "";
                        $cekchecked = $this->db->get_where('level_menuadmin', array('idlevel' => $levelpilihan, 'idadminmenu' => $sub->id));
                        //	echo $this->db->last_query();
                        if ($cekchecked->num_rows() > 0) {
                            $hasil = $cekchecked->result();
                            $hasil = $hasil[0];
                            $checkedcreate = ($hasil->cancreate == '1') ? "checked" : "";
                            $checkedread = ($hasil->canread == '1') ? "checked" : "";
                            $checkedupdate = ($hasil->canupdate == '1') ? "checked" : "";
                            $checkeddelete = ($hasil->candelete == '1') ? "checked" : "";
                        }
                        echo "<tr><td>----" . $sub->name . "</td><td><input type='checkbox' name=cancreate_" . $sub->id . " value='1' $disabledcreate $checkedcreate></td><td><input type='checkbox' name=canread_" . $sub->id . " value='1' $disabledread $checkedread></td><td><input type='checkbox' name=canupdate_" . $sub->id . " value='1' $disabledupdate $checkedupdate></td><td><input type='checkbox' name=candelete_" . $sub->id . " value='1' $disableddelete $checkeddelete></td></tr>";
                    }
                }
            }
            ?>
        </table>
    <?php
    }
    ?>
    <?php echo form_close(); ?>
</div>