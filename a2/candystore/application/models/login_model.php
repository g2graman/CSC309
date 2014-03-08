<?php
class Login_model extends CI_Model {
	
	function get($id)
	{
		$query = $this->db->get_where('customer',array('id' => $id));
		
		return $query->row(0,'Customer');
	}
	
	function delete($id) {
		return $this->db->delete("customer",array('id' => $id ));
	}
	
	function insert($customer) {
		return $this->db->insert("customer", array('first' => $customer->first,
				                                  'last' => $customer->last,
												  'login' => $customer->login,
												  'password' => $customer->password,
												  'email' => $customer->email));
	}
	 
	function update($customer) {
		$this->db->where('id', $customer->id);
		return $this->db->update("customer", array('first' => $customer->first,
				                                  'last' => $customer->last,
												  'login' => $customer->login,
												  'password' => $customer->password,
												  'email' => $customer->email));
	
	
	}
	
	function login_exists($login, $password) {
		$query = $this->db->get_where('customer',array('login' => $login, 
													'password' => $password));
		if ($query->num_rows() > 0){
			foreach ($query->result() as $row){
			      return $row;
			}
		}
		
		return FALSE;
	}
}
?>