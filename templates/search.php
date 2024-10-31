<?php
/*
Template Name: search.php
*/
?>
<?php 
	echo "<div id='search_ticket'>"; 
	echo "<div id='search_box'> 
	<form name='search' method='POST' enctype='multipart/form-data' onsubmit='return validateFormSearch()'>
	Search&nbsp;
	<select onchange='this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);'>
	<option selected>-- Any Status --</option>
	<option value='?service=list&status=open'>Open ({$ticket_count_open})</option>
	<option value='?service=list&status=closed'>Closed ({$ticket_count_closed})</option>
	</select>&nbsp;&nbsp;
	<input type='hidden' name='service' value='list'> 
	<input class='ost' type='text' size='20' name='tq' id='tq' value=". @$_REQUEST['tq'].">&nbsp;&nbsp;
	<input type='submit' name='search' value='Go >>'>";
	echo "</form></div>"; 
	echo "<div id='search_opcl'><a class='refresh' href=".$_SERVER['REQUEST_URI'].">Refresh</a></div>"; 
	echo '<div style="clear: both"></div>'; 
	echo '</div>'; 
?>
<script type="text/javascript" src="<?php echo plugin_dir_url(__FILE__).'../js/validate.js';?>"></script>