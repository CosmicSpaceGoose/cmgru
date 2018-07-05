<?php
if (( isset($_GET) && isset($_GET['frm'])) || isset($_POST)) {
	if ( $_GET['frm'] == 'signup' || ( isset($data) && $data['frm'] == 'signup' )){ ?>
<div id="form_holder">
	<form class="formz" method="POST" action="/auth/signup">
		<div><input type="text" placeholder="E-mail" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
			<span class="error"><?php if (isset($mailErr)) echo $mailErr; ?></span></div>
		<div><input type="text" placeholder="Username" name="username" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>">
			<span class="error"><?php if (isset($nameErr)) echo $nameErr; ?></span></div>
		<div><input type="password" placeholder="Password" name="password" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>">
		</div>
		<div><input type="password" placeholder="Confirm password" name="sign_cnfrm" value="<?php if (isset($_POST['sign_cnfrm'])) echo $_POST['sign_cnfrm']; ?>">
			<span class="error"><?php if (isset($psswdErr)) echo $psswdErr; ?></span></div>
		<button class="btns" type="submit" name="submit" value="signup">Sign Up</button>
	</form>
</div>
<?php	} else if ( $_GET['frm'] == 'login' || (isset($data) && $data['frm'] == 'login' )) { ?>
	<div id="form_holder">
	<form class="formz" method="POST" action="/auth/login">
		<input type="text" placeholder="E-mail" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
		<input type="password" placeholder="Password" name="password" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>">
		<span class="error"><?php if (isset($logErr)) echo $logErr; ?></span>
		<button class="btns" type="submit" name="submit" value="login">Login</button>
	</form>
	</div>
<?php	} else if ( $_GET['frm'] == 'reset' || (isset($data) && $data['frm'] == 'reset' )) { ?>
	<div id="form_holder">
	<form class="formz" method="POST" action="/auth/reset">
		<input type="text" placeholder="E-mail" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
		<span class="error"><?php if (isset($mailErr)) echo $mailErr; ?></span>
		<button class="btns" type="submit" name="submit" value="reset">Reset</button>
	</form>
	</div>
<?php	} else {
	header("Location: /landing/404");
	}
} else {
	header("Location: /landing/404");
}	?>
