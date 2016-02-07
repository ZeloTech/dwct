<?php  
define('DOING_AJAX', true);
$ext_time=3600*24*365;

if (!isset( $_POST['action']))
    die('-1');
//relative to where your plugin is located
require_once('../../../../wp-load.php');
 
//Typical headers
header('Content-Type: text/html');
send_nosniff_header();//Send a HTTP header to disable content type sniffing in browsers which support it. 
 
//Disable caching
header('Cache-Control: no-cache');
header('Pragma: no-cache');
 
$action = esc_attr($_POST['action']);
 
//A bit of security
$allowed_actions = array(
    'like',
    'unlike',
    'click',
	'view',
	'report'
);

if(in_array($action, $allowed_actions)){
   // if(is_user_logged_in())
	$ip_exist=true;
	if(in_array(fun_get_real_ip(),get_post_meta((int)$_POST['id'], 'like_ip',false)))
		$ip_exist=false;
	if($action=='like'&&$ip_exist)
		do_action('like_me',(int)$_POST['id'],fun_get_real_ip());
	if($action=='unlike'&&$ip_exist)
		do_action('unlike_me',(int)$_POST['id'],fun_get_real_ip());
	if($action=='click')
		do_action('click_point',(int)$_POST['id'],fun_get_real_ip());
	if($action=='view')
		do_action('view_point',(int)$_POST['id'],fun_get_real_ip());
	if($action=='report')
		do_action('report_issue',(int)$_POST['id'],htmlspecialchars(addslashes($_POST['ras']))."|".fun_get_real_ip());
}else{
    die('-1');
}
?>