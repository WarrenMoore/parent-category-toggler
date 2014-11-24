<?php
/*
Plugin Name: Parent Category Toggler
Description: Automatically toggle the parent categories when a sub category is selected.
Version: 1.3.2
Author: Ben Lobaugh
Author URI: http://ben.lobaugh.net
Original Author: Aw Guo
Original Author URI: http://www.ifgogo.com
Licence: GPL
*/

function super_category_toggler() {
	
	$taxonomies = apply_filters('super_category_toggler',array());
	for($x=0;$x<count($taxonomies);$x++)
	{
		$taxonomies[$x] = '#'.$taxonomies[$x].'div .selectit input';
	}
	$selector = implode(',',$taxonomies);
	if($selector == '') $selector = '.selectit input';
	
	echo '
		<script>
		jQuery("'.$selector.'").change(function(){
			var $chk = jQuery(this);
			var ischecked = $chk.is(":checked");
			var tmp = ischecked;
			$chk.parent().parent().siblings().children("label").children("input").each(function()	{
				var b = this.checked;
				ischecked = ischecked || b;
			});
			console.log(ischecked);
			if (tmp) {
				checkParentNodes(ischecked, $chk);
			} else {
				checkChildNodes($chk);
			}
		});
		function checkParentNodes(b, $obj)
		{
			$prt = findParentObj($obj);
			if ($prt.length != 0)
			{
			 $prt[0].checked = b;
			 checkParentNodes(b, $prt);
			}
		}
		function findParentObj($obj)
		{
			return $obj.parent().parent().parent().prev().children("input");
		}
		function checkChildNodes($obj) {
			$obj.parent().siblings().children().children("label").children("input").each(function() {
				var $this = jQuery(this);
				$this[0].checked = false;
				checkChildNodes($this);
			});
		}
		</script>
		';
	
}
add_action('admin_footer', 'super_category_toggler');
?>
