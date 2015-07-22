<?php
namespace Design_Approval_System;
class Project_Board extends Design_Approval_System_Core {
	function __construct() {
		//Admin Styles and Scripts for Settings Page
		if (isset($_GET['page']) && $_GET['page'] == 'design-approval-system-projects-page') {
			add_action('admin_enqueue_scripts', array( $this, 'das_projects_settings_admin_scripts'));
		}
		//Front End
		add_action('init', array( $this, 'add_functions'));
		add_action('init', array( $this, 'taxonomy_register_settings'));
		add_action('admin_init', array( $this, 'das_pagination_settings'));
		add_action('init', array( $this, 'das_pagination_settings'));
	}
	//**************************************************
	// Admin Styles and Scripts for Settings Page
	//**************************************************
	function das_projects_settings_admin_scripts() {
		wp_register_style('og-admin-css', plugins_url( 'design-approval-system/admin/css/admin-settings.css'));
		wp_enqueue_style( 'og-admin-css' );
	}
	//**************************************************
	// Add Premium functions
	//**************************************************
	function add_functions() {
		add_shortcode('DASPublicBoard', array( $this, 'das_public_project_board_function'));
		add_shortcode('DASPrivateBoard', array( $this, 'das_private_project_board_function'));
		add_shortcode('DASFrontEndManager', array( $this, 'frontend_design_mananger'));
	}
	//**************************************************
	// Register Taxonomy Metadata
	//**************************************************
	function taxonomy_register_settings() {
		//Register Login Settting Options
		$taxonomy_options = array(
			'taxonomy_term_meta_das_pb_board2',
		);
		$this->register_settings('taxonomy_term_meta_das_pb_board2', $taxonomy_options);
	}
	//**************************************************
	// Pagination
	//**************************************************
	function das_pagination_settings() {
		$taxonomy_options = array(
			'das_pagination_amount_per_page',
		);
		$this->register_settings( 'das_pagination_settings', $taxonomy_options);
	}
	//**************************************************
	// Display Private Project Board
	//**************************************************
	function das_private_project_board_function() {
		$das_project_rename_plural = get_option('das-settings-plural-pb-fep-name') ? get_option('das-settings-plural-pb-fep-name') : __('Projects', 'design-approval-system');
		if ( current_user_can('administrator') || current_user_can('das_designer') ) {
			print do_shortcode('[DASPublicBoard]');
		}
		elseif ( current_user_can('das_client')) {
			ob_start();
			$output = '';
			$output .=  '<div class="das-project-admin-wrap das-private-pb-wrap">';
			$user_id = isset($current_user->ID) ? $current_user->ID : '';
			$user_blogs = get_blogs_of_user( $user_id );
			foreach ($user_blogs as $user_blog) {
				if ($user_blog->path == '/') {
					# do nothing
				}
				else {
					$user_blog_id = $user_blog->userblog_id;
				}
			}
			$user = wp_get_current_user();
			$this_users_email = $user->user_email;
			//Custom DAS Post Type
			$post_type = 'designapprovalsystem';
			//Custom DAS Taxonomies (aka Categories)
			$tax = 'das_categories';
			$client = get_terms( $tax );
			//Client and Terms arrays.
			$clients_emails = array();
			$clients_names = array();
			$term_names = array();
			$post_counts = array();
			//Loop to custom taxonomy to build Client and Terms arrays.
			foreach ($client as $term) :
				$args = array(
					'post_type' => $post_type,
					'post_per_page' => -1,
					'nopaging' => true,
					'post_status'   => 'publish',
					'ignore_sticky_posts' => 1,
					'tax_query' => array(
						array(
							'taxonomy' => $tax,
							'field'    => 'ID',
							'terms'   => array( $term->term_id )
						),
					),
					'orderby' => 'title',
					'order' => 'ASC'
				);
			$my_query2 = new \WP_Query($args);
			$post_counts[] = $my_query2->post_count;
			if ( $my_query2->have_posts() ) :
				while ( $my_query2->have_posts() ) : $my_query2->the_post(); global $post;
			$clients_email = get_post_meta($post->ID, 'custom_clients_email', true);
			$clients_emails[] = $clients_email;
			$term_names[$term->name] = $clients_email;
			$clients_names[] = get_post_meta($post->ID, 'custom_client_name', true);
			$title_approved_checker = get_post_meta($post->ID, 'custom_client_approved', true);
			$approved_main_designs_count[$clients_email][$term->name][] = $title_approved_checker;
			endwhile; endif;
			endforeach;
			//END Build Arrays
			//Clean up Clients Array So no duplicate client titles happen.
			$final_clients_emails = array_unique($clients_emails);
			//Start loop for displaying Client Name [Final Build loop]
			foreach ($final_clients_emails as $key => $value)  :
				if ($value == $this_users_email) {
					foreach ($clients_names as $number => $title) {
						if ($number == $key) {
							$client_title = $title;
						}
					}
					//Client Name
					$output .=  "<h2>".$client_title."</h2>";
					$output .= '<div class="clear-h2"></div>';
					//Client Name value for check.
					$client_value = $value;
					$counter = 0;
					//loop for displaying Project Name
					foreach ($term_names as $key => $value) :
						$term_value = $value;
					if ($client_value == $value) {
						$output .=  '<h3 class="pb-cat-header">'.$key;
						if (in_array("Yes", $approved_main_designs_count[$value][$key])) {
							if (is_plugin_active('das-premium/das-premium.php') && is_plugin_active('design-approval-system/design-approval-system.php')) {
								$output .= '<div class="das-approved-design-subtitle das-premium-star"></div>';
							}
							else {
								$output .= '<div class="das-approved-design-subtitle"></div>';
							}
						}
						$output .=  '<span>'.$post_counts[$counter].'</span></h3>';
						$output .=  "<div class='das-project-list-wrap'>";
						$output .=  "<ul class='das-project-list'>";
						//loop for displaying posts for Project
						foreach ($client as $term) :
							$args = array(
								'post_type' => $post_type,
								'post_per_page'     => -1,
								'nopaging'          => true,
								'post_status'       => 'publish',
								'ignore_sticky_posts'  => 1,
								'orderby'     => 'date',
								'order'             => 'ASC',
								'tax_query'         => array(
									array(
										'taxonomy' => $tax,
										'field'    => 'ID',
										'terms'    => array( $term->term_id )
									),
								),
								'orderby'          => 'date',
								'order'            => 'ASC'
							);
						$my_query = new \WP_Query($args);
						if ( $my_query->have_posts() ) : ?>
<?php while ( $my_query->have_posts() ) : $my_query->the_post(); global $post;
						$final_client_value = get_post_meta($post->ID, 'custom_clients_email', true);
						$final_term_value = $term->name;
						//Design Link creation
						if (($term_value == $final_client_value) && ($key == $final_term_value)) {
							$output .=  '<li>';
							$dirDASplugin = plugin_dir_path(__FILE__ );
							include $dirDASplugin . '../includes/das-project-boards.php';
							$output .=  '</li>';
						}
						endwhile; endif;   ?>
<?php endforeach;
						$output .=  "</ul>";
						$output .=  "</div>";
					}
					$counter++;
					endforeach;
				}
			endforeach;
			$first_counter = '';
			$first_counter++;
			// Restore original Query & Post Data
			wp_reset_query();
			wp_reset_postdata();
			$output .=  '</div><!--/das-project-admin-wrap-->';
			// this action makes the shortcode go below the content, we must have something like this in place for all shortcodes.
			$output .= ob_get_contents();
			// $output .= ob_end_clean();
			return $output;
		} // end of the if user is logged in statement
		else {
			$output = '<p><a href="'. wp_login_url( get_permalink() ) .'" title="Login">'.__('Please Login to view your '.$das_project_rename_plural, 'design-approval-system').'</a>.</p>';
			return $output;
		}
	} // end Private Shortcode
	//**************************************************
	// Public Project Board
	//**************************************************
	function das_public_project_board_function() {
		$das_project_rename_plural = get_option('das-settings-plural-pb-fep-name') ? get_option('das-settings-plural-pb-fep-name') : __('Projects', 'design-approval-system');
		
		$das_pagination_amount = get_option('das_pagination_amount_per_page');
		$das_pagination_amount_fig = isset($das_pagination_amount) && !empty($das_pagination_amount) ? $das_pagination_amount : '10';
		
		ob_start();
		if (isset($_GET['trashed']) && $_GET['trashed'] == 1) {
			$output = '<p class="simple-das-notice">'.__('Design post moved to the Trash successfully.', 'design-approval-system').'';
			$output .= $this->wp_das_restore_post_link();
			$output .= '</p>';
			$output .= '<h3>'.__('Customer '.$das_project_rename_plural.'', 'design-approval-system').'</h3>';
		}
		elseif (isset($_GET['untrashed']) && $_GET['untrashed'] == 1) {
			$output = '<p class="simple-das-notice">'.__('Design post Restored from the Trash successfully.', 'design-approval-system').'</p>';
			$output .= '<h3>'.__('Customer '.$das_project_rename_plural.'', 'design-approval-system').'</h3>';
		}
		elseif (!is_admin()) {
			$output = '<h3>'.__('Customer '.$das_project_rename_plural.'', 'design-approval-system').'</h3>';
		}
		else {
			// this is empty so no php warning about output being empty
			$output = '';	
		}
		$output .= $this->ajax_search_form();
		$output .= '<div class="das-project-admin-wrap">';
		//Archive the project?
		$output .= $this->Archive_Project(isset($_GET['archive_project']) ? $_GET['archive_project'] : '');
		global $current_user; get_currentuserinfo();
		//Custom DAS Post Type
		$post_type = 'designapprovalsystem';
		//Custom DAS Taxonomies (aka Categories)
		$tax = 'das_categories';
		$Archived_Projects_List = get_option('taxonomy_term_meta_das_pb_board');
		$_GET['search_pb'] = isset($_GET['search_pb']) ? $_GET['search_pb'] : "";
		//Check if search - if so don't paginate
		if (!$_GET['search_pb']) {
			$paged = isset( $_GET['pagenum'] ) ? intval( $_GET['pagenum'] ) : 1;
			if (isset($_GET['page']) && $_GET['page'] == 'design-approval-system-projects-page') {
				$select_per_page  = $das_pagination_amount_fig;
			}
			else {
				$select_per_page  = isset( $_GET['select_per_page']) ? intval( $_GET['select_per_page'] ) : 2;
			}
			// Here we get_option the amount of users we want to see per page based on the saved settings field.
			$per_page = $select_per_page;
			// get_option('das_pagination_amount_per_page');
		}
		else {
			$paged = 1;
			$offset = '';
		}
		if (isset($_GET['pb_current_archives']) && $_GET['pb_current_archives'] == 'current' or !isset($_GET['pb_current_archives'])) {
			$archives_tax_args = array(
				'exclude'           => $Archived_Projects_List,
			);
			$tax_args = array(
				'orderby'           => 'date',
				'exclude' => $Archived_Projects_List,
			);
		}
		else {
			$archives_tax_args = array(
				'include' => $Archived_Projects_List,
			);
			$tax_args = array(
				'orderby'           => 'date',
				'include' => $Archived_Projects_List,
			);
		}
		$client = get_terms( $tax, $tax_args );
		//Client and Terms arrays.
		$clients_names = array();
		$term_names = array();
		$post_counts = array();
		$approved_main_designs_count = array();
		$search_value = ($_GET['search_pb']) ? $_GET['search_pb'] : false;
		//Loop to custom taxonomy to build Client and Terms arrays.
		foreach ($client as $term) :
			$search_found = 'false';
		$args = array(
			'post_type'        => $post_type,
			'posts_per_page'   => -1,
			'post_status'   => 'publish',
			'ignore_sticky_posts' => 1,
			'tax_query' => array(
				array(
					'taxonomy' => $tax,
					'field'    => 'ID',
					'terms'   => array( $term->term_id )
				),
			),
			'orderby' => 'date',
			'order' => 'ASC',
		);
		$my_query2 = new \WP_Query($args);
		if ( $my_query2->have_posts() ) : while ( $my_query2->have_posts() ) : $my_query2->the_post(); global $post;
		$project_name = $term->name;
		$client_name = get_post_meta($post->ID, 'custom_client_name', true);
		$clients_email = get_post_meta($post->ID, 'custom_clients_email', true);
		$post_title = get_the_title();
		if (isset($_GET['search_pb']) && $_GET['search_pb']) {
			if (stristr($project_name, $_GET['search_pb']) || stristr($client_name, $_GET['search_pb']) || stristr($clients_email, $_GET['search_pb']) || stristr($post_title, $_GET['search_pb'])) {
				$search_found = 'true';
			}
		}
		if (!$_GET['search_pb'] && $search_found == 'false' || $_GET['search_pb'] && $search_found == 'true') {
			$clients_name = get_post_meta($post->ID, 'custom_client_name', true);
			$clients_names[] = $clients_name;
			$term_names['Project_Name'][$term->name] = $clients_name;
			$term_names['Project_ID'][$term->name] = $term->term_id;
			$title_approved_checker = get_post_meta($post->ID, 'custom_client_approved', true);
			$approved_main_designs_count[$clients_name][$term->name][] = $title_approved_checker;
			$post_count_defined = isset($post_counts[$term->name]) ? $post_counts[$term->name] : '';
			$post_count_plus_one = $post_count_defined + 1;
			$post_counts[$term->name] = $post_count_plus_one;
		}
		endwhile; endif;
		endforeach;
		//END Build Arrays
		//Clean up Clients Array So no duplicate client titles happen.
		$final_clients_names = array_unique($clients_names);
		//Reindex
		$final_clients_names = array_values($final_clients_names);
		$number_of_series = count($final_clients_names);
		//offset
		if (isset($per_page)) {
			$offset = $per_page * ( $paged - 1);
			$final_clients_names = array_slice($final_clients_names, $offset, $per_page);
		}
		//Search or Not
		$server_url = $_SERVER["REQUEST_URI"];
		$the_url=  parse_url($server_url);
		if (!is_admin()) {
			//Unset Page Num
			if (isset($_GET['pagenum']) && $_GET['pagenum']) {
				unset ($_GET['pagenum']);
			}
			if (isset($_GET['select_per_page']) && $_GET['select_per_page'] ||
				isset($_GET['search_pb']) && $_GET['search_pb'] ||
				isset($_GET['trashed']) && $_GET['trashed'] ||
				isset($_GET['untrashed']) && $_GET['untrashed']
			) {
				$is_get_set =  !isset($_GET) || count($_GET) < 1 || isset($_GET['pb_current_archives']) ? '&' : '&';
			}
			else {
				$is_get_set = '?' ;
			}
		}
		else {
			$is_get_set = '&';
		}
		if (is_plugin_active('das-premium/das-premium.php') && is_plugin_active('design-approval-system/design-approval-system.php')) {
			if (is_admin()) {
				$archivedURL = '../wp-content/plugins/das-premium/includes/archive-unarchive-buttons.php';
				include($archivedURL);
			}
			else {
				$archivedURL = 'wp-content/plugins/das-premium/includes/archive-unarchive-buttons.php';
				include($archivedURL);
			}
		}
		$none_to_display = true;
		//Start loop for displaying Client Name [Final Build loop]
		foreach ($final_clients_names as $key => $client_value) :
			$first_counter = 0;
		$counter = 0;
		//loop for displaying Project Name
		foreach ($term_names['Project_Name'] as $project_name => $value) :
			$term_value = $value;
		if ($client_value == $value) {
			//SHOW UNARCHIVED PROJECTS
			if (!is_plugin_active('das-premium/das-premium.php') && is_plugin_active('design-approval-system/design-approval-system.php')) {
						$Archived_Projects_List = array();
				}
			if (isset($_GET['pb_current_archives']) && $_GET['pb_current_archives'] == 'current' or !isset($_GET['pb_current_archives'])) {
				if (!in_array($term_names['Project_ID'][$project_name], $Archived_Projects_List)) {
					//Client Name
					if ($counter < 1) {
						$output .= '<h2>'.$client_value.'</h2>';
						$output .= '<div class="clear-h2"></div>';
					}
					//Archive This Project button
					$unarchived_get_set = !isset($_GET) || count($_GET) > 1 ? '&' : '?';
					$archived_url_array =array('/[?&]archive_project=[^&]+$|([?&])archive_project=[^&]+&/', '/[?&]unarchive_project=[^&]+$|([?&])unarchive_project=[^&]+&/', '/[?&]pagenum=[^&]+$|([?&])pagenum=[^&]+&/');
					$archived_url_replace_array =array('$1', '');
					$archived_final_url = preg_replace($archived_url_array, $archived_url_replace_array, $server_url);
					if (is_plugin_active('das-premium/das-premium.php') && is_plugin_active('design-approval-system/design-approval-system.php')) {
						$output .= '<a class="archive-project-btn archive-btn" href="'.$archived_final_url.$unarchived_get_set.'archive_project='.$term_names['Project_ID'][$project_name].'"></a>';
					}
					$output .= '<h3 class="pb-cat-header">'.$project_name;
					if (in_array("Yes", $approved_main_designs_count[$value][$project_name])) {
						if (is_plugin_active('das-premium/das-premium.php') && is_plugin_active('design-approval-system/design-approval-system.php')) {
							$output .= '<div class="das-approved-design-subtitle das-premium-star"></div>';
						}
						else {
							$output .= '<div class="das-approved-design-subtitle"></div>';
						}
					}
					$output .= '<span>'.$post_counts[$project_name].'</span></h3>';
					$output .= '<div class="das-project-list-wrap">';
					$output .= '<ul class="das-project-list">';
					//loop for displaying posts for Project
					foreach ($client as $term) :
						$args = array(
							'post_type' => $post_type,
							'posts_per_page' => -1,
							'post_status'   => 'publish',
							'ignore_sticky_posts' => 1,
							'orderby' => 'date',
							'order' => 'ASC',
							'tax_query' => array(
								array(
									'taxonomy' => $tax,
									'field'    => 'ID',
									'terms'   => array( $term->term_id )
								),
							),
						);
					$my_query = new \WP_Query($args);
					if ( $my_query->have_posts() ) : while ( $my_query->have_posts() ) : $my_query->the_post(); global $post;
					$final_client_value = get_post_meta($post->ID, 'custom_client_name', true);
					$final_term_value = $term->name;
					//Design Link creation
					if (($term_value == $final_client_value) && ($project_name == $final_term_value)) {
						$output .= '<li>';
						$dirDASplugin = plugin_dir_path(__FILE__ );
						include $dirDASplugin . '../includes/das-project-boards.php';
						$output .= '</li>';
					}
					$none_to_display = false;
					endwhile; endif;
					endforeach;
					//loop for displaying posts for Project
					foreach ($client as $term2) :
						$args2 = array(
							'post_type' => $post_type,
							'posts_per_page' => 1,
							'post_status'   => 'publish',
							'ignore_sticky_posts' => 1,
							'orderby' => 'date',
							'order' => 'DESC',
							'tax_query' => array(
								array(
									'taxonomy' => $tax,
									'field'    => 'ID',
									'terms'   => array( $term2->term_id )
								),
							),
						);
					$my_query2 = new \WP_Query($args2);
					if ( $my_query2->have_posts() ) : while ( $my_query2->have_posts() ) : $my_query2->the_post(); global $post;
					$final_client_value2 = get_post_meta($post->ID, 'custom_client_name', true);
					$final_term_value2 = $term2->name;
					$edit_link_url = !is_admin() ? '?das_post='.$post->ID.'&nextversion=yes#tab2' :  get_edit_post_link($post->ID);
					//Design Link creation
					if (($term_value == $final_client_value2) && ($project_name == $final_term_value2) && !is_admin()) {
						$output .='<li>
  <div class="project-large-thumbnail">
    <div class="pb-no-thumbnail-image"></div>
  <a href="'.$edit_link_url.'" title="Create Next Version" target="_blank" class="project-list-link">'.__('Create Next Version', 'design-approval-system').'</a></div>
  <div class="pb-board-cover"><span class="project-notes-entry-utility project-notes-backg" style="display: none;"></span><span class="project-notes-entry-utility project-day-date" style="display: none; top:75px; width:140px; left:12px;">'.__('This will create a new version. Just change the title and content.', 'design-approval-system').'</span><span class="edit-link project-notes-entry-utility project-notes-edit" style="display: none;"><a href="'.$edit_link_url.'" title="Create Next">'.__('Create Next', 'design-approval-system').'</a></span></div>
<!--pb-board-cover--></li>';
					}
					$none_to_display = false;
					endwhile; endif;
					endforeach;
					$counter++;
					$output .= '</ul>';
					$output .= '</div>';
				}
			}
			//SHOW ARCHIVED PROJECTS
			elseif (in_array($term_names['Project_ID'][$project_name], $Archived_Projects_List)) {
				//Client Name
				if ($counter < 1) {
					$output .= '<h2>'.$client_value.'</h2>';
					$output .= '<div class="clear-h2"></div>';
				}
				//Archive This Project button
				$unarchived_get_set = !isset($_GET) || count($_GET) < 1 ? '?' : '&';
				$unarchived_url_array =array('/[?&]unarchive_project=[^&]+$|([?&])unarchive_project=[^&]+&/', '/[?&]archive_project=[^&]+$|([?&])archive_project=[^&]+&/');
				$unarchived_url_replace_array = array('$1', '');
				$unarchived_final_url = preg_replace($unarchived_url_array, $unarchived_url_replace_array, $server_url);
				if (is_plugin_active('das-premium/das-premium.php') && is_plugin_active('design-approval-system/design-approval-system.php')) {
					$output .= '<a class="archive-project-btn unarchive-btn" href="'.$unarchived_final_url.$unarchived_get_set.'unarchive_project='.$term_names['Project_ID'][$project_name].'"></a>';
				}
				$output .= '<h3 class="pb-cat-header">'.$project_name;
				if (in_array("Yes", $approved_main_designs_count[$value][$project_name])) {
					if (is_plugin_active('das-premium/das-premium.php') && is_plugin_active('design-approval-system/design-approval-system.php')) {
						$output .= '<div class="das-approved-design-subtitle das-premium-star"></div>';
					}
					else {
						$output .= '<div class="das-approved-design-subtitle"></div>';
					}
				}
				$output .= '<span>'.$post_counts[$project_name].'</span></h3>';
				$counter++;
				$none_to_display = false;
			}
		}
		endforeach;
		endforeach;
		$first_counter = '';
		$first_counter++;
		// Restore original Query & Post Data
		wp_reset_query();
		wp_reset_postdata();
		// $output .= ob_get_clean();
		//Pagination!
		if (!$_GET['search_pb']) {
			$output .='<div class="clear"></div><div class="pb-board-amount-per-page-wrap">';
			if (isset($_GET['page']) && $_GET['page'] == 'design-approval-system-projects-page') {
				$output .= '<form method="post" class="das-pagination-settings" action="options.php">';
				ob_start();
				settings_fields('das_pagination_settings');
				do_settings_sections('das_pagination_settings');
				$output .= ob_get_clean();
				ob_start();
				
				$output .='<input id="das_pagination_amount_per_page" placeholder="10" name="das_pagination_amount_per_page" class="das-pagination-input" type="text"  value="'.$das_pagination_amount_fig.'" />
					<input type="submit" class="das-pagination-submit-btn" value="'.__('Clients per Page', 'design-approval-system') .'" /></form>';
			}
			else {
				$output .= '<div class="select-per-page-wrap"><form name="select_per_page"><select name="select_per_page" class="select_per_page">';
				if (isset($_GET['select_per_page']) && $_GET['select_per_page'] == "2") {
					$output .= '<option value="2" selected="selected">2</option>';
				}
				else {
					$output .= '<option value="2">2</option>';
				}
				if (isset($_GET['select_per_page']) && $_GET['select_per_page'] == "10") {
					$output .= '<option value="10" selected="selected">10</option>';
				}
				else {
					$output .= '<option value="10">10</option>';
				}
				if (isset($_GET['select_per_page']) && $_GET['select_per_page'] == "20") {
					$output .= '<option value="20" selected="selected">20</option>';
				}
				else {
					$output .= '<option value="20">20</option>';
				}
				if (isset($_GET['select_per_page']) && $_GET['select_per_page'] == "50") {
					$output .= '<option value="50" selected="selected">50</option>';
				}
				else {
					$output .= '<option value="50">50</option>';
				}
				if (isset($_GET['select_per_page']) && $_GET['select_per_page'] == "100") {
					$output .= '<option value="100" selected="selected">100</option>';
				}
				else {
					$output .= '<option value="100">100</option>';
				}
				$output .= '</select><input type="submit" class="das-pagination-submit-btn" value="'.__('Clients per Page', 'design-approval-system') .'" /></form></div>';
			}
			$output .= '</div>';
			if($number_of_series !== 0){
				$output .='<div class="project-board-pagination">';
				$output .= paginate_links( array(
						'base'       => add_query_arg( 'pagenum', '%#%' ),
						'format'     => '?pagenum=%#%',
						'current'    => $paged,
						'prev_text'  => __('&#10094;&#10094;'),
						'next_text'  => __('&#10095;&#10095;'),
						'total'   => ceil( $number_of_series / $per_page ) // 3 items per page
					) );
				$output .='<div class="clear"></div>';
				$output .='</div>';
			}
		}
		$output .='<div class="clear"></div>';
		//If No Posts Show Message
		if ($none_to_display == true && isset($_GET['pb_current_archives']) && $_GET['pb_current_archives'] == 'current' or $none_to_display == true && !isset($_GET['pb_current_archives'])) {
			$output .= '<div class="no-projects-display">';
			if (isset($_GET['search_pb']) && $_GET['search_pb']) {
				$output .= '<div class="das-search-type">'.__('Current  '.$das_project_rename_plural.' Search', 'design-approval-system').'</div>';
				$output .= 'Sorry, No Searches Results Found for: '.$_GET['search_pb'].'.';
				$output .= '<br/><a href="?pb_current_archives=current">'.__('Go Back to Current '.$das_project_rename_plural.'', 'design-approval-system').'</a>';
			}
			else {
				$output .= __('There are no Current '.$das_project_rename_plural.' to display', 'design-approval-system');
			}
			$output .= '</div>';
		}
		if ($none_to_display == true && isset($_GET['pb_current_archives']) && $_GET['pb_current_archives'] == 'past') {
			$output .= '<div class="no-projects-display">';
			if (isset($_GET['search_pb']) && $_GET['search_pb']) {
				$output .= '<div class="das-search-type">'.__('Archived '.$das_project_rename_plural.' Search', 'design-approval-system').'</div>';
				$output .= 'Sorry, No Searches Results Found for: '.$_GET['search_pb'].'';
				$output .= '<br/><a href="?pb_current_archives=past">Go Back to '.__('Archived '.$das_project_rename_plural.'', 'design-approval-system').'</a>';
			}
			else {
				$output .= ''.__('There are no Archived '.$das_project_rename_plural.' to display', 'design-approval-system').'';
			}
			$output .= '</div>';
		}
		$output .= '<br class="clear"/>';
		$output .= '</div><!--/das-project-admin-wrap-->';
		//  $output .= ob_end_clean();
		return $output;
	}//END PUBLIC PROJECT BOARD
	//**************************************************
	// Archive E-Proofs
	//**************************************************
	function Archive_Project($project_id) {
		$das_project_rename_plural = get_option('das-settings-plural-pb-fep-name') ? get_option('das-settings-plural-pb-fep-name') : __('Projects', 'design-approval-system');
		$das_project_rename_singular = get_option('das-settings-singular-pb-fep-name') ? get_option('das-settings-singular-pb-fep-name') : __('Project', 'design-approval-system');
		//Archive a Project
		if (isset($_GET['archive_project'])) {
			//Make Sure Archive Project is NOT set
			unset($_GET['unarchive_project']);
			$Archived_Projects = get_option('taxonomy_term_meta_das_pb_board');
			if (is_array($Archived_Projects)) {
				$Archived_Projects[] = $project_id;
			}
			else {
				$Archived_Projects = array();
				$Archived_Projects[] = $project_id;
			}
			update_option('taxonomy_term_meta_das_pb_board', $Archived_Projects);
			return '<div class="simple-das-notice">'.__($das_project_rename_singular.' Archived Successfully!', 'design-approval-system').'</div>';
		}
		elseif (isset($_GET['unarchive_project'])) {
			$Archived_Projects = get_option('taxonomy_term_meta_das_pb_board');
			//Make Sure Archive Project is NOT set
			unset($_GET['archive_project']);
			if (is_array($Archived_Projects)) {
				//UNArchive a Project
				if ((array_search($_GET['unarchive_project'], $Archived_Projects)) !== false) {
					unset($Archived_Projects[array_search($_GET['unarchive_project'], $Archived_Projects)]);
				}
				update_option('taxonomy_term_meta_das_pb_board', $Archived_Projects);
				return '<div class="simple-das-notice">'.__($das_project_rename_singular.' Unarchived Successfully!', 'design-approval-system').'</div>';
			}
		}
		//Return if it makes it this far.
		return;
	}
	//**************************************************
	// AJAX Search Form
	//**************************************************
	function ajax_search_form() {
		$das_project_rename_plural = get_option('das-settings-plural-pb-fep-name') ? get_option('das-settings-plural-pb-fep-name') : __('Projects', 'design-approval-system');
		$output = '<div class="das-entry-content">';
		$output .= '<form id="cpt-tax-search" method="GET" action="">';
		foreach ($_GET as $param => $param_value) {
			if ($param !== 'search_pb')
				$output .= '<input name="'.$param.'" type="hidden" value="'.$param_value.'" />';
		}
		$output .= '<input type="submit" value="Search" id="submit-search" /><input name="search_pb" type="text" class="text-search" placeholder="';
		if (isset($_GET['pb_current_archives']) && $_GET['pb_current_archives']== 'current') {
			$output .= __('Search Current '.$das_project_rename_plural.'', 'design-approval-system');
		}
		elseif (isset($_GET['pb_current_archives']) && $_GET['pb_current_archives']== 'past') {
			$output .= __('Search Archived '.$das_project_rename_plural.'', 'design-approval-system');
		}
		else {
			$output .= __('Search Current '.$das_project_rename_plural.'', 'design-approval-system');
		}
		$output .= '" />';
		$output .= '</form>';
		$output .= '</div>';
		return $output;
	}
	//****************************************************************
	// NEW Front End Design and Customer Creation with Project Board
	//****************************************************************
	function frontend_design_mananger() {
		$das_project_rename_plural = get_option('das-settings-plural-pb-fep-name') ? get_option('das-settings-plural-pb-fep-name') : __('Projects', 'design-approval-system');
		$das_project_rename_singular = get_option('das-settings-singular-pb-fep-name') ? get_option('das-settings-singular-pb-fep-name') : __('Project', 'design-approval-system');
		$das_project_tab1_rename = get_option('das-settings-pb-fep-name') ? get_option('das-settings-pb-fep-name') : __('Projects Board', 'design-approval-system');
		ob_start();
		if (isset($_POST['submit'])) {
			if (!empty($_REQUEST['newcat'])) {
				$cat_ID = get_cat_ID( $_POST['newcat'] );
				//If not create new category
				if ($cat_ID == 0) {
					$cat_name = $_POST['newcat'];
					$parenCatID = 0;
					$new_cat_ID = wp_create_category($cat_name, $parenCatID);
					_e('Category added successfully', 'design-approval-system');
					echo '<br />';
				}
				else {
					_e('That category already exists', 'design-approval-system');
					echo '<br />';
				}
			}
		}
?>
  <form action="" method="post" style="display:none">
    <?php  _e('Enter Category Title', 'design-approval-system'); ?>
    <input type="text" name="newcat" value="" />
    <br />
    <input type="submit" name="submit" value="Submit" />
  </form>
  <?php
		global $wp_roles;
		$current_user = wp_get_current_user();
		$roles = $current_user->roles;
		$role = array_shift($roles);
		$role_final = isset($wp_roles->role_names[$role]) ? translate_user_role($wp_roles->role_names[$role] ) : false;
		if ($role_final == 'Administrator' || $role_final == 'DAS Designer') { ?>
                <div class="tabs"><a class="tab-1 " href="<?php echo the_permalink();  ?>" target="_self"><?php _e($das_project_tab1_rename, 'design-approval-system'); ?></a> <a class="tab-2" href="<?php  echo the_permalink() .'?tab=2'; ?>" target="_self"><?php _e('Create New '.$das_project_rename_singular.'', 'design-approval-system'); ?></a> <a class="tab-3" href="<?php  echo the_permalink() .'?tab=3'; ?>" ><?php _e('Create New Customer', 'design-approval-system'); ?></a><div class="slick-clear"></div></div>
                 <?php } ?>
                <div class="content-1">
                  <?php
		echo do_shortcode('[DASPrivateBoard]'); ?>
                </div>
                <div class="content-2">
                 <?php echo do_shortcode('[simple-das-fep]');
		?></div>
                <div class="content-3"> <?php echo do_shortcode('[das_registration_form]'); ?>
                </div>
    <script>

	 <?php if ($_GET["tab"] !== '2' || $_GET["tab"] !== '3') { ?>
		   jQuery( ".content-1" ).fadeIn();
		   jQuery( ".content-2" ).hide();
		   jQuery( ".content-3" ).hide();
		   jQuery( ".tab-1" ).addClass('active');
		   jQuery( ".tab-2" ).removeClass('active');
		   jQuery( ".tab-3" ).removeClass('active');
	   <?php } 
	    if ($_GET["tab"] == '2' || $_GET["das_post"] ) { ?>
		// if(document.location.hash ==="#tab2"){
		   jQuery( ".content-2" ).fadeIn();
		   jQuery( ".content-1" ).hide();
		   jQuery( ".content-3" ).hide();
		   jQuery( ".tab-2" ).addClass('active');
		   jQuery( ".tab-1" ).removeClass('active');
		   jQuery( ".tab-3" ).removeClass('active');
		// }
	  <?php } 
	   if ($_GET["tab"] == '3') { ?>
		   jQuery( ".content-3" ).fadeIn();
		   jQuery( ".content-2" ).hide();
		   jQuery( ".content-1" ).hide();
		   jQuery( ".tab-3" ).addClass('active');
		   jQuery( ".tab-1" ).removeClass('active');
		   jQuery( ".tab-2" ).removeClass('active');
		  <?php }  ?>
	</script>
 <?php  
		$output = '<div class="entry-content">';
		$output .= '</div>';
		// $output .= ob_get_clean();
		return $output;
	}
}
new Project_Board();