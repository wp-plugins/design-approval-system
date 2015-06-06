<?php
namespace Design_Approval_System;
class DAS_Post_Page_Template extends Design_Approval_System_Core {
	function __construct() {
		//GQ Theme
		$das_gq_theme = new GQ_Theme();
		$das_gq_theme->GQ_Theme_Display();
	}
}
new DAS_Post_Page_Template();
?>