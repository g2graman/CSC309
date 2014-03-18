<?php
class customer_model extends CI_Model {

  function validate_new_user_info($userInfo){
    $login_query = $this->db->get_where('customer', array('login' => $userInfo['login']));
    $email_query = $this->db->get_where('customer', array('email' => $userInfo['email']));

    $login_result = $login_query->result();
    $email_result = $email_query->result();

    if ($login_query->num_rows() > 0 || $email_query->num_rows() > 0) {
      return false;
    }
    return true;
  }

  function create_user($userInfo){
    $this->db->insert('customer', $userInfo);
  }

  function get_customer_info($id){
    $cust_query = $this->db->get_where('customer', array('id' => $id));
    $cust_result = $cust_query->result();
    if($cust_query->num_rows() > 0){
      foreach ($cust_result as $cust){
        return $cust;
      }
    }
  }



}
?>
