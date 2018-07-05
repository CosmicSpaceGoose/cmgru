<div id="acc">
	<form method="POST" action="/account/update">
<?php	if ( isset( $confirm ) && $confirm == 0) { ?>
			<div class="schnelleReporta">You didn't confirm your account. Check your mailbox for mail with instructions or press <span><b>Sent</b></span> button, to sent new mail with instructions.
			<button class="btns" type="submit" name="submit" value="resent">Sent</button>
			</div>
<?php	}	?>
		<div><input type="text" placeholder="E-mail" name="email" value="<?php if ( isset( $_POST['email'])) { 
				echo $_POST['email'];
			} else if ( isset( $email )) {
				echo $email;
			}	?>">
			<span class="error"><?php if (isset($mailErr)) echo $mailErr; ?></span></div>
		<button class="btns" type="submit" name="submit" value="mail">Change e-mail</button>
		<div><input type="text" placeholder="Username" name="username" value="<?php if ( isset( $_POST['username'])) { 
				echo $_POST['username'];
			} else if ( isset( $username )){
				echo $username;
			}	?>">
			<span class="error"><?php if ( isset( $nameErr )) echo $nameErr; ?></span></div>
		<button class="btns" type="submit" name="submit" value="name">Change username</button>
		<div><input type="password" placeholder="Old Password" name="oldpass" value="<?php if (isset($_POST['oldpass'])) { echo $_POST['oldpass']; } ?>"></div>
		<div><input type="password" placeholder="New Password" name="newpass" value="<?php if (isset($_POST['newpass'])) { echo $_POST['newpass']; } ?>"></div>
		<div><input type="password" placeholder="Confirm Password" name="conpass" value="<?php if (isset($_POST['conpass'])) { echo $_POST['conpass']; } ?>">
			<span class="error"><?php if ( isset( $psswdErr )) echo $psswdErr; ?></span></div>
		<button class="btns" type="submit" name="submit" value="pass">Change password</button>
		<label id="switch">
			<input type="checkbox" name="notify" onchange="switchNotify( this )"<?php if (isset($reply) && $reply == 1) echo " checked"; ?>>
			<span class="slider round">On Off</span>
		</label>
		<div id="teeeext">Mail notify</div>
	</form>
</div>
<script type="text/javascript" src="/js/switch.js"></script>