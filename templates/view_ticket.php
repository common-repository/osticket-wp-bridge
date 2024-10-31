<?php
/*
Template Name: view_ticket.php
*/
?>
<div id="ticket_view">
<div id="tic_number">Ticket ID #<?php if($version=="18") { echo $ticketinfo->number; } else { echo $ticketinfo->ticketID; } ?></div>
<div id="tic_icon"><a href="?service=view&ticket=<?php if($version=="18") { echo $ticketinfo->number; } else { echo $ticketinfo->ticketID; } ?>" title="Reload"><span class="Icon refresh"></span></a></div>
<div style="clear: both"></div>
</div>
<div id="tic_info_box">
<div id="tic_stat">Ticket Status:</div>
<div id="tic_stat_info"><?php 
if($ticketinfo->status=='closed') { 
	echo '<font color=red>Closed</font>'; 
	} elseif ($ticketinfo->status=='open') { 
	echo '<font color=green>Open</font>'; 
	} 
?></div>
<div id="tic_name">Name:</div>
<div id="tic_name_user"><?php echo $ticketinfo->name; ?></div>
<div style="clear: both"></div>
<div id="tic_dept">Department:</div>
<div id="tic_dept_info"><?php echo $ticketinfo->topic; ?></div>
<div id="tic_email">Email:</div>
<div id="tic_email_user">
<?php if($version=="18") { echo $ticketinfo->address; } else { echo $ticketinfo->email; } ?>
</div>
<div style="clear: both">
</div>
<div id="tic_created">Create Date:</div>
<div id="tic_created_date"><?php echo $ticketinfo->created; ?></div>
<div id="tic_phone">Priority:</div>
<div id="tic_phone_info"><?php echo $ticketinfo->priority_desc; ?></div>
<div style="clear: both"></div>
</div>
<div id="tic_sub">
<div id="tic_subject">Subject:</div>
<div id="tic_subject_info">[ <?php echo Format::stripslashes($ticketinfo->subject); ?> ]</div>
<div style="clear: both"></div>
</div>
<div id="tic_thread_img_box">
<div><span class="Icon thread">Ticket Thread</span></div>
<div style="clear: both"></div>
</div>
<div id="thContainer">
<div id="ticketThread">
<?php foreach($threadinfo as $thread_info) { ?>
<table width="100%" cellspacing="0" cellpadding="1" border="0" class="<?php echo $thread_info->thread_type; ?>">
<tbody>
<tr>
<th><?php echo $thread_info->created; ?><span id="ticketThread"><?php if($hidename==1) { echo $thread_info->poster; } ?></span></th>
</tr>
<tr>
<td><?php echo Format::linkslash($thread_info->body);?></td>
</tr>
</tbody>
</table>
<?php } ?>
<div style="clear: both"></div>
</div>
<div id="tic_post">
<div id="tic_post_reply">Post a Reply</div>
<div id="tic_post_detail">To best assist you, please be specific and detailed in your reply.</div>
<div style="clear: both"></div>
</div>
<table class="welcome nobd" align="center" width="95%" cellspacing="0" cellpadding="3">
<tr>
<td class="nobd" align="center">
<form id="reply" action="" name="reply" method="post" enctype="multipart/form-data" onsubmit="return validateFormReply()">
<input type="hidden" value="<?php echo $thread_info->ticket_id;?>" name="tic_id">
<input type="hidden" value="reply" name="a">
<input type="hidden" name="usticketid" value="<?php if($version=="18") { echo $ticketinfo->number; } else { echo $ticketinfo->ticketID; } ?>"/>
<input type="hidden" name="usid" value="<?php echo $current_user->ID; ?>"/>
<input type="hidden" name="usname" value="<?php echo $ticketinfo->name; ?>"/>
<input type="hidden" name="usemail" value="<?php if($version=="18") { echo $ticketinfo->address; } else { echo $ticketinfo->email; } ?>"/>
<input type="hidden" name="usdepartment" value="<?php echo $ticketinfo->dept_name; ?>"/>
<input type="hidden" name="uscategories" value="<?php echo $ticketinfo->topic; ?>"/>
<input type="hidden" name="ussubject" value="<?php echo $ticketinfo->subject; ?>"/>
<input type="hidden" name="ustopicid" value="<?php echo $ticketinfo->topic_id; ?>"/>
<input type="hidden" name="ademail" value="<?php echo $admin_email; ?>"/>
<input type="hidden" name="stitle" value="<?php echo $title_name; ?>"/>
<input type="hidden" name="sdirna" value="<?php echo $dirname; ?>"/>
<input type="hidden" name="postconfirmtemp" value="<?php echo $postconfirm; ?>"/>
<center><textarea rows="9" id="message" name="message"></textarea></center>
</td>
</tr>
<tr>
<td class="nobd" align="center"><div class="clear" style="padding: 5px;"></div>
<?php
	if($ticketinfo->status=='closed') { 
	echo '<center><label><input type="checkbox" name="open_ticket_status" id="open_ticket_status" value="open">&nbsp;&nbsp;<font color=green>Reopen</font> Ticket On Reply</label></center>'; 
	} elseif ($ticketinfo->status=='open') { 
	echo '<center><label><input type="checkbox" name="close_ticket_status" id="close_ticket_status" value="closed">&nbsp;&nbsp;<font color=red>Close</font> Ticket On Reply</label></center>'; 
	} 
?>
<div class="clear" style="padding: 5px;"></div></td>
</tr>
<tr>
<td class="nobd" align="center">
<center><input type="submit" value="Post Reply" name="post-reply"/>
&nbsp;&nbsp;<input type="reset" value="Reset"/>&nbsp;&nbsp;
<input type="button" value="Cancel" onClick="history.go(-1)"/></center>
</form>
</td>
</tr>
</table>
<div style="clear: both"></div>
</div>
<div class="clear" style="padding: 10px;"></div>
<script type="text/javascript" src="<?php echo plugin_dir_url(__FILE__).'../js/validate.js';?>"></script>