<form id="login" action="<?php echo get_href($_GET["site"], array(), true); // Stay on this site ?>" method="post" accept-charset="UTF-8">
		<input type="text" name="username" id="username" maxlength="50" placeholder="Username" />
		<br/>
		<input type="password" name="password" id="password" maxlength="50" placeholder="Password" />
		<br/>
		<!-- Add hidden view to verify that this is indeed a login -->
		<input type="hidden" name="islogin" value="true">
		<input type="submit" name="Login" value="Login" />
</form>