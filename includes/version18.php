<?php
/*
Template Name: db-settings-18.php
*/
?>
<?php 
global $wpdb; 
$ostemail = $wpdb->prefix . "ost_emailtemp"; 
$adminreply=$wpdb->get_row("SELECT id,name,subject,$ostemail.text,created,updated FROM $ostemail where name = 'Admin-Response'"); 
$adminreply=$adminreply->text;
$arname='Admin-Response';

$postsubmail=$wpdb->get_row("SELECT id,name,$ostemail.subject,text,created,updated FROM $ostemail where name = 'Admin-Response'"); 
$postsubmail=$postsubmail->subject;

$newticket=$wpdb->get_row("SELECT id,name,$ostemail.subject,$ostemail.text,created,updated FROM $ostemail where name = 'New-Ticket'"); 
$newticket=$newticket->text; 
$ntname='New-Ticket';

$user_name=$current_user->user_login; 
$e_address=$current_user->user_email; 
$user_id=$current_user->ID; 

$getNumOpenTickets=$ost_wpdb->get_var("SELECT COUNT(*) FROM $ticket_table WHERE user_id='$user_id' and status='open'"); 

$ticket_count=$ost_wpdb->get_var("SELECT COUNT(*) FROM $ticket_table WHERE user_id='$user_id'"); 
$ticket_count_open=$ost_wpdb->get_var("SELECT COUNT(*) FROM $ticket_table WHERE user_id='$user_id' and status='open'"); 
$ticket_count_closed=$ost_wpdb->get_var("SELECT COUNT(*) FROM $ticket_table WHERE user_id='$user_id' and status='closed'"); 

//////Ticket Info
$ticketinfo=$ost_wpdb->get_row("
	SELECT number,$ticket_table.user_id,$priority_table.priority_desc,status,$ticket_cdata.subject,$dept_table.dept_name,$ost_user.name,$ost_useremail.address,$ticket_table.created,$ticket_table.topic_id,$topic_table.topic 
	FROM $ticket_table 
	inner join $dept_table on $dept_table.dept_id = $ticket_table.dept_id 
	inner join $priority_table on $priority_table.priority_desc = $priority_table.priority_desc 
	inner join $ticket_cdata on $ticket_cdata.subject = $ticket_cdata.subject and $ticket_cdata.ticket_id=$ticket_table.ticket_id 
	inner join $ost_user on $ost_user.name = $ost_user.name and $ticket_table.user_id=$ost_user.id 
	inner join $ost_useremail on $ost_useremail.address = $ost_useremail.address and $ticket_table.user_id=$ost_useremail.user_id 
	inner join $topic_table on $topic_table.topic_id = $ticket_table.topic_id 
	where number = '$ticket'"); 

//////Thread Info
$threadinfo=$ost_wpdb->get_results("
	SELECT $thread_table.created,$thread_table.id,$thread_table.ticket_id,$thread_table.thread_type,body,poster 
	FROM $thread_table 
	inner join $ticket_table on $thread_table.ticket_id = $ticket_table.ticket_id 
	where number = '$ticket' 
	ORDER BY  $thread_table.id ASC"); 

if(isset($_REQUEST['search']))
{
$search=@$_REQUEST['tq'];
}
if(isset($_POST['action']))
$arr = explode('.', $_POST['action']);
$sql="
	SELECT $ticket_table.topic_id,number,$ticket_table.user_id,$ticket_cdata.subject,status,$topic_table.topic,$ticket_table.created,$ticket_table.updated,$thread_table.poster 
	FROM $ticket_table 
	inner join $ticket_cdata on $ticket_cdata.subject = $ticket_cdata.subject and $ticket_cdata.ticket_id=$ticket_table.ticket_id 
	inner join $ost_useremail on $ost_useremail.user_id = $ticket_table.user_id and $ost_useremail.address = $ost_useremail.address 
	inner join $topic_table on $topic_table.topic_id = $ticket_table.topic_id 
	left join $thread_table on ($thread_table.ticket_id = $ticket_table.ticket_id and $thread_table.thread_type='R') 
	where 1";
$sql.=" and $ticket_table.user_id = '".$user_id."'"; /// needed to use id instead of email address
if($category && ($category!="all")) 
$sql.=" and $topic_table.topic_id = '".$category."'"; 
if($status_opt && ($status_opt!="all")) 
$sql.=" and $ticket_table.status = '".$status_opt."'"; 
if(@$search && ($search!="")) 
$sql.=" and ($ticket_table.number like '%".$search."%' or $ticket_table.status like '%".$search."%' or $ticket_cdata.subject like '%".$search."%' or $topic_table.topic like '%".$search."%')"; 
$sql.=" GROUP BY $ticket_table.ticket_id"; 
if(isset($_POST['action']) && $arr[0]=='ascen') 
$sql.=" ORDER BY $arr[1] ASC, $ticket_table.created ASC"; 
else if(isset($_POST['action']) && $arr[0]=='desc') 
$sql.=" ORDER BY $arr[1] DESC, $ticket_table.created DESC"; 
else 
$sql.=" ORDER BY $ticket_table.created DESC"; 
@$numrows=mysql_num_rows(mysql_query($sql)); 
$rowsperpage = 7; 
$totalpages = ceil($numrows / $rowsperpage); 
if (isset($_REQUEST['currentpage']) && is_numeric($_REQUEST['currentpage'])) { 
$currentpage = (int) $_GET['currentpage']; 
} else { 
$currentpage = 1; 
} 
if ($currentpage > $totalpages) { 
$currentpage = $totalpages; 
} 
if ($currentpage < 1) { 
$currentpage = 1; 
} 
$offset = ($currentpage - 1) * $rowsperpage; 
$sql.=" LIMIT $offset, $rowsperpage"; 
$list_opt = $ost_wpdb->get_results($sql); 
///$ost_wpdb->flush();
?>