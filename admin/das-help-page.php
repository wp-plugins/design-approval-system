<?php function das_help_page(){ ?>
<div class="das-help-admin-wrap"> 
<a class="buy-extensions-btn" href="http://www.slickremix.com/downloads/category/design-approval-system/" target="_blank"><?php _e('Get Extensions Here!', 'design-approval-system') ?></a>
<h2><?php _e('DAS Info and Help', 'design-approval-system') ?></h2>
<div class="das-admin-help-wrap">
<div class="use-of-plugin"><?php _e("Need help? Use our <a href='http://www.slickremix.com/support-forum/' target='_blank'>Support Forum</a> and someone will respond to your request asap. Usually we will respond the same day, the latest the following day. You may also find some of the existing posts to be helpfull too, so take a look around first. If you do submit a question please <a href='#' class='das-debug-report'>generate a report</a> and copy the info, ask your question in our <a href='http://www.slickremix.com/support-forum/' target='_blank'>support forum</a> then paste the info you just copied. That will help speed things along for sure.", "design-approval-system") ?> </div>
   <h3>Restart Tour</h3>
    <div class="use-of-plugin"> 
   		<ol>
   			<li><a href="#" id="das-retake-tour"><strong>Design Approval System Tour</strong></a></li>
       </ol>
    </div>
    <script type="text/javascript">
     jQuery('#das-retake-tour').click(function () {
                    //  alert('something');
                        jQuery.ajax({
                            type: 'POST',
                            url: myAjax.ajaxurl,
                            //function/addaction call from functions in plugin
                            data: {action: "dasplugin_wp_pointers_remove" },
                            success: function(data){
                              // alert(data);
                                 console.log('ReTour Worked');
                                 window.location.href = 'plugins.php'; 
                                 return data; 
                                } 
                        });
                    	return false;
       });
    </script>
  <h3>FAQs and Tips</h3>
  <div class="das-admin-help-faqs-wrap use-of-plugin">
  	<ol>  
      <li><a href="http://www.slickremix.com/category/design-approval-system-tutorials/" target="_blank"><?php _e("I'd like to see some Design Approval System Tutorials.", "design-approval-system") ?></a></li>
      <li><a href="http://www.slickremix.com/support-forum" target="_blank"><?php _e("I need Design Approval System Support.", "design-approval-system") ?></a></li>
      <li><a href="http://www.slickremix.com/downloads/category/design-approval-system/" target="_blank"><?php _e("Show me where to get Extensions for this plugin.", "design-approval-system") ?></a></li>
  </ol>
  </div><!--/das-admin-help-faqs-wrap-->
  
  <h3><?php _e("System Info", "design-approval-system") ?></h3>
  <p><?php _e("Please <a href='#' class='das-debug-report'>click here to generate a report</a> You will need to paste this information along with your question in our <a href='http://www.slickremix.com/support-forum/' target='_blank'>Support Forum</a>. Ask your question then paste the copied text below it.", "design-approval-system") ?></p>
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
                    	if ( function_exists( 'phpversion' ) )
						
						$phpversion = phpversion();
						$phpcheck = '5.2.9';
						
						if($phpversion > $phpcheck) {
							 echo phpversion();
						}
						else {
						    echo phpversion();
							echo "<br/><mark class='no'>WARNING:</mark> Your version of php must be 5.3 or greater to use this plugin. Please upgrade the php by contacting your host provider. Some host providers will allow you to change this yourself in the hosting control panel too.";
						}
						
						
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
                    	echo size_format( wp_max_upload_size() );
                    ?></td>
                </tr>
                
                <tr>
                    <td><?php _e('WP Debug Mode','dasystem')?></td>
                    <td><?php if ( defined('WP_DEBUG') && WP_DEBUG ) echo '<mark class="yes">' . __('Yes', 'dasystem') . '</mark>'; else echo '<mark class="no">' . __('No', 'dasystem') . '</mark>'; ?></td>
                </tr>
                
            </tbody>
		</table> 
  </div><!--/das-admin-help-faqs-wrap-->   
          
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
}
?>