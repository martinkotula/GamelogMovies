<?php
	class Movies_corner extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->_is_logged_in();	
			$this->load->model('users_model', 'users');
			
			$main_nav = array();

			$user_id = $this->session->userdata('user_id');
			$is_moderator = FALSE;

			if( $user_id )
				$is_moderator = $this->users->is_moderator($user_id);
			
			if( $is_moderator )
			{
				$main_nav[] = '<li class="moderator"><a href="'. base_url() . 'moderator">Moderator</a></li>';
				$main_nav[] = '<li><a href="'.base_url() . 'feed/rss">RSS gen</a></li>';
				$main_nav[] = '<li class=""><a href="'. base_url() . 'edit/">Nowa recenzja</a></li>';
				
			}
			if( $user_id && !$is_moderator )
			{
				$main_nav[] = '<li class=""><a href="'. base_url() . 'users/details/'.$user_id.'">Recenzje</a></li>';
				$main_nav[] = '<li class=""><a href="'. base_url() . 'edit/">Nowa recenzja</a></li>';
				
			}
			if( $user_id )
				$main_nav[] = '<li class="login"><a href="'. base_url() . 'login/log_out">Log Out</a></li>';
			else
				$main_nav[] = '<li class="login"><a href="'. base_url() . 'login">Login</a></li>';
				
			$this->data['main_nav'] = $main_nav;
			$this->data['activeLink'] = '';
		}
		
		function _parse_post( &$params )
		{
			foreach ( $params as $key => $value ) 
			{
				if( $this->input->post($key) !== FALSE )
					$params[$key] = $this->input->post($key);   
			}
		}
		
		function _is_logged_in()
		{			
			$this->data['logged_in'] = $this->session->userdata('is_logged_in')==TRUE;							 
			
			return $this->data['logged_in']; 
		}
		
		function _authorize_user()
		{
			if( !$this->_is_logged_in() )
			{
				$this->session->set_flashdata('redirectToCurrent', current_url());
				redirect('login');
			}
			
			$userID = $this->session->userdata('user_id');			
			if(!$this->users->is_moderator($userID))
				redirect('restricted');
		}
		
		function _is_moderator()
		{
			$userID = $this->session->userdata('user_id');		
			return $this->users->is_moderator($userID);
		}
		
		protected $data = array();

	}
?>
