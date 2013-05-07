<?php
/**
 * MODUL 133 | WEBUMFRAGE
 *
 * Template for navigation
 *
 * @author Janina Imberg
 * @version 1.0
 *
 * ---------------------------------------------------------------- */
?>
<?php if( !defined( 'RESTRICTED' ) ) { die( 'Nein, nein, nein. Soooo wird das nichts!');  } ?>
<?php if( !isset( $_SESSION[ 'loggedin' ] ) ): ?>
    <ul id="main-nav">
        <li><a href="?page=login" class="<?php if( $page == 'login' ) { echo 'active'; } ?>">Einloggen</a></li>
        <li><a href="?page=register" class="<?php if( $page == 'register' ) { echo 'active'; } ?>">Registrieren</a></li>
    </ul>
<?php else: ?>
    <ul id="main-nav">
        <li><a href="?page=survey" class="<?php if( $page == 'survey' ) { echo 'active'; } ?>">Fragekatalog</a></li>
        <li><a href="?page=evaluation" class="<?php if( $page == 'evaluation' ) { echo 'active'; } ?>">Auswertung</a></li>
        <li id="logout"><a href="?page=logout">Logout</a></li>
    </ul>
<?php endif; ?>

