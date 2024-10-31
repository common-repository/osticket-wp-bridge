<?php
/*
Template Name: login.php
*/
?>
<div id="login_Reg">
<div class="clear" style="padding: 5px;"></div>
<table width="98%" align="center">
<tr>
<td>
<form action="<?php echo get_option('home'); ?>/wp-login.php" method="post" name="login" onsubmit="return validateFormLogin()">
<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
<table class="login">
<tr> 
<td><b>Login</b> - Current users of <?php bloginfo( 'name' ); ?> &raquo; <?php echo $title_name; ?>!</td>
</tr>
<tr> 
<td><input class="ost" type="text" name="log" id="user_login" size="20" /> Username</td>
</tr>
<tr> 
<td><input type="password" name="pwd" id="user_pass" size="20" /> Password</td>
</tr>
<tr> 
<td><div style="padding-bottom:5px;" align="left">&nbsp;Remember Me&nbsp;&nbsp;<input name="rememberme" type="checkbox" id="rememberme" value="forever"  /><span style="padding-left:24%;"><input name="submit" type="submit" value="Log-In &gt;&gt;" /></span></div></td>
</tr>
</table>
</form>
</td>
</tr>
</table>
<div class="clear" style="padding: 15px;"></div>
<table width="98%" align="center">
<tr>
<td>
<form action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>" class="user_new" id="user_new" method="post" name="user_new" onsubmit="return validateFormRegister()">
<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
<table class="register">
<tr> 
<td><b>Register</b> - New User &raquo; Check your email after Sign-Up!</td>
</tr>
<tr> 
<td><input class="ost" id="user_login" name="user_login" size="20" type="text"> Create a username</td>
</tr>
<tr> 
<td><input class="ost" id="user_email" name="user_email" size="20" type="text"> Valid email address</td>
</tr>
<tr>
<td><div align="center"><?php do_action('register_form'); ?></div></td>
</tr>
<tr> 
<td><div align="center" style="padding-bottom:5px;"><input id="register" type="submit" value="Sign-up &gt;&gt;"></div></td>
</tr>
</table>
</form>
</td>
</tr>
</table>
<div class="clear" style="padding: 15px;"></div>
<table width="98%" align="center">
<tr>
<td>
<form name="lostpasswordform" id="lostpasswordform" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" method="post" onsubmit="return validateFormForgot()">
<?php if(isset($_GET['resetpass']) && $_GET['resetpass'] == 'true'): ?>
<table class="forgot">
<tr> 
<td><font color="green"><b>Success!</b></font> - Please check your email to reset your password!</td>
<tr> 
<td><input class="ost" type="text" name="user_login" id="user_login" size="30"> Username or Email address</td>
</tr>
<tr> 
<td><div align="center" style="padding-bottom:5px;">
<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>&resetpass=true" />
<input type="hidden" name="user-cookie" value="1" />
<input type="submit" name="wp-submit" id="wp-submit" value="Reset-password &gt;&gt;">
</div></td>
</tr>
</table>
<?php else: ?>
<table class="forgot">
<tr> 
<td><b>Forgot Password</b> - A password reset link will be emailed to you!</td>
</tr>
<tr> 
<td><input class="ost" type="text" name="user_login" id="user_login" size="30"> Username or Email address</td>
</tr>
<tr> 
<td><div align="center" style="padding-bottom:5px;">
<?php do_action('login_post', 'resetpass'); ?>
<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>&resetpass=true" />
<input type="hidden" name="user-cookie" value="1" />
<input type="submit" name="wp-submit" id="wp-submit" value="Reset-password &gt;&gt;">
</div></td>
</tr>
</table>
<?php endif ?>
</form>
</td>
</tr>
</table>
<div class="clear" style="padding: 10px;"></div>
</div>
<script type="text/javascript" src="<?php echo plugin_dir_url(__FILE__).'../js/validate.js';?>"></script>