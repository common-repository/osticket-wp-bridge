<?php 
$pid=0;
$staffid=1; 
$ticid=$_REQUEST['tic_id'];
$thread_type="R";
$poster=$_REQUEST['adname'];
$source="Web";
$admin_response=Format::stripslashes($_REQUEST['message']); ///from post to thread-table to variable to email
$ipaddress=$_SERVER['REMOTE_ADDR'];
$date=date("Y-m-d, g:i:s", strtotime("-5 hour")); ///EST (todo's - add option to WP osT-Settings)

$ost_wpdb->insert($thread_table, array('pid'=>$pid,'ticket_id'=>$ticid,'staff_id'=>$staffid,'thread_type'=>$thread_type,'poster'=>$poster,'source'=>$source,'title'=>"",'body'=>$admin_response,'ip_address'=>$ipaddress,'created'=>$date), array('%d','%d','%d','%s','%s','%s','%s','%s','%s','%s'));

if(isset($_REQUEST['reply_ticket_status'])) { 
$ost_wpdb->update($ticket_table, array('status'=>'open'), array('ticket_id'=>$ticid), array('%s')); } 
if(isset($_REQUEST['close_ticket_status'])) { 
$ost_wpdb->update($ticket_table, array('status'=>'closed'), array('ticket_id'=>$ticid), array('%s')); } 
if(isset($_REQUEST['open_ticket_status'])) { 
$ost_wpdb->update($ticket_table, array('status'=>'open'), array('ticket_id'=>$ticid), array('%s')); }

///post from form
$usticketid=$_REQUEST['usticketid'];
$usname=$_REQUEST['usname'];
$usemail=$_REQUEST['usemail'];
$adem=$_REQUEST['ademail'];
$title=$_REQUEST['stitle'];
$usdepartment=$_REQUEST['usdepartment'];
$ussubject=$_REQUEST['ussubject'];
$uscategories=$_REQUEST['uscategories'];
$top_id=$_REQUEST['ustopicid'];
$dirname=$_REQUEST['sdirna'];
$admin_reply=Format::stripslashes($_REQUEST['adreply']); /// clean template from form to user email

///Getting department info
$deptid=$ost_wpdb->get_row("SELECT dept_id FROM $topic_table WHERE topic_id=$top_id");
$departid=$deptid->dept_id;
$con_tab=$ost_wpdb->get_results("SELECT email FROM $staff_table Where dept_id= $departid");
foreach($con_tab as $con_tab1)

///Variable's for email templates
$admin_email=$adem;
$username=$usname;
$usermail=$usemail;
$ticketid=$usticketid;
$admin_response=$admin_response; ///from post form - now becomes a variable & message
$ostitle=$title;
$edate=$date;
$dname=$directory;
$siteurl=site_url()."/$dirname/";
$ticketurl=site_url()."/$dirname/?service=view&ticket=$ticketid";
$postsubmail=$postsubmail; /// subject in user email (todo's - add field input to WP Email Templates)

///Send user the posted message (using aval() --> not sending login info so it's ok to use)
$to=$usemail;
eval("\$subject=\"$postsubmail\";");
eval("\$message=\"$admin_reply\";");
$headers = 'From: '.$title.' <' .$adem. ">\r\n";
wp_mail( $to, $subject, $message, $headers);
?>