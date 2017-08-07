<?php
/*
Plugin Name: Performance Optimization: Order Styles and Javascript
Plugin URI: http://www.satya-weblog.com/?p=2392
Description: Performance optimization tips: Make CSS at the top and scripts at the bottom in HTML head section.
Version: 1.0
Author: Satya Prakash
Author URI: http://www.satya-weblog.com/
License: Copyright 2010  Satya Prakash  (email : ws@satya-weblog.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
* Collect all external js
*/

function orderStyleJS($pos) {

	static $ct = 0;
	$ct++;

	if ($ct == 1) ob_start('outputStyleScriptPlusOtherMeta');

	if ($ct > 1 ) ob_end_flush();

}

function jsCodeExternal($strJs) {

	preg_match_all('/src\s?=\s?([\'|"])(.*)\1/isU',  $strJs, $headerJs2);
	$str = '';
	foreach ($headerJs2[2] as $val)
	{
		$str .= '<script src="'.$val.'" type="text/javascript"></script>' . "\n";
	}
	
	return $str;
	
}

/*
* Collect all inline js
*/
function jsCodeInline($strJs) {

	$inlineJs = '';
	foreach ($strJs as $val)
	{
	   if (! empty($val))
	   {
		   $inlineJs .= trim($val) . "\n";
	   }
	}

	if ($inlineJs != '') {

		$inlineJs = '<script type="text/javascript">' . "\n" . 
						$inlineJs . "\n" .
					'</script>';
	}

	return $inlineJs;

}

// Grab CSS and JS content and output in order
function outputStyleScriptPlusOtherMeta($headSection) {

	// catch external css out for adding later
	preg_match_all('@<link+.*(?=(?:type=[\'|"]text/css[\'|"]))(.*?)(?:/>){1,1}@iU', $headSection, $headCSS);
	$headSection = preg_replace('@<link+.*(?=(?:type=[\'|"]text/css[\'|"]))(.*?)(?:/>){1,1}@iU', '', $headSection);

	// catch Scripts out for adding later
	preg_match_all('/<script(.*)>(.*)<\/script>/isU', $headSection, $headJS);
	$headSection = preg_replace('@<script(.*)>(.*)<\/script>@isU', '', $headSection);

	// remove extra newline
	$headSection = preg_replace('@(\r\n|\r|\n){2,}@im' , "\n", $headSection);

	$cssCode = '';
	foreach ($headCSS[0] as $val)
	{
	   $cssCode .= $val . "\n";
	}

	$str = $cssCode; // output CSS
	$str .= $headSection;  // Output Other data minus css and js

	$str .= jsCodeExternal(implode("\n", $headJS[1])); // Output: external Js 

	$str .= jsCodeInline($headJS[2]); // Output: inline Js

	$str .= '<!-- Order style js plugin -->';

	return $str;

}

#####################

add_action('admin_menu', 'my_plugin_menu');

function my_plugin_menu() {

  add_options_page('Order CSS + Script Options', 'Order CSS + Script', 'manage_options', 'OrderCSSScript', 'my_plugin_options');

}

/**
* Admin Menu HTML
*/
function my_plugin_options() {

	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}

	echo '<div class="wrap" style="width:90%;margin:20px auto;position:relative">';

	echo '<fieldset style="border:2px solid #999;padding:10px">
			<legend > <b>Ordering stylesheet and JavaScript:</b> </legend>
		';

	echo <<<EOD

	This does not have any option to use. This is very simple to implement plugin for ordering Styles and Script in <b>&lt;head&gt;&lt;/head&gt;</b>
	section. 
	  <br />
	 <b>1</b>. Just add these lines after <b>&lt;head&gt;</b> or better after <b>&lt;head&gt;</b> and then <b>Content-Type</b> meta tag:
		<pre>
	&lt;?php
		if (function_exists('orderStyleJS')) {
			orderStyleJS( 'start' );
		}
	?&gt;
	</pre>
	<b>2</b>. Similar to above, just add these line just before <b>&lt;/head&gt;</b>:

	<pre>
	&lt;?php
		if (function_exists('orderStyleJS')) {
			orderStyleJS( 'end' );
		}
	?&gt;
	</pre>

EOD;

	echo '
	 <br /><br />
	 <div style="clear:both">&nbsp;</div>

	<div style="position:absolute;bottom:10px;left:15px;vertical-align:bottom;border-top:2px dotted #999;width:90%;margin:5px auto;padding:5px">
		<a href="http://www.satya-weblog.com/?p=2392" target="_blank">Plugin Discussion</a> &nbsp; | &nbsp;

		<a href="http://www.facebook.com/pages/Web-Scripting/176350059435" target="_blank">Facebook</a> &nbsp; | &nbsp;
		
		<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=JCVH4RPHL4P5G" target="_blank">Donate</a>
	</div>
	';

	echo '</fieldset></div>';


} // END my_plugin_options



?>