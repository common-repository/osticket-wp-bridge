<?php
/*
Template Name: newticketemail.php
*/
?>
<?php 
if($version=="18") {
$tic_ID=generateID();
$checkUserID = $ost_wpdb->get_results("SELECT number from $ticket_table WHERE number = '$tic_ID'");
if(count($checkUserID)>0){
$tic_ID=generateID();
}
$dep_id=1;
$sla_id=1;
$pri_id=$_REQUEST['priorityId'];
$top_id=$_REQUEST['topicId'];
$staff_id=0;
$team_id=0;
$usid=$_REQUEST['usid'];
$em=$_REQUEST['email'];
$nam=$_REQUEST['cur-name'];
$adem=$_REQUEST['ademail'];
$title=$_REQUEST['stitle'];
$dirname=$_REQUEST['sdirna'];
$sub=Format::stripslashes($_REQUEST['subject']);
$newtickettemp=Format::stripslashes($_REQUEST['newtickettemp']);
$ip_add=$_SERVER['REMOTE_ADDR'];
$stat="open";
$sour="Web";
$isoverdue=0;
$isans=0;
$las_msg=date("Y-m-d, g:i:s", strtotime("-5 hour"));
$cre=date("Y-m-d, g:i:s", strtotime("-5 hour"));
$user_message=Format::stripslashes($_REQUEST['message']);
$prid = $ost_wpdb->get_row("SELECT priority_desc FROM $priority_table WHERE priority_id=$pri_id");
$priordesc=$prid->priority_desc;
/////New user info > check if user exists or create a new user...
$result1=$ost_wpdb->get_results("SELECT id FROM ost_user WHERE name = '".$nam."'");
if (count ($result1) > 0) {
	$row = current ($result1);
	///$wpdb->query ("UPDATE ost_user SET id = ".($row->ost_user + 1)." WHERE id = '".$usid."'");
	///don't need to update user info, but keep here for later versions, if needed..
} else {
	$ost_wpdb->query ("
	INSERT INTO ost_user (id, default_email_id, name, created, updated) 
	VALUES ('".$usid."', '".$usid."', '".$nam."', '".$cre."', '".$cre."')
	");
}
$result2=$ost_wpdb->get_results("SELECT id FROM ost_user_email WHERE user_id = '".$usid."'");
if (count ($result2) > 0) {
	$row = current ($result2);
	///$wpdb->query ("UPDATE ost_user SET id = ".($row->ost_user + 1)." WHERE id = '".$usid."'");
	///don't need to update user info, but keep here for later versions, if needed..
} else {
	$ost_wpdb->query ("
	INSERT INTO ost_user_email (id, user_id, address) 
	VALUES ('".$usid."', '".$usid."', '".$em."')
	");
}
////End of new user info user_email_id email_id

$ost_wpdb->insert($ticket_table, array('number' => $tic_ID,'user_id' => $usid,'user_email_id' => $usid,'dept_id' => $dep_id,'sla_id' => $sla_id,'topic_id' => $top_id,'staff_id' => $staff_id,'team_id' => $team_id,'email_id' => $usid,'ip_address' => $ip_add,'status' => $stat,'source' => $sour,'isoverdue' => $isoverdue,'isanswered' => $isans,'lastmessage' => $las_msg,'created' => $cre), array('%d','%d','%d','%d','%d','%d','%d','%d','%d','%s','%s','%s','%s','%s','%s','%s'));

$lastid = $ost_wpdb->insert_id;
$stat="created";
$staf="SYSTEM";
$annulled=0;
$ost_wpdb->insert($ticket_event_table, array('ticket_id' => $lastid,'staff_id' => $staff_id,'team_id' => $team_id,'dept_id' => $dep_id,'topic_id' => $top_id,'state' => $stat,'staff' => $staf,'annulled' => $annulled,'timestamp' => $cre), array('%d','%d','%d','%d','%d','%s','%s','%s','%s'));

$pid=0;	    
$thread_type="M";

$ost_wpdb->insert($thread_table, array('pid' => $pid,'ticket_id' => $lastid,'staff_id' => $staff_id,'thread_type' => $thread_type,'poster' => $nam,'source' => $sour,'title' => "",'body' => $user_message,'ip_address' => $ip_add,'created' => $cre), array('%d','%d','%d','%s','%s','%s','%s','%s','%s','%s'));

$ost_wpdb->insert($ticket_cdata, array('ticket_id' => $lastid,'subject' => $sub,'priority' => $priordesc,'priority_id' => $pri_id), array('%d','%s','%s','%d'));

$topic_tab = $ost_wpdb->get_results("SELECT topic_id, topic FROM $topic_table WHERE topic_id=$top_id");

foreach($topic_tab as $topic_tab1) { $top=$topic_tab1->topic; }

$config_table="ost_config";
$staff_table="ost_staff";
$admin_email=$adem;

$deptid = $ost_wpdb->get_row("SELECT dept_id FROM $topic_table WHERE topic_id=$top_id");
$departid=$deptid->dept_id;
$con_tab = $ost_wpdb->get_results("SELECT email FROM $staff_table Where dept_id=$departid");

foreach($con_tab as $con_tab1)
///Variable's for email templates
$admin_email=$adem;
$username=$nam;
$usermail=$em;
$ticketid=$tic_ID;
$user_message=$user_message; ///from post form - now becomes a variable & message
$ostitle=$title;
$edate=$date;
$dname=$directory;
$siteurl=site_url()."/$dirname/";
$ticketurl=site_url()."/$dirname/?service=view&ticket=$ticketid";
$postsubmail=$postsubmail; /// subject in user email (todo's - add field input to WP Email Templates)

///Email the user with template
$to=$usermail;
eval("\$subject=\"$postsubmail\";");
eval("\$message=\"$newtickettemp\";");
$headers = 'From: '.$title.' <' .$admin_email. ">\r\n";
wp_mail( $to, $subject, $message, $headers);

///Email osticket admin - a new ticket has been created
$to=$admin_email;
$subject="New Support Ticket";
$adminmessage="Hello Admin\nA new ticket has been created.\n\n";
$adminmessage.="Ticket ID #".$ticketid."";
$adminmessage.="\n----------------------\n";
$adminmessage.="Name: ".$username."\n";
$adminmessage.="Email: ".$usermail."\n"; 
$adminmessage.="Priority: ".$priordesc."\n";
$adminmessage.="Department: ".$top."\n";
$adminmessage.="Subject: ".$sub."\n";
$adminmessage.="\n----------------------\n";
$adminmessage.="Message: ".$user_message."";
$adminmessage.="\n----------------------\n\n";
$adminmessage.="To respond to the ticket, please login to the support ticket system.";
$adminmessage.="\n\n";
$adminmessage.="".site_url()."";
$adminmessage.="\n";
$adminmessage.="Your friendly Customer Support System ";
$headers = 'From: '.$title.' <' .$usermail. ">\r\n";
wp_mail( $to, $subject, $adminmessage, $headers);
}
/////End of v1.8

if($version=="17") {
$tic_ID=generateID();
$checkUserID = $ost_wpdb->get_results("SELECT ticketID from $ticket_table WHERE ticketID = '$tic_ID'");
if(count($checkUserID)>0){
$tic_ID=generateID();
}
$dep_id=1;
$sla_id=1;
$pri_id=$_REQUEST['priorityId'];
$top_id=$_REQUEST['topicId'];
$staff_id=0;
$team_id=0;
$em=$_REQUEST['email'];
$adem=$_REQUEST['ademail'];
$title=$_REQUEST['stitle'];
$nam=$_REQUEST['cur-name'];
$newtickettemp=Format::stripslashes($_REQUEST['newtickettemp']);
$sub=Format::stripslashes($_REQUEST['subject']);
$ip_add=$_SERVER['REMOTE_ADDR'];
$stat="open";
$sour="Web";
$isoverdue=0;
$isans=0;	
$las_msg=date("Y-m-d, g:i:s", strtotime("-5 hour"));
$cre=date("Y-m-d, g:i:s", strtotime("-5 hour"));
$user_message=Format::stripslashes($_REQUEST['message']);

$ost_wpdb->insert($ticket_table, array('ticketID' => $tic_ID,'dept_id' => $dep_id,'sla_id' => $sla_id,'priority_id' => $pri_id,'topic_id' => $top_id,'staff_id' => $staff_id,'team_id' => $team_id,'email' => $em,'name' => $nam,'subject' => $sub,'ip_address' => $ip_add,'status' => $stat,'source' => $sour,'isoverdue' => $isoverdue,'isanswered' => $isans,'lastmessage' => $las_msg,'created' => $cre), array('%d','%d','%d','%d','%d','%d','%d','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s'));

$lastid = $ost_wpdb->insert_id;
$stat="created";
$staf="SYSTEM";
$annulled=0;

$ost_wpdb->insert($ticket_event_table, array('ticket_id' => $lastid,'staff_id' => $staff_id,'team_id' => $team_id,'dept_id' => $dep_id,'topic_id' => $top_id,'state' => $stat,'staff' => $staf,'annulled' => $annulled,'timestamp' => $cre), array('%d','%d','%d','%d','%d','%s','%s','%s','%s'));

$pid=0;	    
$thread_type="M";

$ost_wpdb->insert($thread_table, array('pid' => $pid,'ticket_id' => $lastid,'staff_id' => $staff_id,'poster' => $nam,'source' => $sour,'thread_type' => $thread_type,'title' => "",'body' => $user_message,'ip_address' => $ip_add,'created' => $cre), array('%d','%d','%d','%s','%s','%s','%s','%s','%s','%s'));

$topic_tab = $ost_wpdb->get_results("SELECT topic_id, topic FROM $topic_table WHERE topic_id=$top_id");

foreach($topic_tab as $topic_tab1)
	{	
	$top=$topic_tab1->topic;
	}
$config_table="ost_config";
$staff_table="ost_staff";

$deptid = $ost_wpdb->get_row("SELECT dept_id FROM $topic_table WHERE topic_id=$top_id");
$departid=$deptid->dept_id;
$con_tab = $ost_wpdb->get_results("SELECT email FROM $staff_table Where dept_id=$departid");

foreach($con_tab as $con_tab1)
$admin_email=$adem;
$username = $nam;
$usermail=$em;
$ticketid = $tic_ID;
$ostitle = $title;
$siteurl = site_url()."/$dirname/";
$ticketurl = site_url()."/$dirname/?service=view&ticket=$ticketid";
$edate=date("Y-m-d, g:i:s");
$dname=$directory;
$postsubmail=$postsubmail;
$user_message=$user_message;
///Send user confirmation (using aval() --> not sending login info so it's ok to use)
$to=$em;
eval("\$subject=\"$postsubmail\";");
eval("\$message=\"$newtickettemp\";");
$headers = 'From: '.$title.' <' .$adem. ">\r\n";
wp_mail( $to, $subject, $message, $headers);

///Email osticket admin - a new ticket has been created
$to=$admin_email;
$subject="New Support Ticket";
$adminmessage="Hello Admin\nA new ticket has been created.\n\n";
$adminmessage.="Ticket ID #".$tic_ID."";
$adminmessage.="\n----------------------\n";
$adminmessage.="Name: ".$nam."\n";
$adminmessage.="Email: ".$em."\n";
$adminmessage.="Department: ".$top."\n";
$adminmessage.="Subject: ".$sub."\n\n";
$adminmessage.="Message: ".$user_message."";
$adminmessage.="\n----------------------\n\n";
$adminmessage.="To respond to this ticket, please login to the support ticket system.";
$adminmessage.="\n\n";
$adminmessage.="".site_url()."";
$adminmessage.="\n";
$adminmessage.="Your friendly Customer Support System ";
$headers = 'From: '.$title.' <' .$em. ">\r\n";
wp_mail( $to, $subject, $adminmessage, $headers);
}
?>