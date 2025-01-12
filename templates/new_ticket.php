<?php
/*
Template Name: new_ticket.php
*/
?>
<div id="thContainer">
<?php 
if(isset($_REQUEST['create-ticket']))
{?>
<div class="clear" style="padding: 5px;"></div>
<p id="msg_notice">A new request has been created successfully!</p>
<p align="center">
<br />
<i>We are currently notifing the selected department staff...</i><br />
and a confirmation email is being sent to you at: <font color=green><?php echo $current_user->user_email; ?></font>
<br /><br />
<center><script language="javascript" src="<?php echo plugin_dir_url(__FILE__).'../js/timerbar.js';?>"></script></center>
<br />
<center>Thank you for contacting us!</center>
</p>
<?php } else {?>
<div id="new_ticket">
<div id="new_ticket_text1">Open a New Ticket</div>
<div style="clear: both"></div>
<div id="new_ticket_text2">Please fill in the form below to open a new ticket. All fields mark with [<font color=red>*</font>] <em>Are Required!</em></div>
<div style="clear: both"></div>
<form id="ticketForm" name="newticket" method="post" enctype="multipart/form-data" onsubmit="return validateFormNewTicket()">
<input type="hidden" name="usid" value="<?php echo $current_user->ID; ?>"/>
<input type="hidden" name="ademail" value="<?php echo $admin_email; ?>"/>
<input type="hidden" name="stitle" value="<?php echo $title_name; ?>"/>
<input type="hidden" name="sdirna" value="<?php echo $dirname; ?>"/>
<input type="hidden" name="newtickettemp" value="<?php echo $newticket; ?>"/>
<div id="new_ticket_name">Username:</div>
<div id="new_ticket_name_input"><input class="ost" id="cur-name" type="text" name="cur-name" readonly="true" size="30" value="<?php echo $current_user->user_login; ?>"></div>
<div style="clear: both"></div>
<div id="new_ticket_email">Your Email:</div>
<div id="new_ticket_email_input"><input class="ost" id="email" type="text" name="email" readonly="true" size="30" value="<?php echo $current_user->user_email; ?>"></div>
<div style="clear: both"></div>
<div id="new_ticket_subject">Subject:</div>
<div id="new_ticket_subject_input"><input class="ost" id="subject" type="text" name="subject" size="35"/><font class="error">&nbsp;*</font></div>
<div style="clear: both"></div>
<div id="new_ticket_catagory">Catagories:</div>
<div id="new_ticket_catagory_input"><select id="topicId" name="topicId">
<option value="" selected="selected"> Select a Category </option>
<?php 
	foreach($topic_opt as $topic) 
	{ 
	echo '<option value="'.$topic->topic_id .'">'.$topic->topic .'</option>'; 
        } 
?>
</select><font class="error">&nbsp;*</font></div>
<div style="clear: both"></div>
<div id="new_ticket_priority">Priority:</div>
<div id="new_ticket_priority_input"><select id="priority" name="priorityId">
<option value="" selected="selected"> Select a Priority </option>
<?php
	foreach($pri_opt as $priority) 
	{ 
	echo '<option value="'.$priority->priority_id .'">'.$priority->priority_desc .'</option>'; 
	} 
?>
</select><font class="error">&nbsp;*</font></div>
<div style="clear: both"></div>
</div>
<table class="welcome nobd" align="center" width="95%" cellpadding="3" cellspacing="3" border="0">
<tr>
<td class="nobd" align="center"><div align="center" style="padding-bottom: 5px;">To best assist you, please be specific and detailed in your message<font class="error">&nbsp;*</font></div></td>
</tr>
<tr>
<td class="nobd" align="center">
<center><textarea id="message" rows="9" name="message"></textarea></center>
<div class="clear" style="padding: 5px;"></div></td>
</tr>
<tr>
<td class="nobd" align="center">
<p align="center" style="padding-top: 5px;"><input type="submit" name="create-ticket" value="Create Ticket">
&nbsp;&nbsp;<input type="reset" value="Reset"></p>
</form>
</td>
</tr>
</table>
</div>
<?php } ?>
<div class="clear" style="padding: 10px;"></div>
<script type="text/javascript" src="<?php echo plugin_dir_url(__FILE__).'../js/validate.js';?>"></script>