<?php
/**************************************************************
 	File that create custom fields for DAS plugin
***************************************************************/
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );    

// Add the DAS Meta Box
function add_das_meta_box() {
    add_meta_box(
		'custom_das_meta_box', // $id
		'Design Approval System Fields', // $title 
		'show_custom_das_meta_box', // $callback
		'Design Approval System', // $page
		'normal', // $context
		'high'); // $priority
}
add_action('add_meta_boxes', 'add_das_meta_box');
  
//DAS metabox array
$prefix = 'custom_';

$custom_meta_fields = array(
	array(
		'label'=> "Designer's Name:",
		'desc'	=> 'Full name of designer on this design/project. (This will be used for signature purposed)',
		'id'	=> $prefix.'designers_name',
		'type'	=> 'text'
	),
	array(
		'label'=> "Company or Client Name:",
		'desc'	=> 'Name of Company or Client this design/project is for.',
		'id'	=> $prefix.'client_name',
		'type'	=> 'text'
	),
	array(
		'label'=> "Company or Client Email:",
		'desc'	=> 'Email address of Company or Client this design/project is for. (Only 1 email address allowed)',
		'id'	=> $prefix.'clients_email',
		'type'	=> 'text'
	),
	array(
		'label'=> "Project Start and End Date:",
		'desc'	=> 'When the project will start and end. (Example: 10-15-12 thru 10-20-12)',
		'id'	=> $prefix.'project_start_end',
		'type'	=> 'text'
	),
	array(
		'label'=> "Name of the Design",
		'desc'	=> 'The title or name of the design. (Example: Home Page)',
		'id'	=> $prefix.'name_of_design',
		'type'	=> 'text'
	),
	array(
		'label'=> 'Version of Design',
		'desc'	=> 'What Version of design is this?',
		'id'	=> $prefix.'version_of_design',
		'type'	=> 'select',
		'options' => array (
			'version1' => array (
				'label' => 'Version 1',
				'value'	=> 'Version 1'
			),
			'version2' => array (
				'label' => 'Version 2',
				'value'	=> 'Version 2'
			),
			'version3' => array (
				'label' => 'Version 3',
				'value'	=> 'Version 3'
			),
			'version4' => array (
				'label' => 'Version 4',
				'value'	=> 'Version 4'
			),
			'version5' => array (
				'label' => 'Version 5',
				'value'	=> 'Version 5'
			),
			'version6' => array (
				'label' => 'Version 6',
				'value'	=> 'Version 6'
			),
			'version7' => array (
				'label' => 'Version 7',
				'value'	=> 'Version 7'
			),
			'version8' => array (
				'label' => 'Version 8',
				'value'	=> 'Version 8'
			),
			'version9' => array (
				'label' => 'Version 9',
				'value'	=> 'Version 9'
			),
			'version10' => array (
				'label' => 'Version 10',
				'value'	=> 'Version 10'
			),
			'version11' => array (
				'label' => 'Version 11',
				'value'	=> 'Version 11'
			),
			'version12' => array (
				'label' => 'Version 12',
				'value'	=> 'Version 12'
			),
			'version13' => array (
				'label' => 'Version 13',
				'value'	=> 'Version 13'
			),
			'version14' => array (
				'label' => 'Version 14',
				'value'	=> 'Version 14'
			),
			'version15' => array (
				'label' => 'Version 15',
				'value'	=> 'Version 15'
			),
			'version16' => array (
				'label' => 'Version 16',
				'value'	=> 'Version 16'
			),
			'version17' => array (
				'label' => 'Version 17',
				'value'	=> 'Version 17'
			),
			'version18' => array (
				'label' => 'Version 18',
				'value'	=> 'Version 18'
			),
			'version19' => array (
				'label' => 'Version 19',
				'value'	=> 'Version 19'
			),
			'version20' => array (
				'label' => 'Version 20',
				'value'	=> 'Version 20'
			),
			'version21' => array (
				'label' => 'Version 21',
				'value'	=> 'Version 21'
			),
			'version22' => array (
				'label' => 'Version 22',
				'value'	=> 'Version 22'
			),
			'version23' => array (
				'label' => 'Version 23',
				'value'	=> 'Version 23'
			),
			'version24' => array (
				'label' => 'Version 24',
				'value'	=> 'Version 24'
			),
			'version25' => array (
				'label' => 'Version 25',
				'value'	=> 'Version 25'
			),
		)
	),
	array(
		'label'=> "Designer Notes:",
		'desc'	=> 'Notes about design or project to the Client',
		'id'	=> $prefix.'designer_notes',
		'type'	=> 'textarea'
	),
	array(
		'label'=> 'Client Notes On or Off',
		'desc'	=> 'Make the client notes viewable on the page.',
		'id'	=> $prefix.'client_notes_on_off',
		'type'	=> 'select',
		'options' => array (
			'on' => array (
				'label' => 'Client Notes On',
				'value'	=> 'client-notes-on'
			),
			'off' => array (
				'label' => 'Client Notes Off',
				'value'	=> 'client-notes-off'
			)
		)
	),
	array(
		'label'=> 'Client Notes',
		'desc'	=> 'Notes from the client about the design.',
		'id'	=> $prefix.'client_notes',
		'type'	=> 'textarea'
	),
	
);

