<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	// redirect if needed, otherwise display the user list
	public function index()
	{
        if ( !$this->ion_auth->logged_in () ) {
            $next_link = urlencode(substr("$_SERVER[REQUEST_URI]", stripos("$_SERVER[REQUEST_URI]", "index.php")+9));
            if ($this->input->is_ajax_request()) {
                $result = array("status"=>"redirect", "message"=>"auth/login?next=$next_link");
                $this->output->set_content_type('application/json')->set_output(json_encode($result));
                return false;
            }else{
                redirect("auth/login?next=$next_link");
            }
        }
		elseif (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else
		{
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	        $this->data['success_message']  = $this->session->flashdata('success_message');
			$this->_render_page('auth/index', $this->data);
		}
	}

    public function getData(){
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        $this->load->library('datatables');
        if( !$this->ion_auth->in_group(array("superadmin")) ){
            $this->datatables->where("user_id NOT IN", "(SELECT users.id FROM users LEFT JOIN users_groups ON users.id=users_groups.user_id LEFT JOIN groups ON users_groups.group_id=groups.id WHERE groups.name='superadmin')", false);
        }
        $this->datatables
        ->setsColumns("username,fullname,email,phone,groups,active,id")
        ->select("users.id,username,CONCAT(first_name, ' ', last_name) as fullname,email,phone,GROUP_CONCAT(groups.name SEPARATOR ',') as groups,active", false)
        ->join("users_groups", "users.id=users_groups.user_id", "LEFT")
        ->join("groups", "users_groups.group_id=groups.id", "LEFT")
        ->group_by("users.id")
        ->from("users");
        $this->output->set_content_type('application/json')->set_output( $this->datatables->generate() );
    }


    

	// log the user in
	public function login($action = "login")
	{
		$this->data['title'] = lang('login_heading');

		//validate form input
		$this->form_validation->set_rules('identity', str_replace(':', '', lang('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', lang('login_password_label')), 'required');

		if ($this->form_validation->run() == true)
		{
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool) $this->input->post('remember');
			$next = $this->input->post('next');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('success_message', $this->ion_auth->messages());
				if( $next ){
					redirect($next, 'refresh');
				}else{
					redirect('/', 'refresh');
				}
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				if( $next ){
					redirect('auth/login?next='.urlencode($next), 'refresh');
				}else{
					redirect('auth/login', 'refresh');
				}
			}
		}
		else
		{
			if ($this->ion_auth->logged_in())
			{
				$next = $this->input->get('next');
				if( $next ){
					redirect($next);
				}else{
					redirect('/');
				}
			}
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['success_message'] =  $this->session->flashdata('success_message');

			$this->data['identity'] = array(
				'name'  => 'identity',
				'id'    => 'identity',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('identity'),
				'class' => 'form-control'
			);
			$this->data['password'] = array(
				'name'  => 'password',
				'id'    => 'password',
				'type'  => 'password',
				'class' => 'form-control'
			);
			$this->data['action'] = $action;
			$this->_render_page('auth/login', $this->data);
		}
	}

	// create a new account
	public function register()
    {
		if( VERSION == "DEMO" ){  // Action loaded only on release versions
			$this->session->set_flashdata('message', lang("is_demo"));
			redirect($_SERVER['HTTP_REFERER'], 'refresh');
		}

        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        if($identity_column!=='email')
        {
            $this->form_validation->set_rules('username',lang('register_username'),'required|is_unique['.$tables['users'].'.'.$identity_column.']');
            $this->form_validation->set_rules('email', lang('register_email'), 'required|valid_email');
        }
        else
        {
            $this->form_validation->set_rules('username',lang('register_username'),'required');
            $this->form_validation->set_rules('email', lang('register_email'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
        $this->form_validation->set_rules('password', lang('register_password'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', lang('register_password_confirm'), 'required');

        if ($this->form_validation->run() == true)
        {
            $email    = strtolower($this->input->post('email'));
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => "",
                'last_name'  => "",
                'company'    => "",
                'phone'      => "",
            );
        }
        if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data))
        {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('success_message', $this->ion_auth->messages());
	        if($identity_column!=='email')
	        {
            	$this->ion_auth->login($username, $password, true);
            }else{
            	$this->ion_auth->login($email, $password, true);
            }
            redirect("/", 'refresh');
        }
        else
        {
        	$message = (validation_errors()) ? validation_errors() : $this->ion_auth->messages();
            $this->session->set_flashdata('message', $message);
            redirect("auth/login/register", 'refresh');
        }
    }

	// log the user out
	public function logout()
	{
		$this->data['title'] = "Logout";
		// log the user out
		$logout = $this->ion_auth->logout();
		// redirect them to the login page
		$this->session->set_flashdata('success_message', $this->ion_auth->messages());
		redirect('auth/login', 'refresh');
	}

	// change password
	public function change_password()
	{
		if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
		}
		$this->form_validation->set_rules('old', lang('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', lang('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', lang('change_password_validation_new_password_confirm_label'), 'required');

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() == false)
		{
	        if( validation_errors() || $this->ion_auth->errors() ){
				// set the flash data error message if there is one
	            $data = array(
	            	"status" => "error",
	            	"message" => (validation_errors()) ? validation_errors() : $this->session->flashdata('message')
	            );
	            $this->output->set_content_type('application/json')->set_output(json_encode($data));

	        }else{
				// display the form
	        	$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['old_password'] = array(
					'name' => 'old',
					'id'   => 'old',
					'type' => 'password',
					'class' => 'form-control',
					'tabindex' => '1',
                    'autocomplete' => 'new-password'
				);
				$this->data['new_password'] = array(
					'name'    => 'new',
					'id'      => 'new',
					'type'    => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
					'class' => 'form-control',
                    'autocomplete' => 'new-password'
				);
				$this->data['new_password_confirm'] = array(
					'name'    => 'new_confirm',
					'id'      => 'new_confirm',
					'type'    => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
					'class' => 'form-control',
                    'autocomplete' => 'new-password'
				);
				$this->data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);

				// render
				$this->_render_page('auth/change_password', $this->data);
	        }


		}
		else
		{
			$identity = $this->session->userdata('identity');
			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));
			if ($change)
			{
				//if the password was successfully changed
				$this->session->set_flashdata('success_message', $this->ion_auth->messages());
	            $data = array(
	            	"status" => "redirect",
	            	"message" => site_url("/auth/logout")
	            );
	            $this->output->set_content_type('application/json')->set_output(json_encode($data));
			}
			else
			{
	            $data = array(
	            	"status" => "error",
	            	"message" => $this->ion_auth->errors()
	            );
	            $this->output->set_content_type('application/json')->set_output(json_encode($data));
			}
		}
	}

	// forgot password
	public function forgot_password()
	{
		if( VERSION == "DEMO" ){  // Action loaded only on release versions
			$this->session->set_flashdata('message', lang("is_demo"));
			redirect($_SERVER['HTTP_REFERER'], 'refresh');
		}
		// setting validation rules by checking whether identity is username or email
		if($this->config->item('identity', 'ion_auth') != 'email' )
		{
		   $this->form_validation->set_rules('identity', lang('forgot_password_identity_label'), 'required');
		}
		else
		{
		   $this->form_validation->set_rules('identity', lang('forgot_password_validation_email_label'), 'required|valid_email');
		}


		if ($this->form_validation->run() == false)
		{
			$this->data['type'] = $this->config->item('identity','ion_auth');
			// setup the input
			$this->data['identity'] = array(
                'name' => 'identity',
				'id' => 'identity',
				'class' => 'form-control',
                'autocomplete' => 'off'
			);

			if ( $this->config->item('identity', 'ion_auth') != 'email' ){
				$this->data['identity_label'] = lang('forgot_password_identity_label');
			}
			else
			{
				$this->data['identity_label'] = lang('forgot_password_email_identity_label');
			}

			// set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page('auth/forgot_password', $this->data);
		}
		else
		{
			$identity = $this->ion_auth
                            ->where("username", $this->input->post('identity'))
                            ->or_where("email", $this->input->post('identity'))
                            ->users()
                            ->row();

			if(empty($identity)) {
        		if($this->config->item('identity', 'ion_auth') != 'email')
            	{
            		$this->ion_auth->set_error('forgot_password_identity_not_found');
            	}
            	else
            	{
            	   $this->ion_auth->set_error('forgot_password_email_not_found');
            	}
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("auth/forgot_password", 'refresh');
    		}

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten)
			{
				// if there were no errors
				$this->session->set_flashdata('success_message', $this->ion_auth->messages());
				redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
			}
		}
	}

	// reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{
		if( VERSION == "DEMO" ){  // Action loaded only on release versions
			$this->session->set_flashdata('message', lang("is_demo"));
			redirect($_SERVER['HTTP_REFERER'], 'refresh');
		}

		if (!$code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{
			// if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', lang('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', lang('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() == false)
			{
				// display the form

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
					'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
                	'class' => 'form-control',
					'tabindex' => '1',
                    'autocomplete' => 'new-password'
				);
				$this->data['new_password_confirm'] = array(
					'name'    => 'new_confirm',
					'id'      => 'new_confirm',
					'type'    => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
                	'class' => 'form-control',
                    'autocomplete' => 'new-password'
				);
				$this->data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				// render
				$this->_render_page('auth/reset_password', $this->data);
			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
				{

					// something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_error(lang('error_csrf'));

				}
				else
				{
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{
						// if the password was successfully changed
						$this->session->set_flashdata('success_message', $this->ion_auth->messages());
						redirect("auth/login", 'refresh');
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{
			// if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}


	// activate the user
	public function activate($id, $code=false)
	{
		if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
		}

		if ($code !== false)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
            if ($this->input->is_ajax_request()) {
                $result = array("status" => "success", "message" => $this->ion_auth->messages());
                $this->output->set_content_type('application/json')->set_output(json_encode($result));
            }else{
                // redirect them to the auth page
                $this->session->set_flashdata('success_message', $this->ion_auth->messages());
                redirect('settings?config=users', 'refresh');
            }
		}
		else
		{
            if ($this->input->is_ajax_request()) {
                $result = array("status" => "error", "message" => $this->ion_auth->errors());
                $this->output->set_content_type('application/json')->set_output(json_encode($result));
            }else{
    			// redirect them to the forgot password page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('settings?config=users', 'refresh');
            }
		}
	}

	// deactivate the user
	public function deactivate($id = NULL)
	{
		if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
		}
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}

		$id = (int) $id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', lang('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', lang('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();

			$this->_render_page('auth/deactivate_user', $this->data);
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($id != $this->input->post('id'))
				{
		            $data = array(
		            	"status" => "error",
		            	"message" => lang('error_csrf')
		            );
		            $this->output->set_content_type('application/json')->set_output(json_encode($data));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			// redirect them back to the auth page
            $data = array(
            	"status" => "success",
            	"message" => $this->ion_auth->messages()
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}

	// create a new user
	public function create_user()
    {
		if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
		}
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }

        $this->data['title'] = lang('create_user_heading');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('auth', 'refresh');
        }

        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('first_name', lang('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', lang('create_user_validation_lname_label'), 'required');
        if($identity_column!=='email')
        {
            $this->form_validation->set_rules('identity',lang('create_user_validation_identity_label'),'required|is_unique['.$tables['users'].'.'.$identity_column.']');
            $this->form_validation->set_rules('email', lang('create_user_validation_email_label'), 'required|valid_email');
        }
        else
        {
            $this->form_validation->set_rules('email', lang('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
        $this->form_validation->set_rules('phone', lang('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('company', lang('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', lang('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', lang('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == true)
        {
            $email    = strtolower($this->input->post('email'));
            $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'company'    => $this->input->post('company'),
                'phone'      => $this->input->post('phone'),
            );
        }
        if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data))
        {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $data = array(
            	"status" => "success",
            	"message" => $this->ion_auth->messages()
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
        else
        {
	        if( validation_errors() || $this->ion_auth->errors() ){
	            // display the create user form
	            // set the flash data error message if there is one
	            $data = array(
	            	"status" => "error",
	            	"message" => validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')),
                    "fields"  => $this->form_validation->error_array()
	            );
	            $this->output->set_content_type('application/json')->set_output(json_encode($data));

            }else{

	            $this->data['first_name'] = array(
	                'name'  => 'first_name',
	                'id'    => 'first_name',
	                'type'  => 'text',
	                'class' => 'form-control',
	            	'autofocus' => 'autofocus',
                    "placeholder"=> lang("create_user_fname_label"),
	                'value' => $this->form_validation->set_value('first_name'),
					'tabindex' => '1',
                    'autocomplete' => 'off'
	            );
	            $this->data['last_name'] = array(
	                'name'  => 'last_name',
	                'id'    => 'last_name',
	                'type'  => 'text',
	                'class' => 'form-control',
                    "placeholder"=> lang("create_user_lname_label"),
	                'value' => $this->form_validation->set_value('last_name'),
                    'autocomplete' => 'off'
	            );
	            $this->data['identity'] = array(
	                'name'  => 'identity',
	                'id'    => 'identity',
	                'type'  => 'text',
	                'class' => 'form-control',
	                'value' => $this->form_validation->set_value('identity'),
                    'autocomplete' => 'off'
	            );
	            $this->data['email'] = array(
	                'name'  => 'email',
	                'id'    => 'email',
	                'type'  => 'text',
	                'class' => 'form-control',
	                'value' => $this->form_validation->set_value('email'),
                    'autocomplete' => 'off'
	            );
	            $this->data['company'] = array(
	                'name'  => 'company',
	                'id'    => 'company',
	                'type'  => 'text',
	                'class' => 'form-control',
	                'value' => $this->form_validation->set_value('company'),
	            );
	            $this->data['phone'] = array(
	                'name'  => 'phone',
	                'id'    => 'phone',
	                'type'  => 'text',
	                'class' => 'form-control',
	                'value' => $this->form_validation->set_value('phone'),
	            );
	            $this->data['password'] = array(
	                'name'  => 'password',
	                'id'    => 'password',
	                'type'  => 'password',
	                'class' => 'form-control',
	                'value' => $this->form_validation->set_value('password'),
                    'autocomplete' => 'new-password'
	            );
	            $this->data['password_confirm'] = array(
	                'name'  => 'password_confirm',
	                'id'    => 'password_confirm',
	                'type'  => 'password',
	                'class' => 'form-control',
	                'value' => $this->form_validation->set_value('password_confirm'),
                    'autocomplete' => 'new-password'
	            );

	            $this->_render_page('auth/create_user', $this->data);
	        }
        }

    }

	// edit a user
	public function edit_user($id)
	{
		if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
		}
        if (!$this->input->is_ajax_request()) {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
		$this->data['title'] = lang('edit_user_heading');

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
		{
			redirect('settings?config=users', 'refresh');
		}

		$user = $this->ion_auth->user($id)->row();
        $groups = array();
        foreach ($this->ion_auth->groups()->result_array() as $group) {
            if( $group['name'] != "supplier" && $group['name'] != "customer" ){
		      $groups[]=$group;
            }
        }
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();
        $is_biller = false;
        foreach ($currentGroups as $group) {
            if( $group->name == "supplier" || $group->name == "customer" ){
              $is_biller = true;
              break;
            }
        }

		// validate form input
		$this->form_validation->set_rules('first_name', lang('edit_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('last_name', lang('edit_user_validation_lname_label'), 'required');

		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error(lang('error_csrf'));
			}

			// update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', lang('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', lang('edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'company'    => $this->input->post('company'),
					'phone'      => $this->input->post('phone'),
				);

				// update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}



				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin())
				{
					//Update the groups user belongs to
					$groupData = $this->input->post('groups');

					if (isset($groupData) && !empty($groupData)) {

						$this->ion_auth->remove_from_group('', $id);

						foreach ($groupData as $grp) {
							$this->ion_auth->add_to_group($grp, $id);
						}

					}
				}
				// check to see if we are updating the user
			   if($this->ion_auth->update($user->id, $data))
			    {
		            $data = array(
		            	"status" => "success",
		            	"message" => $this->ion_auth->messages()
		            );
		            $this->output->set_content_type('application/json')->set_output(json_encode($data));

			    }
			    else
			    {
		            $data = array(
		            	"status" => "error",
		            	"message" => $this->ion_auth->errors()
		            );
		            $this->output->set_content_type('application/json')->set_output(json_encode($data));

			    }

			}else{

		        if( validation_errors() || $this->ion_auth->errors() ){
		            // display the create user form
		            // set the flash data error message if there is one
		            $data = array(
		            	"status" => "error",
		            	"message" => validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')),
                        "fields"  => $this->form_validation->error_array()
		            );
		            $this->output->set_content_type('application/json')->set_output(json_encode($data));

	            }
			}
		}

        if( !$this->form_validation->run() && !validation_errors() && !$this->ion_auth->errors() ){
			// display the edit user form
			$this->data['csrf'] = $this->_get_csrf_nonce();
			// pass the user to the view
			$this->data['user'] = $user;
			$this->data['groups'] = $groups;
            $this->data['currentGroups'] = $currentGroups;
            $this->data['is_biller'] = $is_biller;

			$this->data['first_name'] = array(
				'name'  => 'first_name',
				'id'    => 'first_name',
				'type'  => 'text',
	            'class' => 'form-control',
	            'autofocus' => 'autofocus',
				'value' => $this->form_validation->set_value('first_name', $user->first_name),
				'tabindex' => '1',
                'autocomplete' => 'off'
			);
			$this->data['last_name'] = array(
				'name'  => 'last_name',
				'id'    => 'last_name',
				'type'  => 'text',
	            'class' => 'form-control',
				'value' => $this->form_validation->set_value('last_name', $user->last_name),
                'autocomplete' => 'off'
			);
			$this->data['company'] = array(
				'name'  => 'company',
				'id'    => 'company',
				'type'  => 'text',
	            'class' => 'form-control',
				'value' => $this->form_validation->set_value('company', $user->company),
                'autocomplete' => 'off'
			);
			$this->data['phone'] = array(
				'name'  => 'phone',
				'id'    => 'phone',
				'type'  => 'text',
	            'class' => 'form-control',
				'value' => $this->form_validation->set_value('phone', $user->phone),
                'autocomplete' => 'off'
			);
			$this->data['password'] = array(
				'name' => 'password',
				'id'   => 'password',
				'type' => 'password',
	            'class' => 'form-control',
                'autocomplete' => 'new-password'
			);
			$this->data['password_confirm'] = array(
				'name' => 'password_confirm',
				'id'   => 'password_confirm',
				'type' => 'password',
	            'class' => 'form-control',
                'autocomplete' => 'new-password'
			);

			$this->_render_page('auth/edit_user', $this->data);
        }
	}

    public function delete($id = false)
    {
        if( VERSION == "DEMO" ){  // Action loaded only on release versions
            $result = array("status"=>"error", "message"=>lang("is_demo"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if($this->input->get('id')) { $id = $this->input->get('id'); }
        if ( !$id || !$this->ion_auth->in_group(array("admin", "superadmin")) || !$this->input->is_ajax_request() )
        {
            $result = array("status"=>"error", "message"=>lang("access_denied"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
            return false;
        }
        if ( $this->ion_auth->delete_user($id) )
        {
            $result = array("status"=>"success", "message"=>lang("delete_successful"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }else{
            $result = array("status"=>"error", "message"=>lang("delete_unsuccessful"));
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	public function _valid_csrf_nonce()
	{
		return TRUE;
	}

	public function _render_page($view, $data=null, $returnhtml=false)//I think this makes more sense
	{
		$this->viewdata = (empty($data)) ? $this->data: $data;
		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);
		if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
	}

}
