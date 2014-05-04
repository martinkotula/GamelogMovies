<?php
	require_once('movies_corner.php');
	class Login extends Movies_corner
	{
		function index($error = '')
		{									
			$this->data['title'] = 'Login page';
			$this->data['view'] = 'login';
			$this->data['error'] = $error;
			$this->data['body_id'] = 'body_login';
			$this->load->view('main_view',$this->data);
			
		}
		
		function validate()
		{
			$this->load->model('authentication','auth');
			$this->load->model('users_model', 'users');
			if( $this->auth->is_authenticated() )
			{
				$new_data = array
						(							
						   'is_logged_in' => TRUE									
						   ,'user_id'      => $this->users->get_user_id($this->input->post('user_name'))
						);
				$this->session->set_userdata($new_data);	
				if( $this->session->flashdata('redirectToCurrent') )
					redirect($this->session->flashdata('redirectToCurrent'));				
				else
					redirect(base_url());
			}			
			else
			{
				log_message('info'
						  , 'Invalid user credentials user_name:['
							.$this->input->post('user_name')
							.'] password:['
							.$this->input->post('user_password')
							.'] IP: ['
							.$_SERVER['REMOTE_ADDR'].']'
							);
				$this->index('Invalid user name or password');
			}
			
		}
		
		function log_out()
		{
			$this->session->unset_userdata('is_logged_in');
			$this->session->unset_userdata('user_id');
			redirect(base_url());	
		}
		
	}
	
?>
