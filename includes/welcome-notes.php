<?php
/**
 * Theme Activation Tour For Post Profit Stats PRO
 *
 * This class handles the pointers used in the introduction tour.
 * @package Popup Demo
 *
 */
 
class WordImpress_Theme_Tour_design_approval_system {
 
    private $pointer_close_id = 'dasplugin_tour1'; // MUST CHANGE THIS NAME FOR EACH PLUGIN UPDATE IF WE WANT TO TELL PEOPLE ABOUT NEW CHANGES. THE NUMBER IS THE VERSION OF PLUGIN
 
    /**
     * Class constructor.
     *
     * If user is on a pre pointer version bounce out.
     */
    function __construct() {
        global $wp_version;
 
        //pre 3.3 has no pointers
        if (version_compare($wp_version, '3.4', '<'))
            return false;
 
        //version is updated ::claps:: proceed
        add_action('admin_enqueue_scripts', array($this, 'enqueue'));
    }
 
    /**
     * Enqueue styles and scripts needed for the pointers.
     */
    function enqueue() {
        if (!current_user_can('manage_options'))
            return;
 
        // Assume pointer shouldn't be shown
        $enqueue_pointer_script_style = false;
 
        // Get array list of dismissed pointers for current user and convert it to array
        $dismissed_pointers = explode(',', get_user_meta(get_current_user_id(), 'dismissed_wp_pointers', true));
 
        // Check if our pointer is not among dismissed ones
        if (!in_array($this->pointer_close_id, $dismissed_pointers)) {
            $enqueue_pointer_script_style = true;
 
            // Add footer scripts using callback function
            add_action('admin_print_footer_scripts', array($this, 'das_intro_tour'));
        }
 
        // Enqueue pointer CSS and JS files, if needed
        if ($enqueue_pointer_script_style) {
            wp_enqueue_style('wp-pointer');
            wp_enqueue_script('wp-pointer');
        }
 
    }
 
 
    /**
     * Load the introduction tour
     */
    function das_intro_tour() {
 
        $adminpages = array(
 
            //array name is the unique ID of the screen @see: http://codex.wordpress.org/Function_Reference/get_current_screen
			// WELCOME POINTER ON WP ADMIN PLUGINS PAGE
            'plugins' => array(
                'content' => "<h3>" . __("Welcome to the Design Approval System", 'design-approval-system') . "</h3>"
                    . "<p>" . __("<p>You have just installed the Design Approval System. Congrats! Take a moment and see the short tour on how to get things setup. You can restart this tour at any time on our <a href='edit.php?post_type=designapprovalsystem&page=design-approval-system-help-page' style='text-decoration:none;'>help page</a>.</p><p>If you don't already, we highly suggest installing the free <a href='plugin-install.php?tab=search&s=duplicate+post&plugin-search-input=Search+Plugins' style='text-decoration:none;'>Duplicate Post Plugin</a> to help make the task of creating versions for clients easier. Install that plugin and once activated you will return to this message so you can continue the tour.", 'design-approval-system') . "</p>", //Content for this pointer
                'id' => 'menu-plugins', //ID of element where the pointer will point
                'position' => array(
                    'edge' => 'left', //Arrow position; change depending on where the element is located
                    'align' => 'center' //Alignment of Pointer
                ),
				'button2' => __('Next', 'design-approval-system'), //text for the next button
                'function' => 'window.location="' . admin_url('edit.php?post_type=designapprovalsystem&page=design-approval-system-projects-page') . '";' //where to take the user
            ),
		
			// PROJECTS POINTER
            'design-approval-system-projects-page' => array(
                'content' => '<h3>' . __('Project Board', 'design-approval-system') . '</h3>' . __('<p>This page shows all of your clients and projects. You can view the details of each design, and if a design is approved a STAR will appear next to that project and design version.</p> <p>By following the Next <strong>3 steps</strong> in our walk-through your project board will come alive!</p><p><strong>Step 1:</strong> Make sure you have filled out the details in our <a href="edit.php?post_type=designapprovalsystem&page=design-approval-system-settings-page" style="text-decoration:none;">Settings Page</a></p>', 'textdomain'),
				 'position' => array(
                    'edge' => 'left', //Arrow position; change depending on where the element is located
                    'align' => 'top' //Alignment of Pointer
                ),
				
                'id' => 'menu-posts-designapprovalsystem',
                'button2' => __('Next', 'textdomain'),
                'function' => 'window.location="' . admin_url('edit-tags.php?taxonomy=das_categories&post_type=designapprovalsystem') . '";'
            ),
			
			// PROJECT NAMES POINTER
			 'edit-das_categories' => array(
                'content' => '<h3>' . __('Project Names', 'design-approval-system') . '</h3>' . __('<p><strong>Step 2:</strong> Create a Project Name.<br>Make your name relative to your client and your project. Like this example,</p><p><i>Bomber Eyewear – Home Trial</i></p><p>This will make it easy to see quickly what project is for what client.</p>', 'textdomain'),
				 'position' => array(
                    'edge' => 'left', //Arrow position; change depending on where the element is located
                    'align' => 'top' //Alignment of Pointer
                ),
				
                'id' => 'menu-posts-designapprovalsystem',
                'button2' => __('Next', 'textdomain'),
                'function' => 'window.location="' . admin_url('post-new.php?post_type=designapprovalsystem') . '";'
            ),
			
			// ADD NEW DESIGN PAGE POINTER
			 'designapprovalsystem' => array(
                'content' => '<h3>' . __('Add New Design Page', 'design-approval-system') . '</h3>' . __('<p><strong>Step 3:</strong> Add a New Design.<br>Fill out the title with the name of your client and project. This is how we do it:</p><p><i>Bomber Eyewear, Home Trial V1</i></p><p>Then add your photo, video, music, or whatever you need approved into the large textbox on the page.</p> <p>Fill out the Design Approval Fields, making sure to enter your clients name and email.</p><p>Finally, make sure and check your Project Name for this Design version in the right sidebar and add a Featured Image. This is very important as it is what helps organize the Project Board.</p><p>Now your project board should have one project and a design version.</p>', 'textdomain'),
				 'position' => array(
                    'edge' => 'left', //Arrow position; change depending on where the element is located
                    'align' => 'top' //Alignment of Pointer
                ),
				
                'id' => 'menu-posts-designapprovalsystem',
                'button2' => __('Next', 'textdomain'),
                'function' => 'window.location="' . admin_url('edit.php?post_type=designapprovalsystem') . '";'
            ),
			
			// ALL YOUR DESIGNS PAGE POINTER
			 'edit-designapprovalsystem' => array(
                'content' => '<h3>' . __('All Your Designs', 'design-approval-system') . '</h3>' . __('<p>This page displays a list of all your designs with a date title and author (designer name).</p> <p>You can also edit, add new or delete designs here too.</p>', 'textdomain'),
				 'position' => array(
                    'edge' => 'left', //Arrow position; change depending on where the element is located
                    'align' => 'top' //Alignment of Pointer
                ),
				
                'id' => 'menu-posts-designapprovalsystem',
                'button2' => __('Next', 'textdomain'),
                'function' => 'window.location="' . admin_url('users.php?role=das_client') . '";'
            ), 
			
			
			// DAS CLIENTS/USERS PAGE POINTER
			 'users' => array(
                'content' => '<h3>' . __('DAS Clients & DAS Designers', 'design-approval-system') . '</h3>' . __('<p>This page displays a list of all your clients that you will have signed up on the <a href="user-new.php"  style="text-decoration:none">add new users</a> page.</p> <p>IMPORTANT: Make sure your designs have the client(s) email you signed them up with so only your client can see his/her projects when they login.</p><p>When you sign up a DAS Designer and they login they will be able to see all of wordpress, but they can not edit your main wordpress settings. You can view a list of your DAS Designers by choosing the option above.</p><p>If you would like to control what the clients or designers see when logging in we suggest using a user role manager plugin. We use and like <a href="http://codecanyon.net/item/white-label-branding-for-wordpress/125617" style="text-decoration:none" target="_blank">this one</a>.</p>', 'textdomain'),
				 'position' => array(
                    'edge' => 'left', //Arrow position; change depending on where the element is located
                    'align' => 'center' //Alignment of Pointer
                ),
				
                'id' => 'menu-users',
                'button2' => __('Next', 'textdomain'),
                'function' => 'window.location="' . admin_url('edit.php?post_type=designapprovalsystem&page=design-approval-system-help-page') . '";'
            ), 
			
			
			// HELP PAGE POINTER
			 'design-approval-system-help-page' => array(
                'content' => '<h3>' . __('DAS Info and Help', 'design-approval-system') . '</h3>' . __('<p>You can find some good FAQS here, along with system settings about your worpress and the Design Approval System Version.</p><p>IMPORTANT: If you need help and want to submit an email or post on our support forum, please make sure and copy the System Info information on this page.</p>', 'textdomain'),
				 'position' => array(
                    'edge' => 'left', //Arrow position; change depending on where the element is located
                    'align' => 'top' //Alignment of Pointer
                ),
				
                'id' => 'menu-posts-designapprovalsystem',
                'button2' => __('Next', 'textdomain'),
                'function' => 'window.location="' . admin_url('edit.php?post_type=designapprovalsystem&page=design-approval-system-settings-page') . '";'
            ), 
			
			
			// SETTINGS PAGE POINTER
			 'design-approval-system-settings-page' => array(
                'content' => '<h3>' . __('Settings', 'design-approval-system') . '</h3>' . __('<p>This is what makes the Design Approval System work. Add your company logo, company name and email address to get started right away.</p><p>You can also customize the email for client message and the Approved Digital Signature email message that goes to your clients and more. Many other options will appear here with our premium extensions. ', 'textdomain'),
				 'position' => array(
                    'edge' => 'left', //Arrow position; change depending on where the element is located
                    'align' => 'top' //Alignment of Pointer
                ),
				   'id' => 'menu-posts-designapprovalsystem',
            ), 
			
        );

 
        $page = '';
        $screen = get_current_screen();
 
 
        //Check which page the user is on
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }
        if (empty($page)) {
            $page = $screen->id;
        }
 
