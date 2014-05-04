<?php
	require_once 'movies_corner.php';
	class Users extends Movies_corner
	{
		function __construct()
		{
			parent::__construct();
			
			$this->load->model('users_model');
			
			$this->load->library('pagination');					

			$this->order_options = array('1'=>'ASC', '2'=>'DESC');
			$this->sort_options = array('1'=>'UserName', '2'=>'ReviewsCount');
			$this->sort_reviews_options = array('1'=>'MovieTitle', '2'=>'Rating', '3'=>'DatePosted');
		}
		
		function display($sort='1', $order='1', $how_many=30, $offset=0)
		{
			$params = array('number'=>&$how_many);
			$this->_parse_post($params);
			
			$config['base_url'] = base_url(). "users/display/{$sort}/{$order}/{$how_many}";
			$config['per_page'] = $how_many;
			$config['total_rows'] = $this->users_model->count_users();
			$config['uri_segment'] = 6;
			
			$this->pagination->initialize($config);
			
			$this->data['users'] = $this->users_model->get_users($this->sort_options[$sort],$this->order_options[$order],$how_many,$offset);
			$this->data['title'] = 'Gamelog Movies Corner|Users';
			$this->data['links'] = $this->pagination->create_links();
			$this->data['how_many']  = $how_many;
			$this->data['order'] = $order;
			$this->data['sort'] = $sort;
			$this->data['view'] = 'users/display';
			$this->data['body_id'] = 'users_body';
			
			$this->load->view('main_view',$this->data);			
		}
		
		function details($userID, $sort='3', $order='2', $how_many=30, $offset=0)
		{
			$this->session->set_flashdata('redirectToCurrent',current_url());
			$params = array('number'=>&$how_many);
			$this->_parse_post($params);
			
			$config['base_url'] = base_url(). "users/details/{$userID}/{$sort}/{$order}/{$how_many}";
			$config['per_page'] = $how_many;
			$config['total_rows'] = $this->users_model->count_user_reviews($userID);
			$config['uri_segment'] = 7;
			
			$this->pagination->initialize($config);
			
			try
			{
				$user_id = $this->session->userdata('user_id');
				
				$this->data['canEdit'] = $user_id == $userID ? TRUE:FALSE;				
				$this->data['user'] = $this->users_model->get_user_nick($userID);
				if( !$this->data['user'] )
					redirect('notfound');
				$this->data['userID'] = $userID;
				$this->data['title'] = 'User\'s details |' .$this->data['user'];
				$this->data['reviews_count'] = $config['total_rows'];
				$this->data['view'] = 'users/details';
				$this->data['users_reviews'] = $this->users_model->get_users_reviews($userID,$this->sort_reviews_options[$sort],$this->order_options[$order],$how_many,$offset);
				$this->data['links'] = $this->pagination->create_links();
				$this->data['order'] = $order;
				$this->data['sort'] = $sort;
				$this->data['how_many'] = $how_many;
				$this->data['body_id'] = 'users_body';
				$this->load->view('main_view',$this->data);
				
			}
			catch(Key_not_found_exception $e)
			{
				show_error("User with the specified ID doesn't exist");			
			}						
		}
	}
?>
