<?php
//////////////////////////////////////////////////////////////////
// This is our Custom Registration form for the front end: SRL //
////////////////////////////////////////////////////////////////
// NOTE: adding this /////// namespace Design_Approval_System;
// causes php errors from fucntion validation on line 126
class das_registration_form
{

	private $username;
	private $email;
	private $password;
	private $first_name;
	private $nickname;
	private $role;
	private $sendemail;

	function __construct()
	{

		add_shortcode('das_registration_form', array($this, 'shortcode'));
	}


	public function registration_form()
	{
		global $wp_roles;
		$current_user = wp_get_current_user();
		$roles = $current_user->roles;
		$role = array_shift($roles);
		$role_final = isset($wp_roles->role_names[$role]) ? translate_user_role($wp_roles->role_names[$role] ) : false;
?>
<?php if($role_final == 'Administrator' || $role_final == 'DAS Designer')  { ?>
<?php echo '<p class="das-create-post-error simple-das-error">'.__('Please fill out the <strong>Required</strong> options below to continue.', 'feed-them-social').'</p>' ?>

<h3><?php _e('Create New Customer', 'design-approval-system'); ?></h3>
<form method="post" action="<?php echo the_permalink(); ?>?tab=3">
  <div class="login-form">
    <p>
      <label><?php _e('Contact Name', 'design-approval-system'); ?> *</label>
      <input name="reg_nickname" type="text" class="form-control login-field"
                           value="<?php echo isset($_POST['reg_nickname']) ? $_POST['reg_nickname'] : null; ?>" id="reg-nickname" required/>
    </p>
    <p>
      <label><?php _e('Username: Customers Email Address', 'design-approval-system'); ?> *</label>
      <input name="reg_name" type="text" class="form-control login-field"
                           value="<?php echo isset($_POST['reg_name']) ? $_POST['reg_name'] : null; ?>" id="reg-name" required/>
    </p>
    <p>
      <label><?php _e('Customers Email Address', 'design-approval-system'); ?> *</label>
      <input name="reg_email" type="email" class="form-control login-field"
                           value="<?php echo isset($_POST['reg_email']) ? $_POST['reg_email'] : null; ?>"
                           placeholder="<?php _e('Email', 'design-approval-system'); ?>" id="reg-email" required/>
    </p>
    <p>
      <label><?php _e('Password', 'design-approval-system'); ?> *</label>
      <input name="reg_password" type="password" class="form-control login-field"
                           value="<?php echo isset($_POST['reg_password']) ? $_POST['reg_password'] : null; ?>"
                           placeholder="<?php _e('Password', 'design-approval-system'); ?>" id="reg-pass" required/>
    </p>
    <p>
      <label><?php _e('Send Login Information to Customer', 'design-approval-system'); ?></label>
      <input name="sendemail" type="checkbox" class="form-control login-field" id="sendemail" value="Yes" checked="checked"/>
      &nbsp; <small style="font-size:14px; line-height:16px;"><?php _e('Automatically email customer their login and password information.', 'design-approval-system'); ?></small></p>
    <input class="btn btn-primary btn-lg btn-block" type="text" name="reg_role" value="das_client" style="display:none"/>
    <input class="btn btn-primary btn-lg btn-block" type="submit" name="reg_submit" value="<?php _e('Register', 'design-approval-system'); ?>"/>
  </div>
</form>


<script>
jQuery(document).ready(function($) {
	  
  jQuery('.content-3 #submit').live('click', function( event ){
		 // Error Check
		 if(jQuery('#reg-nickname').val() == '' || jQuery('#reg-name').val() == '' || jQuery('#reg-email').val() == '' || jQuery('#reg-pass').val() == '') {
			jQuery('.das-create-post-error').show();
			// Animate the scrolling motion.
					jQuery("body, html").animate({
						scrollTop:0
					},"slow");	
		}
		// User Nickname
		if(jQuery('#reg-nickname').val() == '') {
			jQuery('.das-enter-order-number').addClass('das-error-input');
		}
		else {
			jQuery('.das-enter-order-number').removeClass('das-error-input');	
		}
		// User Name
		if(jQuery('#reg-name').val() == '') {
			jQuery('.das-enter-contact').addClass('das-error-input');
		}
		else {
			jQuery('.das-enter-contact').removeClass('das-error-input');	
		}
		// User Email
		if(jQuery('#reg-email').val() == '') {
			jQuery('.das-select-das-category').addClass('das-error-input');
		}
		else {
			jQuery('.das-select-das-category').removeClass('das-error-input');	
		}
		// User Pass
		 if(jQuery('#reg-pass').val() == '') {
			jQuery('.das-enter-content-media-etc').addClass('das-error-input');
		}
		else {
			jQuery('.das-enter-content-media-etc').removeClass('das-error-input');	
		}
		 event.preventDefault();
 	});
 });
 </script>
 
<?php
		}
		else {
?>
<h3><?php _e('Create New Customer', 'design-approval-system'); ?></h3>
<p><?php _e('Please', 'design-approval-system'); ?><a href="<?php echo wp_login_url( get_permalink() . '?tab=3' ); ?>" title="Login"><?php _e('Login', 'design-approval-system'); ?></a> <?php _e('to create a new Customer.', 'design-approval-system'); ?></p>
<?php
		}
	}

function validation()
	{
		if (empty($this->username) || empty($this->password) || empty($this->email)  || empty($this->nickname)) {

			return new WP_Error('field', '<p class="simple-das-error">'.__('Required form field is missing', 'design-approval-system').'</p>');
		}

		if (strlen($this->nickname) < 3) {
			return new WP_Error('username_length', '<p class="simple-das-error">'.__('Client Name is too short. At least 3 characters is required', 'design-approval-system').'</p>');
		}


		if (strlen($this->username) < 4) {
			return new WP_Error('username_length', '<p class="simple-das-error">'.__('Username too short. At least 4 characters is required', 'design-approval-system').'</p>');
		}

		if (strlen($this->password) < 5) {
			return new WP_Error('password', '<p class="simple-das-error">'.__('Password length must be greater than 5', 'design-approval-system').'</p>');
		}

		if (!is_email($this->email)) {
			return new WP_Error('email_invalid', '<p class="simple-das-error">'.__('Email is not valid', 'design-approval-system').'</p>');
		}

		if (email_exists($this->email)) {
			return new WP_Error('email', '<p class="simple-das-error">'.__('Email Already in use', 'design-approval-system').'</p>');
		}
		$details = array(
			'Username' => $this->username,
			//  'First Name' => $this->first_name,
			'Nickname' => $this->nickname,
		);

		foreach ($details as $field => $detail) {
			if (!validate_username($detail)) {
				return new WP_Error('name_invalid', '<p class="simple-das-error">'.__('Sorry, the "' . $field . '" you entered is not valid', 'design-approval-system').'</p>');
			}
		}

	}

