<?php
/*
Template Name: welcome.php
*/
?>
<div id="welcome">Welcome to our <?php echo $title_name; ?></div>
<div style="clear: both"></div>
<div id="welcome_st">In order to streamline support requests and better serve you, we utilize a support ticket system.<br>Every support request is assigned a unique ticket number which you can use to track the progress and responses online.</div>
<div style="clear: both"></div>
<table class="welcome nobd">
<tr>
<td class="nobd" width="10%"><div align="center"><img src="<?php echo plugin_dir_url(__FILE__).'../images/new_ticket_icon.png'; ?>" width="64" height="64" alt="Open A New Ticket"></div></td>
<td class="nobd" width="40%"><div class="ticket">Open A New Ticket</div><span class="par1">All site inquiries, contact us.</span></td>
<td class="nobd" width="10%"><div align="center"><img src="<?php echo plugin_dir_url(__FILE__).'../images/check_status_icon.png'; ?>" width="64" height="64" alt="Check Ticket Status"></div></td>
<td class="nobd" width="40%"><div class="ticket">Check Ticket Status</div><span class="par1">All requests, open or closed.</span></td>
</tr>
</table>
<table class="welcome nobd">
<tr>
<td class="nobd" width="50%"><div class="par1">Please provide as much detail as possible so we can best assist you. To update a previously submitted ticket, use our Check Ticket Status.</div></td>
<td class="nobd" width="50%"><div class="par1">For your convenance, we provide archives and history of all your current and past submitted ticket requests, complete with all responses.</div></td>
</tr>
</table>
<table class="welcome nobd">
<tr>
<td class="nobd" width="50%"><div align="center"><a class="green but" href="?service=new">Open A New Ticket</a></div></td>
<td class="nobd" width="50%"><div align="center"><a class="blue but" href="?service=list">Check Ticket Status</a></div></td>
</tr>
</table>
<table class="welcome nobd">
<tr>
<td class="nobd" width="50%"><div class="par2">A valid email address is required.</div></td>
<td class="nobd" width="50%"><div class="par2">All responses are from: <?php bloginfo( 'name' ); ?>!</div></td>
</tr>
<tr>
<td class="nobd" width="50%"><div class="par1">Please note, it's only necessary to submit one ticket for each issue. Submitting multiple requests for the same issue can actually increases our response times.</div></td>
<td class="nobd" width="50%"><div class="par1">New tickets will receive a confirmation response back immediately! If you don't receive a response from our system, check your email program "<font color="#990000">Junk</font>" folder.</div></td>
</tr>
</table>