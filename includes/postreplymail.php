<?php 
/*
Template Name: postreplymail.php
*/
?>
<?php 
$config_table="ost_config";
$staff_table="ost_staff";
$pid=0;
$staffid=0;
$source="Web";
$thread_type="M";
$poster=$_REQUEST['usname'];
$usid=$_REQUEST['usid'];
$ticid=$_REQUEST['tic_id'];
$usticketid=$_REQUEST['usticketid'];
$usname=$_REQUEST['usname'];
$usemail=$_REQUEST['usemail'];
$adem=$_REQUEST['ademail'];
$title=$_REQUEST['stitle'];
$dirname=$_REQUEST['sdirna'];
$postconfirm=Format::stripslashes($_REQUEST['postconfirmtemp']);
$usdepartment=$_REQUEST['usdepartment'];
$ussubject=$_REQUEST['ussubject'];
$uscategories=$_REQUEST['uscategories'];
$top_id=$_REQUEST['ustopicid'];
$user_message=Format::stripslashes($_REQUEST['message']);
$ipaddress=$_SERVER['REMOTE_ADDR'];
$date=date("Y-m-d, g:i:s", strtotime("-5 hour"));

if($version=="18") { 
$ost_wpdb->insert($thread_table, array('pid' => $pid,'ticket_id' => $ticid,'staff_id' => $staffid,'user_id' => $usid,'thread_type' => $thread_type,'poster' => $poster,'source' => $source,'title' => "",'body' => $user_message,'ip_address' => $ipaddress,'created' => $date),	array('%d','%d','%d','%d','%s','%s','%s','%s','%s','%s','%s')); } 

if($version=="17") { 
$ost_wpdb->insert($thread_table, array('pid' => $pid,'ticket_id' => $ticid,'staff_id' => $staffid,'thread_type' => $thread_type,'poster' => $poster,'source' => $source,'title' => "",'body' => $user_message,'ip_address' => $ipaddress,'created' => $date),	array('%d','%d','%d','%s','%s','%s','%s','%s','%s','%s')); } 

if(isset($_REQUEST['reply_ticket_status'])) { 
$ost_wpdb->update($ticket_table, array('status' => 'open'), array('ticket_id' => $ticid), array('%s')); } 

if(isset($_REQUEST['close_ticket_status'])) { 
$ost_wpdb->update($ticket_table, array('status' => 'closed'), array('ticket_id' => $ticid), array('%s')); } 

if(isset($_REQUEST['open_ticket_status'])) { 
$ost_wpdb->update($ticket_table, array('status' => 'open'), array( 'ticket_id' => $ticid), array('%s')); } 

$deptid = $ost_wpdb->get_row("SELECT dept_id FROM $topic_table WHERE topic_id=$top_id"); 
$departid=$deptid->dept_id;
$con_tab = $ost_wpdb->get_results("SELECT email FROM $staff_table Where dept_id= $departid"); 
foreach($con_tab as $con_tab1) 
///Variable's for email templates
$username=$usname;
$usermail=$usemail;
$ticketid=$usticketid;
$admin_email=$adem;
$user_message=$user_message; ///from post form - now becomes a variable & message
$ostitle=$title;
$edate=$date;
$dname=$directory;
$siteurl=site_url()."/$dirname/";
$ticketurl=site_url()."/$dirname/?service=view&ticket=$ticketid";
$poconsubmail=$poconsubmail; /// subject in user email (todo's - add field input to WP Email Templates)

///Email user to confirm post reply
$to=$usermail;
eval("\$subject=\"$poconsubmail\";");
eval("\$message=\"$postconfirm\";");
$headers = 'From: '.$title.' <' .$admin_email. ">\r\n";
wp_mail( $to, $subject, $message, $headers);
	
///Email osticket admin for a new post reply
$to=$admin_email;
$subject="User Posted Reply";
$adminmessage="Hello Admin,\n";
$adminmessage.="User (".$usname.") has posted to a support ticket thread.";
$adminmessage.="\n\n";
$adminmessage.="Ticket ID :#".$ticketid."\n\n";
$adminmessage.="Email: ".$usemail."\n";
$adminmessage.="Department: ".$uscategories."\n";
$adminmessage.="Subject: ".$ussubject."\n";
$adminmessage.="\n----------------------\n";
$adminmessage.="Message: ".$user_message."";
$adminmessage.="\n----------------------\n\n";
$adminmessage.="To respond to this ticket, please login to the ".$title." system.";
$adminmessage.="\n\n";
$adminmessage.="".site_url()."\n";
$adminmessage.="Your friendly Customer Support System";
$headers = 'From: '.$title.' <' .$usemail. ">\r\n";
wp_mail( $to, $subject, $adminmessage, $headers);
?>