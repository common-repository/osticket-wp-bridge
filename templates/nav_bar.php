<?php
/*
Template Name: nav_bar.php
*/
?>
<?php
	if (is_user_logged_in()) { 
	echo '<ul id="ost_bar">'; 
	echo "<li><a class='home' href='?'>$title_name Home</a></li>"; 
	echo '<li><a class="new" href="?service=new">Open New Ticket</a></li>'; 
	echo "<li><a class='tickets' href='?service=list'>My Tickets ({$ticket_count})</a></li>"; 
?> 
<li><a class="logout" href="<?php echo wp_logout_url( get_permalink() ); ?>">Log-out</a></li></ul>
<?php 
	} else { 
	echo '<ul id="ost_bar">'; 
	echo "<li><a class='home' href='?'>$title_name Home</a></li>"; 
	echo '<li><a class="new" href="?service=new">Open New Ticket</a></li>'; 
	echo "<li><a class='tickets' href='?service=list'>My Tickets (0)</a></li>"; 
	echo '</ul>'; 
	} 
?>