<?php
/**
 * MODUL 133 | WEBUMFRAGE
 *
 * Main Layout that includes all other views
 *
 * @author Janina Imberg
 * @version 1.0
 *
 * ---------------------------------------------------------------- */
?>

<?php if( !defined( 'RESTRICTED' ) ) { die( 'Nein, nein, nein. Soooo wird das nichts!');  } ?>
<?php
    if( isset( $_GET['page'] ) ) {
        $page = $_GET['page'];
    } else {
        $page = 'login';
    }
    $user = new User();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Webumfrage</title>
        <meta name="description" content="webumfrage">
        <meta name="author" content="janina imberg">

        <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>css/styles.css">
    </head>

    <body class="<?php echo $page; ?>">
        <div id="header">
            <h1>Webumfrage</h1>
            <?php include_once VIEW_PATH.'navigation.php'; ?>
        </div>
        <div id="content">
            <?php if( !isset( $_SESSION[ 'loggedin' ] ) ): ?>
                <?php include_once VIEW_PATH.$page.'.php'; ?>
            <?php else: ?>
                <?php include_once VIEW_PATH.$page.'.php'; ?>
            <?php endif; ?>
        </div>
    </body>
    <script type="text/javascript" src="<?php echo TEMPLATE_PATH; ?>js/jquery-1.8.1.min.js"></script>
    <script type="text/javascript" src="<?php echo TEMPLATE_PATH; ?>js/Chart.js"></script>
    <script type="text/javascript" src="<?php echo TEMPLATE_PATH; ?>js/script.js"></script>
</html>
