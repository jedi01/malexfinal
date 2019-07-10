<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth
*
* Author: Ben Edmunds
*		  ben.edmunds@gmail.com
*         @benedmunds
*
* Added Awesomeness: Phil Sturgeon
*
* Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
*
* Created:  10.01.2009
*
* Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
* Original Author name has been kept but that does not mean that the method has not been modified.
*
* Requirements: PHP5 or above
*
*/

class Ion_auth
{
	/**
	 * account status ('not_activated', etc ...)
	 *
	 * @var string
	 **/
	protected $status;

	/**
	 * extra where
	 *
	 * @var array
	 **/
	public $_extra_where = array();

	/**
	 * extra set
	 *
	 * @var array
	 **/
	public $_extra_set = array();

	/**
	 * caching of users and their groups
	 *
	 * @var array
	 **/
	public $_cache_user_in_group;

	/**
	 * __construct
	 *
	 * @author Ben
	 */
	public function __construct()
	{
		$this->load->config('ion_auth', TRUE);
		$this->load->library(array('email'));
		$this->load->helper(array('cookie', 'language','url'));

		$this->load->library('session');

		$this->load->model('ion_auth_model');

		$this->_cache_user_in_group =& $this->ion_auth_model->_cache_user_in_group;

		//auto-login the user if they are remembered
		if (!$this->logged_in() && get_cookie($this->config->item('identity_cookie_name', 'ion_auth')) && get_cookie($this->config->item('remember_cookie_name', 'ion_auth')))
		{
			$this->ion_auth_model->login_remembered_user();
		}

		$this->ion_auth_model->trigger_events('library_constructor');
	}

	/**
	 * __call
	 *
	 * Acts as a simple way to call model methods without loads of stupid alias'
	 *
	 * @param $method
	 * @param $arguments
	 * @return mixed
	 * @throws Exception
	 */
	public function __call($method, $arguments)
	{
		if (!method_exists( $this->ion_auth_model, $method) )
		{
			throw new Exception('Undefined method Ion_auth::' . $method . '() called');
		}
		if($method == 'create_user')
		{
			return call_user_func_array(array($this, 'register'), $arguments);
		}
		if($method=='update_user')
		{
			return call_user_func_array(array($this, 'update'), $arguments);
		}
		return call_user_func_array( array($this->ion_auth_model, $method), $arguments);
	}

	/**
	 * __get
	 *
	 * Enables the use of CI super-global without having to define an extra variable.
	 *
	 * I can't remember where I first saw this, so thank you if you are the original author. -Militis
	 *
	 * @access	public
	 * @param	$var
	 * @return	mixed
	 */
	public function __get($var)
	{
		return get_instance()->$var;
	}


	/**
	 * forgotten password feature
	 *
	 * @param $identity
	 * @return mixed boolean / array
	 * @author Mathew
	 */
	public function forgotten_password($identity)    //changed $email to $identity
	{
		if ( $this->ion_auth_model->forgotten_password($identity) )   //changed
		{
			// Get user information
			$identifier = $this->ion_auth_model->identity_column; // use model identity column, so it can be overridden in a controller
			$user = $this->where($identifier, $identity)->where('active', 1)->users()->row();  // changed to get_user_by_identity from email

			if ($user)
			{
		        $template = $this->settings_model->getEmailTemplate("send_forgotten_password.tpl", LANGUAGE);
		        $company  = $this->settings_model->getSettings("COMPANY");
	            $data['email_content'] = parse_object_sis($template->content, $company, false, false, false, $user);
	            $data['show_email_caution'] = true;
	            $message = $this->load->view("email/standard.tpl.php", $data, true);
	        	$email_config = objectToArray($this->settings_model->email_Settings);
				$this->email->initialize($email_config);
				$this->email->clear();
				$this->email->from(COMPANY_EMAIL, COMPANY_NAME);
				$this->email->to($user->email);
				$this->email->subject(parse_object_sis($template->subject, $company, false, false, false, $user));
				$this->email->message($message);

				if ($this->email->send())
				{
					$this->set_message('forgot_password_successful');
					return TRUE;
				}
				else
				{
					$this->set_error('forgot_password_unsuccessful');
					return FALSE;
				}
			}
			else
			{
				$this->set_error('forgot_password_unsuccessful');
				return FALSE;
			}
		}
		else
		{
			$this->set_error('forgot_password_unsuccessful');
			return FALSE;
		}
	}

