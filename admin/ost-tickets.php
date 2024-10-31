<?php
/*
Template Name: ost-tickets
*/
?>
<?php 
if($version!="17") { 
	require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/admin/db-settings-18.php' );
} else {
	require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/admin/db-settings-17.php' );
}
?>
<?php require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/includes/functions.php' ); ?>
<div class="wrap">
<div class="headtitle">osTicket - Support/Request List</div>
<div style="clear: both"></div>
<?php require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/admin/header_nav.php' ); ?>
<div id="tboxwh" class="pg1">Here you can view ticket information that hasn't been deleted from database, all open & closed ticket/requests.</div>
<div style="clear: both"></div>
<div class="ticlinks" align="center">All Tickets: (<a href='admin.php?page=ost-tickets'><?php echo "$ticket_count_all"; ?></a>)&nbsp;|&nbsp;Open Tickets: (<a href='admin.php?page=ost-tickets&service=list&status=open'><?php echo "$ticket_count_open"; ?></a>)&nbsp;|&nbsp;Closed Tickets: (<a href='admin.php?page=ost-tickets&service=list&status=closed'><?php echo "$ticket_count_closed"; ?></a>)</div>
<br />
<?php
	echo "<div id='search_box'>
	<form name='search' method='POST' enctype='multipart/form-data' onsubmit='return validateFormSearch()'>
	Search&nbsp;
	<input type='hidden' name='service' value='list'> 
	<input type='text' name='tq' id='tq' value=". @$_REQUEST['tq'].">&nbsp;&nbsp;
	<input type='submit' name='search' class='button-primary' value='Go >>'>&nbsp;&nbsp;(search for any ticket number or text in the subject line)";
	echo "</form></div>";
	echo '<div style="clear: both"></div>';
?>
<div align="center" style="padding-top:20px;"></div>
<div style="clear: both"></div>
<div class="cofigmenu">
<?php
if($list_opt)
{
?>
<div id="ticket_menu">
<div id="ticket_menu1">Ticket #</div>
<div id="ticket_menu2">Subject</div>
<div id="ticket_menu3">Status</div>
<div id="ticket_menu4">Department</div>
<div id="ticket_menu5">Date Created</div>
<div style="clear: both"></div>
</div>
<form name="ticketview" id="ticketview" method="post">
<?php
	function ezDate($d) { 
        $ts = time() - strtotime(str_replace("-","/",$d));
        if($ts>31536000) $val = round($ts/31536000,0).' year'; 
        else if($ts>2419200) $val = round($ts/2419200,0).' month'; 
        else if($ts>604800) $val = round($ts/604800,0).' week'; 
        else if($ts>86400) $val = round($ts/86400,0).' day'; 
        else if($ts>3600) $val = round($ts/3600,0).' hour'; 
        else if($ts>60) $val = round($ts/60,0).' minute'; 
        else $val = $ts.' second';
        if($val>1) $val .= 's'; 
        return $val; 
	}
	foreach($list_opt as $list)
	{
	if($list->updated=="0000-00-00 00:00:00")
	{
	$list_updated="-";
	}
	else{
	$list_updated=ucwords(ezDate($list->updated)).' Ago';
	}
	$sub_str=Format::stripslashes($list->subject);				
	echo "<div id='ticket_list'>";
	if($version=="18") {
	echo "<div id='ticket_list1'><a href='admin.php?page=ost-tickets&service=view&ticket=".$list->number."'>".$list->number."</a></div>";
	} else {
	echo "<div id='ticket_list1'><a href='admin.php?page=ost-tickets&service=view&ticket=".$list->ticketID."'>".$list->ticketID."</a></div>";
	}
	echo "<div id='ticket_list2'>".truncate($sub_str,40,'...')."</div><div id='ticket_list3'>";
	if($list->status=='closed') {
	echo '<font color=red>Closed</font>';
	} 
	elseif ($list->status=='open') {
	echo '<font color=green>Open</font>';
	}
	echo "</div><div id='ticket_list4'>".$list->topic."</div>";
	?>
	<?php
   	$date_str  = "".$list->created."";
   	echo "<div id='ticket_list5'>";
   	echo truncate($date_str,10,'');
   	echo "</div>";
	?>
	<?php
	echo "<div style='clear: both'></div></div>";
	} }
	else
	{
	echo '<div align="center" id="no_tics">No tickets found.</div>';
	}
?>
</form>
</div>
<div align="center" style="padding-top:15px;"></div>
<div style="clear: both"></div>
<?php require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/includes/pagination.php' ); ?>
</div><!--End wrap-->