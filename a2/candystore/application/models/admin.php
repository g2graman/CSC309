<?php
class admin extends CI_Model {

  function get_admin_info(){
    $query = $this->db->get_where('customer', array('login' => 'admin'));

    $result = $query->result();

    if ($query->num_rows() > 0) {
      foreach($result as $admin) {
        return $admin;
      }
    } else {
      return 'Error Accessing Admin Information';
    }
  }

}
?>