	/**
	 * forgotten_password_check
	 *
	 * @param $code
	 * @author Michael
	 * @return bool
	 */
	public function forgotten_password_check($code)
	{
		$profile = $this->where('forgotten_password_code', $code)->users()->row(); //pass the code to profile

		if (!is_object($profile))
		{
			$this->set_error('password_change_unsuccessful');
			return FALSE;
		}
		else
		{
			if ($this->config->item('forgot_password_expiration', 'ion_auth') > 0) {
				//Make sure it isn't expired
				$expiration = $this->config->item('forgot_password_expiration', 'ion_auth');
				if (time() - $profile->forgotten_password_time > $expiration) {
					//it has expired
					$this->clear_forgotten_password_code($code);
					$this->set_error('password_change_unsuccessful');
					return FALSE;
				}
			}
			return $profile;
		}
	}

	/**
	 * register
	 *
	 * @param $identity
	 * @param $password
	 * @param $email
	 * @param array $additional_data
	 * @param array $group_ids
	 * @author Mathew
	 * @return bool
	 */
	public function register($identity, $password, $email, $additional_data = array(), $group_ids = array(), $complete = false)
	{
		$this->ion_auth_model->trigger_events('pre_account_creation');

		$email_activation = $this->config->item('email_activation', 'ion_auth');

		$id = $this->ion_auth_model->register($identity, $password, $email, $additional_data, $group_ids);

		if (!$email_activation)
		{
			if ($id !== FALSE)
			{
				$this->set_message('account_creation_successful');
				$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_successful'));
				return $id;
			}
			else
			{
				$this->set_error('account_creation_unsuccessful');
				$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_unsuccessful'));
				return FALSE;
			}
		}
		else
		{
			if (!$id)
			{
				$this->set_error('account_creation_unsuccessful');
				return FALSE;
			}

			// deactivate so the user much follow the activation flow
			$deactivate = $this->ion_auth_model->deactivate($id);

			// the deactivate method call adds a message, here we need to clear that
			$this->ion_auth_model->clear_messages();


			if (!$deactivate)
			{
				$this->set_error('deactivate_unsuccessful');
				$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_unsuccessful'));
				return FALSE;
			}

			$activation_code = $this->ion_auth_model->activation_code;
			$identity        = $this->config->item('identity', 'ion_auth');
			$user            = $this->ion_auth_model->user($id)->row();
			$user->activation_code = $activation_code;

			if( $complete ){
		        $template = $this->settings_model->getEmailTemplate("send_activate_customer.tpl", LANGUAGE);
		    }else{
		        $template = $this->settings_model->getEmailTemplate("send_activate.tpl", LANGUAGE);
		    }
	        $company  = $this->settings_model->getSettings("COMPANY");
            $content  = parse_object_sis($template->content, $company, false, false, false, $user);

			if( $complete ){
				$content = parse_text_sis($content, "{{user_password}}", $password);
			}

            $data['email_content']      = $content;
            $data['show_email_caution'] = true;
            $message = $this->load->view("email/standard.tpl.php", $data, true);

	        $email_config = objectToArray($this->settings_model->email_Settings);
			$this->email->initialize($email_config);
			$this->email->clear();
			$this->email->from(COMPANY_EMAIL, COMPANY_NAME);
			$this->email->to($email);
			$this->email->subject(parse_object_sis($template->subject, $company, false, false, false, $user));
			$this->email->message($message);

			if ($this->email->send() == TRUE)
			{
				$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_successful', 'activation_email_successful'));
				$this->set_message('activation_email_successful');
				return $id;
			}

			$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_unsuccessful', 'activation_email_unsuccessful'));
			$this->set_error('activation_email_unsuccessful');
			return $id;
		}
	}

