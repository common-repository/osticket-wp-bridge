<?php
/*
Template Name: list_tickets.php
*/
?>
<?php
if($list_opt) { 
require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/templates/search.php' ); 
?>
<div id="ticket_menu">
<div id="ticket_menu1">Ticket #</div>
<div id="ticket_menu2">Subject</div>
<div id="ticket_menu3">Status</div>
<div id="ticket_menu4">Department</div>
<div id="ticket_menu5">Date Created</div>
<div style="clear: both"></div>
</div>
<form name="osticket" id="osticket" method="post">
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
	echo "<div id='ticket_list1'><a href='?service=view&ticket=".$list->number."'>".$list->number."</a></div>"; 
	} else { 
	echo "<div id='ticket_list1'><a href='?service=view&ticket=".$list->ticketID."'>".$list->ticketID."</a></div>"; 
	} 
	echo "<div id='ticket_list2'>".truncate($sub_str,35,'...')."</div><div id='ticket_list3'>"; 
	if($list->status=='closed') { 
	echo '<font color=red>Closed</font>'; 
	} 
	elseif ($list->status=='open') { 
	echo '<font color=green>Open</font>'; 
	} 
	echo "</div><div id='ticket_list4'>".$list->topic."</div>"; 
   	$input_str  = "".$list->created.""; 
   	echo "<div id='ticket_list5'>"; 
   	echo substr($input_str,0,10); 
   	echo "</div>"; 
	echo "<div style='clear: both'></div></div>";
	} } 
	else 
	{ 
	echo '<div id="no_tics">No tickets found.</div>';
	} 
?>
</form>