if(is_plugin_active('das-changes-extension/das-changes-extension.php')) {
	$custom_meta_fields[] =	array(
				'label'=> 'Paid or Not Paid Version',
				'desc'	=> 'Has the next set of design changes been paid for by client? If not select "Not Paid" and the next time the client trys to submit changes they will be notified that they are being charged for additional changes. [If client decides to submit additional changes you will recieve an email letting you know that they have accepted and it will also send them an email confirming this.',
				'id'	=> $prefix.'paid_not_paid',
				'type'	=> 'select',
				'options' => array (
					'one' => array (
						'label' => 'Paid',
						'value'	=> 'paid'
					),
					'two' => array (
						'label' => 'Not Paid',
						'value'	=> 'not-paid'
					)
				  )
	);
}

// The Callback
function show_custom_das_meta_box() {
global $custom_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	
	// Begin the field table and loop
	echo '<table class="form-table">';
	foreach ($custom_meta_fields as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		echo '<tr>
				<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
				<td>';
				switch($field['type']) {
					
					// text
					case 'text':
						echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
							<br /><span class="description">'.$field['desc'].'</span>';
					break;
					
					// textarea
					case 'textarea':
						echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
							<br /><span class="description">'.$field['desc'].'</span>';
							
					break;
					
					// repeatable
					case 'repeatable':
						echo '<a class="repeatable-add button" href="#">Add Another design</a>
								<ul id="'.$field['id'].'-repeatable" class="custom_repeatable">';
						$i = 0;
						if ($meta) {
							foreach($meta as $row) {
								echo '<li><span class="sort hndle">|||</span>
											<textarea name="'.$field['id'].'['.$i.']" id="'.$field['id'].'">'.$row.'</textarea>
											<a class="repeatable-remove button" href="#">-</a>
											
											</li>';
								$i++;
								
								
								
							}
						} else {
							echo '<li><span class="sort hndle">|||</span>
										<textarea name="'.$field['id'].'['.$i.']" id="'.$field['id'].'">'.$row.'</textarea>
										<a class="repeatable-remove button" href="#">Delete this design</a></li>';
						}
						echo '</ul>
							<span class="description">'.$field['desc'].'</span>';
							
					break;
					
					// checkbox
					case 'checkbox':
						echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
							<label for="'.$field['id'].'">'.$field['desc'].'</label>';
					break;
					
					// select
					case 'select':
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
						
						foreach ($field['options'] as $option) {
							echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
						}
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
					
				} //end switch
		echo '</td></tr>';
	} // end foreach
	echo '</table>'; // end table
	
global $post_type;
    if( 'designapprovalsystem' == $post_type ) {
	  echo '<script>';
	    echo 'jQuery(\'#custom_post_template option[selected="selected"]\').removeAttr(\'selected\');';
		echo 'jQuery(\'#custom_post_template option[value="default"]\').removeAttr(\'selected\');';
		echo 'jQuery(\'#custom_post_template option[value="default"]\').remove();';
		echo 'jQuery(\'#custom_post_template option[value="das-slick-template-v4.php"]\').attr(\'selected\',\'selected\');';
	  echo '</script>';
	}
}

// Save the Data
function save_custom_meta($post_id) {
    global $custom_meta_fields;
	
	// verify nonce
	if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) 
		return $post_id;
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
	}
	
	// loop through fields and save the data
	foreach ($custom_meta_fields as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // end foreach
}
add_action('save_post', 'save_custom_meta');  
?>