	/**
	 * logout
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function logout()
	{
		$this->ion_auth_model->trigger_events('logout');

		$identity = $this->config->item('identity', 'ion_auth');

                if (substr(CI_VERSION, 0, 1) == '2')
		{
			$this->session->unset_userdata( array($identity => '', 'id' => '', 'user_id' => '') );
                }
                else
                {
                	$this->session->unset_userdata( array($identity, 'id', 'user_id') );
                }

		// delete the remember me cookies if they exist
		if (get_cookie($this->config->item('identity_cookie_name', 'ion_auth')))
		{
			delete_cookie($this->config->item('identity_cookie_name', 'ion_auth'));
		}
		if (get_cookie($this->config->item('remember_cookie_name', 'ion_auth')))
		{
			delete_cookie($this->config->item('remember_cookie_name', 'ion_auth'));
		}

		// Destroy the session
		$this->session->sess_destroy();

		//Recreate the session
		if (substr(CI_VERSION, 0, 1) == '2')
		{
			$this->session->sess_create();
		}
		else
		{
			if (version_compare(PHP_VERSION, '7.0.0') >= 0) {
				session_start();
			}
			$this->session->sess_regenerate(TRUE);
		}

		$this->set_message('logout_successful');
		return TRUE;
	}

	/**
	 * logged_in
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function logged_in()
	{
		$this->ion_auth_model->trigger_events('logged_in');

		return (bool) $this->session->userdata('identity');
	}

	/**
	 * logged_in
	 *
	 * @return integer
	 * @author jrmadsen67
	 **/
	public function get_user_id()
	{
		$user_id = $this->session->userdata('user_id');
		if (!empty($user_id))
		{
			return $user_id;
		}
		return null;
	}


	/**
	 * is_admin
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function is_admin($id=false)
	{
		$this->ion_auth_model->trigger_events('is_admin');

		$admin_group = $this->config->item('admin_group', 'ion_auth');

		return $this->in_group($admin_group, $id);
	}


	/**
	 * is_member
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function is_member($id=false)
	{
		$this->ion_auth_model->trigger_events('is_member');

		return $this->in_group("Members", $id) && !$this->in_group(array("admin", "superadmin"), $id);
	}

	/**
	 * in_group
	 *
	 * @param mixed group(s) to check
	 * @param bool user id
	 * @param bool check if all groups is present, or any of the groups
	 *
	 * @return bool
	 * @author Phil Sturgeon
	 **/
	public function in_group($check_group, $id=false, $check_all = false)
	{
		$this->ion_auth_model->trigger_events('in_group');

		$id || $id = $this->session->userdata('user_id');

		if (!is_array($check_group))
		{
			$check_group = array($check_group);
		}

		if (isset($this->_cache_user_in_group[$id]))
		{
			$groups_array = $this->_cache_user_in_group[$id];
		}
		else
		{
			$users_groups = $this->ion_auth_model->get_users_groups($id)->result();
			$groups_array = array();
			foreach ($users_groups as $group)
			{
				$groups_array[$group->id] = $group->name;
			}
			$this->_cache_user_in_group[$id] = $groups_array;
		}
		foreach ($check_group as $key => $value)
		{
			$groups = (is_string($value)) ? $groups_array : array_keys($groups_array);

			/**
			 * if !all (default), in_array
			 * if all, !in_array
			 */
			if (in_array($value, $groups) xor $check_all)
			{
				/**
				 * if !all (default), true
				 * if all, false
				 */
				return !$check_all;
			}
		}

		/**
		 * if !all (default), false
		 * if all, true
		 */
		return $check_all;
	}

	public function clear_tags($str)
	{
		return htmlentities(strip_tags($str, '<code><span><div><label><a><br><p><b><i><del><strike><u><img><video><audio><iframe><object><embed><param><blockquote><mark><cite><small><ul><ol><li><hr><dl><dt><dd><sup><sub><big><pre><code><figure><figcaption><strong><em><table><tr><td><th><tbody><thead><tfoot><h3><h4><h5><h6>'));
	}
}
