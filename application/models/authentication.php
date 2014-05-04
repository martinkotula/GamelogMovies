<?php
	class Authentication extends CI_Model
	{
		function is_authenticated()
		{
			$this->db->from('GamelogUsers');
			$this->db->where('UserName', $this->input->post('user_name'));
			$this->db->where('Password', sha1($this->input->post('user_password')));
			
			$query = $this->db->get();
			
			return $query->num_rows() == 1;
		}
	}
	
?>
