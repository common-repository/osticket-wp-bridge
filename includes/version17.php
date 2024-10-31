<?php
/*
Template Name: db-settings-17.php
*/
?>
<?php 
$getNumOpenTickets = $ost_wpdb->get_var("SELECT COUNT(*) FROM $ticket_table WHERE email='$user_email' and status='open'"); 

$ticket_count = $ost_wpdb->get_var("SELECT COUNT(*) FROM $ticket_table WHERE email='$user_email'"); 
$ticket_count_open = $ost_wpdb->get_var("SELECT COUNT(*) FROM $ticket_table WHERE email='$user_email' and status='open'"); 
$ticket_count_closed = $ost_wpdb->get_var("SELECT COUNT(*) FROM $ticket_table WHERE email='$user_email' and status='closed'"); 

////// Ticket Info
$ticketinfo= $ost_wpdb->get_row("SELECT ticketID, $ticket_table.priority_id, subject,status,$dept_table.dept_name,$ticket_table.created,name,email,phone,phone_ext,$priority_table.priority_desc,$ticket_table.topic_id,$topic_table.topic FROM $ticket_table inner join $priority_table on $priority_table.priority_desc = $priority_table.priority_desc inner join $dept_table on $dept_table.dept_id = $ticket_table.dept_id inner join $topic_table on $topic_table.topic_id = $ticket_table.topic_id where ticketID = '$ticket'"); 

////// Thread Info
$threadinfo= $ost_wpdb->get_results("SELECT $thread_table.created,$thread_table.id,$thread_table.ticket_id,$thread_table.thread_type,body,poster FROM $thread_table inner join $ticket_table on $thread_table.ticket_id = $ticket_table.ticket_id where ticketID = '$ticket' ORDER BY  $thread_table.id ASC"); 

////// Search Info + Ticket list in user area //////
if(isset($_REQUEST['search'])) 
{ 
$search=@$_REQUEST['tq']; 
} 
if(isset($_POST['action']))
$arr = explode('.', $_POST['action']);
$sql="SELECT ticketID,subject,status,$ticket_table.created,$ticket_table.updated,topic,priority_desc, $thread_table.poster FROM $ticket_table
	    inner join $topic_table on $topic_table.topic_id = $ticket_table.topic_id 
	    inner join $priority_table on $priority_table.priority_id = $ticket_table.priority_id 
	    left join $thread_table on ($thread_table.ticket_id = $ticket_table.ticket_id and $thread_table.thread_type='R') 
	    where 1"; 
$sql.=" and email = '".$user_email."'"; 
if($category && ($category!="all")) 
$sql.=" and $topic_table.topic_id = '".$category."'"; 
if($status_opt && ($status_opt!="all")) 
$sql.=" and $ticket_table.status = '".$status_opt."'"; 
if(@$search && ($search!="")) 
$sql.=" and ($ticket_table.ticketID like '%".$search."%' or $ticket_table.status like '%".$search."%' or $ticket_table.subject like '%".$search."%' or $topic_table.topic like '%".$search."%')"; 
$sql.=" GROUP BY $ticket_table.ticket_id"; 
if(isset($_POST['action']) && $arr[0]=='ascen') 
$sql.=" ORDER BY $arr[1] ASC, $ticket_table.created ASC"; 
else if(isset($_POST['action']) && $arr[0]=='desc') 
$sql.=" ORDER BY $arr[1] DESC, $ticket_table.created DESC";
else
$sql.=" ORDER BY $ticket_table.created DESC"; 
$numrows=mysql_num_rows(mysql_query($sql)); 
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