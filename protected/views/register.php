<?php
/**
 * MODUL 133 | WEBUMFRAGE
 *
 * Register form
 *
 * @author Janina Imberg
 * @version 1.0
 *
 * ---------------------------------------------------------------- */
?>

<?php if( !defined( 'RESTRICTED' ) ) { die( 'Nein, nein, nein. Soooo wird das nichts!');  } ?>
<form id="register-form" method="post" action="#">
    <h1>Registrierung</h1>
	<span class="form">
		<label>Benutzername: </label>
		<input type="text" value="<?php if( !isset( $_POST[ 'username-register' ] ) ) { echo ""; } else { echo $_POST[ 'username-register' ]; } ?>" placeholder="Benutzername" id="username-register" name="username-register" <?php if( isset( $_POST['error']['user'] ) ) { echo "class='error'"; } else { echo "class=''"; }?>/>
		<p class="error-msg"><?php if( isset( $_POST['error'][ 'user' ] ) ) { echo $_POST['error'][ 'user' ]; } else { echo ""; } ?></p>
	</span>
	
    <span class="form">
		<label>Passwort: </label>
		<input type="password" value="<?php if( !isset( $_POST[ 'pwd-register' ] ) ) { echo ""; } else { echo $_POST[ 'pwd-register' ]; } ?>" placeholder="Passwort" id="pwd-register" name="pwd-register" <?php if( isset( $_POST['error']['pwd'] ) ) { echo "class='error'"; } else { echo "class=''"; } ?>/>
		<p class="error-msg"><?php if( isset( $_POST['error'][ 'pwd' ] ) ) { echo $_POST['error'][ 'pwd' ]; } else { echo ""; } ?></p>
	</span>
		
    <span class="form">
		<label>Bestätigen: </label>
		<input type="password" value="<?php if( !isset( $_POST[ 'pwd-register-confirm' ] ) ) { echo ""; } else { echo $_POST[ 'pwd-register-confirm' ]; } ?>" placeholder="Passwort bestätigen" id="pwd-register-confirm" name="pwd-register-confirm" <?php if( isset( $_POST['error']['pwd-confirm'] ) ) { echo "class='error'"; } else { echo "class=''"; }?>/>
		<p class="error-msg"><?php if( isset( $_POST['error'][ 'pwd-confirm' ] ) ) { echo $_POST['error'][ 'pwd-confirm' ]; } else { echo ""; } ?></p>
	</span>

    <input type="hidden" name="register" value="register" />
    <input type="submit" value="registrieren" />
</form>  