        $function = '';
        $button2 = '';
        $opt_arr = array();
 
        //Location the pointer points
        if (!empty($adminpages[$page]['id'])) {
            $id = '#' . $adminpages[$page]['id'];
        } else {
            $id = '#' . $screen->id;
        }
 
 
        //Options array for pointer used to send to JS
        if ('' != $page && in_array($page, array_keys($adminpages))) {
            $align = (is_rtl()) ? 'right' : 'left';
            $opt_arr = array(
                'content' => $adminpages[$page]['content'],
                'position' => array(
                    'edge' => (!empty($adminpages[$page]['position']['edge'])) ? $adminpages[$page]['position']['edge'] : 'left',
                    'align' => (!empty($adminpages[$page]['position']['align'])) ? $adminpages[$page]['position']['align'] : $align
                ),
                'pointerWidth' => 400
            );
			
            if (isset($adminpages[$page]['button2']) && isset($adminpages[$page]['button2'])) {
                $button2 = (!empty($adminpages[$page]['button2'])) ? $adminpages[$page]['button2'] : __('Next', 'design-approval-system');
            }
            if (isset($adminpages[$page]['function'])) {
                $function = $adminpages[$page]['function'];
            }
			 if (isset($adminpages[$page]['function2'])) {
                $function = $adminpages[$page]['function2'];
            }
        }
 
