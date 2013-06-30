<?php function das_help_page(){ ?>
<div class="das-help-admin-wrap"> 
<a class="buy-extensions-btn" href="http://www.slickremix.com/product-category/design-approval-system-extensions/" target="_blank">Get Extensions Here!</a>
<h2>DAS Info and Help </h2>
<div class="das-admin-help-wrap">
<div class="use-of-plugin">Can't figure out how to do something and need help? Use our <a href="http://www.slickremix.com/support-forum/" target="_blank">Support Forum</a> and someone will respond to your request asap. Usually we will respond the same day, the latest the following day. You may also find some of the existing posts to be helpfull too, so take a look around first. If you do submit a question please <a href="#" class="das-debug-report">generate a report</a> and copy the info, ask your question in our <a href="http://www.slickremix.com/support-forum/" target="_blank">support forum</a> then paste the info you just copied. That will help speed things along for sure. </div>
  </h3>
  <h3>FAQs and Tips</h3>
  <div class="das-admin-help-faqs-wrap">
  	<ol>  
      <li><a href="http://www.slickremix.com/category/design-approval-system-tutorials/" target="_blank">I'd like to see some Design Approval System Tutorials.</a></li>
      <li><a href="http://www.slickremix.com/support-forum" target="_blank">I need Design Approval System Support.</a></li>
      <li><a href="http://www.slickremix.com/product-category/design-approval-system-extensions/" target="_blank">Show me where to get Extensions for this plugin.</a></li>
      <li><a href="http://www.slickremix.com/support-forum/slick-tips-group7/design-approval-system-forum8/how-to-change-the-background-color-of-your-design-post-thread25/" target="_blank">How to change the Background Color of your Design Post?</a></li>
      <li><a href="http://www.slickremix.com/support-forum/slick-tips-group7/design-approval-system-forum8/using-images-larger-990px-in-the-design-post-if-you-use-the-das-system-you-should-read-this-thread16/" target="_blank">Using images larger than 990px in a design post.</a></li>
      <li><a href="http://www.slickremix.com/support-forum/slick-tips-group7/design-approval-system-forum8/adding-the-free-duplicate-post-wordpress-plugin-to-our-das-thread23/" target="_blank">Adding the FREE Duplicate Post WordPress Plugin to our DAS</a>.</li>
      <li><a href="http://www.slickremix.com/support-forum/slick-tips-group7/design-approval-system-forum8/adding-the-free-wordpress-editorial-calendar-plugin-to-our-das-thread22/" target="_blank">Adding the FREE WordPress Editorial Calendar Plugin to our DAS.</a></li>
  </ol>
  </div><!--/das-admin-help-faqs-wrap-->
  
  <h3>System Info</h3>
  <p>Please 
<a href="#" class="das-debug-report">click here to generate a report</a>  You will need to  paste this information along with your question in our <a href="http://www.slickremix.com/support-forum/" target="_blank">Support Forum</a>. Ask your question then paste the copied text below it.
  </p>
		<textarea id="das-debug-report" readonly="readonly"></textarea>
		<table class="wc_status_table widefat" cellspacing="0">
			<thead>
				<tr>
					<th colspan="2"><?php _e( 'Versions', 'dasystem' ); ?></th>
				</tr>
			</thead>

			<tbody>
                <tr>
                    <td><?php _e('DAS Plugin version','dasystem')?></td>
                  <td><?php echo dasystem_version(); ?></td>
                </tr>
                <tr>
                    <td><?php _e('WordPress version','dasystem')?></td>
                    <td><?php if ( is_multisite() ) echo 'WPMU'; else echo 'WP'; ?> <?php echo bloginfo('version'); ?></td>
                </tr>
             	<tr>
             		<td><?php _e('Installed plugins','dasystem')?></td>
             		<td><?php
             			$active_plugins = (array) get_option( 'active_plugins', array() );

             			if ( is_multisite() )
							$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );

						$active_plugins = array_map( 'strtolower', $active_plugins );

						$wc_plugins = array();

						foreach ( $active_plugins as $plugin ) {
							//if ( strstr( $plugin, 'dasystem' ) ) {

								$plugin_data = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );

	    						if ( ! empty( $plugin_data['Name'] ) ) {

	    							$wc_plugins[] = $plugin_data['Name'] . ' ' . __('by', 'dasystem') . ' ' . $plugin_data['Author'] . ' ' . __('version', 'dasystem') . ' ' . $plugin_data['Version'];

	    						}
    						//}
						}

						if ( sizeof( $wc_plugins ) == 0 ) echo '-'; else echo '<ul><li>' . implode( ', </li><li>', $wc_plugins ) . '</li></ul>';

             		?></td>
             	</tr>
			</tbody>


			<thead>
				<tr>
					<th colspan="2"><?php _e( 'Server Environment', 'dasystem' ); ?></th>
				</tr>
			</thead>

			<tbody>
                <tr>
                    <td><?php _e('PHP Version','dasystem')?></td>
                    <td><?php
                    	if ( function_exists( 'phpversion' ) ) echo phpversion();
                    ?></td>
                </tr>
                <tr>
                    <td><?php _e('Server Software','dasystem')?></td>
                    <td><?php
                    	echo $_SERVER['SERVER_SOFTWARE'];
                    ?></td>
                </tr>
				<tr>
                    <td><?php _e('WP Max Upload Size','dasystem'); ?></td>
                    <td><?php
                    	echo wp_convert_bytes_to_hr( wp_max_upload_size() );
                    ?></td>
                </tr>
                
                <tr>
                    <td><?php _e('WP Debug Mode','dasystem')?></td>
                    <td><?php if ( defined('WP_DEBUG') && WP_DEBUG ) echo '<mark class="yes">' . __('Yes', 'dasystem') . '</mark>'; else echo '<mark class="no">' . __('No', 'dasystem') . '</mark>'; ?></td>
                </tr>
                
            </tbody>
		</table> 
  </div><!--/das-admin-help-faqs-wrap-->   
        
  <a class="das-settings-admin-slick-logo" href="http://www.slickremix.com" target="_blank"></a>      
</div><!--/das-help-admin-wrap-->	
  <script type="text/javascript">
		jQuery('a.das-debug-report').click(function(){

			if ( ! jQuery('#das-debug-report').val() ) {

				// Generate report - user can paste into forum
				var report = '`';

				jQuery('thead, tbody', '.wc_status_table').each(function(){

					$this = jQuery( this );

					if ( $this.is('thead') ) {

						report = report + "\n=============================================================================================\n";
						report = report + " " + jQuery.trim( $this.text() ) + "\n";
						report = report + "=============================================================================================\n";

					} else {

						jQuery('tr', $this).each(function(){

							$this = jQuery( this );

							report = report + $this.find('td:eq(0)').text() + ": \t";
							report = report + $this.find('td:eq(1)').text() + "\n";

						});
					}
				});
				report = report + '`';
				jQuery('#das-debug-report').val( report );
			}
			jQuery('#das-debug-report').slideToggle('500', function() {
				jQuery(this).select();
			});
      		return false;
		});

	</script> 
<?php
	include('walkthrough/walkthrough.php');	
}
?>