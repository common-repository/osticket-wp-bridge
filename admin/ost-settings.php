<?php
/*
Template Name: ost-settings
*/
?>
<?php require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/includes/udscript.php' ); ?>
<div class="wrap">
<div class="headtitle">osTicket Settings</div>
<div style="clear: both"></div>
<?php require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/admin/header_nav.php' ); ?>
<div id="tboxwh" class="pg1">Here you can enter/change your osTicket information that our bridge recognizes.<br />You can do the same thing in the osTicket Admin area. But, we do have some suggestion's below.</div>
<div style="clear: both"></div>
<?php 
if($version!="17") { 
	require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/admin/db-settings-18.php' );
} else {
	require_once( WP_PLUGIN_DIR . '/osticket-wp-bridge/admin/db-settings-17.php' );
}
?>
<div style="padding-left:35px;padding-top:6px;padding-bottom:5px;">
*System Settings For <b>osTicket &raquo; <?php if($version=="18") { echo "v1.8.1"; } else { echo "v1.7+"; } ?></b>
</div>
<form name="ost-settings" action="admin.php?page=ost-settings" method="post">
<input type="hidden" name="adname" value="<?php echo $admin_fname; ?> <?php echo $admin_lname; ?>"/>
<table class="cofigtb">
<tr>
<td class="config_td"><label class="config_label">Support Center Status:</label></td>
<td>&nbsp;<input type="radio" name="online" id="enabled" class="enabled" value="1" <?php if($isactive=="1") echo "checked";?>/><font color="green">Online</font> (Active) &nbsp;&nbsp;<input type="radio" name="online" id="disabled" class="disabled" value="0" <?php if($isactive!="1") echo "checked";?>/><font color="red">Offline</font><span style="padding-left:20px;">( offline will display maintenance message on website )</span></td> 
</tr>
<tr>
<td class="config_td"><label class="config_label">Helpdesk Name/Title:</label></td>                
<td><input type="text" name="title_name" id="title_name" size="20" value="<?php echo $title_name; ?>"/>&nbsp;&nbsp;( displayed in emails & welcome/user pages )</td>
</tr>
<tr>
<td class="config_td"><label class="config_label">Maximum Open Tickets:</label></td>                
<td><input type="text" name="max_open_tickets" id="max_open_tickets" size="20" value="<?php echo $max_open_tickets; ?>"/>&nbsp;&nbsp;( per/user - enter 0 for unlimited )</td>
</tr>
<tr>
<td class="config_td"><label class="config_label">Reply Separator Tag:</label></td>                
<td><input type="text" name="reply_sep" id="reply_sep" size="20" value="<?php echo $reply_sep; ?>"/>&nbsp;&nbsp;( should be blank - if you are email polling...read &raquo; <a href="javascript:doMenu2('main2');" id="xmain2">[+]</a> )</td>
</tr>
<tr>
<td class="note" colspan="2">
<div id="main2" style="display: none;">
Note: If email polling, login to: osTicket->Emails->Templates->Response/Reply Template remove %{ticket.client_link}<br />Replace with &raquo; <?php echo site_url()."/$dirname/?service=view&ticket="; ?>%{ticket.number} &laquo;
</div>
</td>
</tr>
</table>
<div style="padding-left:35px;padding-top:6px;padding-bottom:5px;">*Administration Settings For <b>osTicket &raquo; <?php if($version=="18") { echo "v1.8.1"; } else { echo "v1.7+"; } ?></b></div>
<table class="cofigtb">
<tr>
<td class="config_td"><label class="config_label">Admin First Name:</label></td>                
<td><input type="text" name="admin_fname" id="admin_fname" size="20" value="<?php echo $admin_fname; ?>"/>&nbsp;&nbsp;<span style="padding-left:321px;">&nbsp;</span></td>
</tr>
<tr>
<td class="config_td"><label class="config_label">Admin Last Name:</label></td>                
<td><input type="text" name="admin_lname" id="admin_lname" size="20" value="<?php echo $admin_lname; ?>"/>&nbsp;&nbsp;</td>
</tr>
<tr>
<td class="config_td"><label class="config_label">Admin's Email Address:</label></td>                
<td><input type="text" name="admin_email" id="admin_email" size="20" value="<?php echo $admin_email; ?>"/>&nbsp;&nbsp;( system administrator email )</td>
</tr>
<tr>
<td class="config_td"><label class="config_label">Display Admin Name:</label></td>
<td>&nbsp;<input type="radio" name="hidename" value="1" <?php if($hidename=="1") echo "checked";?>/>Yes-Show&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="hidename" value="0" <?php if($hidename!="1") echo "checked";?>/>No-Don't<span style="padding-left:32px;">( Yes - will display poster name in ticket threads )</span></td> 
</tr>
</table>
<div align="center">
<input type="submit" name="ost-settings" class="button-primary" value="Save Settings" />
</div>
</form>
</div><!--End wrap-->