        $this->print_scripts($id, $opt_arr, __("Close", 'design-approval-system'), $button2, $function);
    }
 
 
    /**
     * Prints the pointer script
     *
     * @param string $selector The CSS selector the pointer is attached to.
     * @param array $options The options for the pointer.
     * @param string $button1 Text for button 1
     * @param string|bool $button2 Text for button 2 (or false to not show it, defaults to false)
     * @param string $button2_function The JavaScript function to attach to button 2
     * @param string $button1_function The JavaScript function to attach to button 1
     */
    function print_scripts($selector, $options, $button1, $button2 = false, $button2_function = '', $button1_function = '') {
        ?>
        <script type="text/javascript">
            //<![CDATA[
            (function ($) {
 
                var wordimpress_pointer_options = <?php echo json_encode( $options ); ?>, setup;
 
                //Userful info here
                wordimpress_pointer_options = $.extend(wordimpress_pointer_options, {
                    buttons: function (event, t) {
                        button = jQuery('<a id="pointer-close" style="margin:0 0 0 5px;" class="button-secondary">' + '<?php echo $button1; ?>' + '</a> ');
                        button.bind('click.pointer', function () {
                            t.element.pointer('close');
                        });
                        return button;
                    }
                });
 
                setup = function () {
                  
					
					  jQuery('<?php echo $selector; ?>').pointer(wordimpress_pointer_options).pointer('open');
				 jQuery('#pointer-close').after('<style>body.plugins-php #pointer-back { display:none }</style><a id="pointer-back" class="button-primary" style="float:left; " href="javascript:history.back();">Back</a>');
				 
				 
                    <?php 
                    if ( $button2 ) { ?>
                    jQuery('#pointer-close').after('<a id="pointer-primary" class="button-primary" style="float:left;margin-right:5px;">' + '<?php echo $button2; ?>' + '</a> ');
                    <?php } ?>
					
					
					 jQuery('#pointer-back').click(function () {
                        <?php echo $button3_function; ?>
                    });
                    jQuery('#pointer-primary').click(function () {
                        <?php echo $button2_function; ?>
                    });
                    jQuery('#pointer-close').click(function () {
                        <?php if ( $button1_function == '' ) { ?>
                        $.post(ajaxurl, {
                            pointer: '<?php echo $this->pointer_close_id; ?>', // pointer ID
                            action: 'dismiss-wp-pointer'
                        });
 						
                        <?php } else { ?>
                        <?php echo $button1_function;
						 ?> 
						  
                        <?php } ?>
                    });
 
                };
 
                if (wordimpress_pointer_options.position && wordimpress_pointer_options.position.defer_loading) {
                    $(window).bind('load.wp-pointers', setup);
                } else {
 
                    $(document).ready(setup);
                }
 
            })(jQuery);
            //]]>
        </script>
    <?php
    }
}
$wordimpress_theme_tour = new WordImpress_Theme_Tour_design_approval_system();