<?php if( !defined( 'RESTRICTED' ) ) { die( 'Nein, nein, nein. Soooo wird das nichts!' );  } ?>
<form id="login-form" method="post" action="#">
    <h1>Login</h1>
	<span class="form">
		<label>Benutzername: </label>
		<input type="text" value="<?php if( !isset( $_POST[ 'username' ] ) ) { echo ""; } else { echo $_POST[ 'username' ]; } ?>" placeholder="Benutzername" id="username" name="username" <?php if( isset( $_POST['error']['login'] ) ) { echo "class='error'"; } else { echo "class=''"; }?> />
		<p class="error-msg"><?php if( isset( $_POST['error']['login'] ) ) { echo $_POST['error']['login']; } else { echo ""; } ?></p>
	</span>
	
    <span class="form">
		<label>Passwort: </label>
		<input type="password" value="<?php if( !isset( $_POST[ 'pwd' ] ) ) { echo ""; } else { echo $_POST[ 'pwd' ]; } ?>" placeholder="Passwort" id="pwd" name="pwd" <?php if( isset( $_POST['error']['login'] ) ) { echo "class='error'"; } else { echo "class=''"; } ?>/>
		<p class="error-msg"><?php if( isset( $_POST['error']['login'] ) ) { echo $_POST['error']['login']; } else { echo ""; } ?></p>
	</span>

    <input type="hidden" name="login" value="login" />
    <input type="submit" value="einloggen" />
</form>