	function registration()
	{

		$userdata = array(
			'user_login' => esc_attr($this->username),
			'user_email' => esc_attr($this->email),
			'user_pass' => esc_attr($this->password),
			'first_name' => esc_attr($this->nickname),
			'nickname' => esc_attr($this->nickname),
			'role' => esc_attr($this->role),
		);

		if (is_wp_error($this->validation())) {
			echo '<div style="margin-bottom: 6px" class="btn btn-block btn-lg btn-danger">';
			echo $this->validation()->get_error_message();
			echo '</div>';
		} else {
			$register_user = wp_insert_user($userdata);
			if (!is_wp_error($register_user)) {

				// if our checkbox is check to send email to client about signing up
				if(isset($_POST['sendemail']) == 'Yes') {

					// Build the message
					$message  = '<p>'. get_option("das-settings-register-new-das-client") .'</p>

<strong>' . $this->nickname . '</strong><br/>
<strong>'.__('Username', 'design-approval-system').':</strong> ' . $this->username . '<br/>
<strong>'.__('Password', 'design-approval-system').':</strong> ' . $this->password . '<br/><br/>';

					//set the form headers
					// Not going to use this first header for now....  $headers [] = array('Content-Type: text/html; charset=UTF-8');
					$headers [] = __('From', 'design-approval-system').': '. get_option("das-settings-company-name") .'<'.get_option("das-settings-company-email").'>';
					// $headers [] = 'Cc: '. get_option("das-settings-company-name").'<'.get_option("das-settings-company-email").'>';

					// The email subject
					$subject = __('Registration Setup from', 'design-approval-system').' ' . get_option("das-settings-company-name");

					// Who are we going to send this form too
					$send_to = $this->email;

					add_filter( 'wp_mail_content_type', 'set_html_content_type' );


					// Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
					remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

					add_filter( 'wp_mail_content_type', function( $message ) {
							return 'text/html';
						});

					if ( wp_mail( $send_to, $subject, $message, $headers ) ) {
						// wp_redirect( $redirect ); exit;
					}
				} // end if checkbox checked to sendmail
				echo '<div style="margin-bottom: 6px" class="btn btn-block btn-lg btn-danger simple-das-notice">';
				echo '<strong>Registration complete.</strong> ';
				if (isset($_POST['sendemail']) == 'Yes') {
					 _e($this->username."'s email and password have also been emailed to them.", 'design-approval-system');
					
				}
				echo '</div>';
			} else {
				echo '<div style="margin-bottom: 6px" class="btn btn-block btn-lg btn-danger simple-das-notice">';
				echo '<strong>' . $register_user->get_error_message() . '</strong>';
				echo '</div>';
			}

		}
	}

	function shortcode()
	{

		ob_start();

		if (isset($_POST['reg_submit'])) {
			$this->username = $_POST['reg_name'];
			$this->email = $_POST['reg_email'];
			$this->password = $_POST['reg_password'];
			$this->first_name = $_POST['reg_nickname'];
			$this->nickname = $_POST['reg_nickname'];
			$this->role = $_POST['reg_role'];

			$this->validation();
			$this->registration();
		}

		$this->registration_form();
		return ob_get_clean();
	}

}
new das_registration_form;