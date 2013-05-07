<?php
/**
 * MODUL 133 | WEBUMFRAGE
 *
 * Template for evaluation
 *
 * @author Janina Imberg
 * @version 1.0
 *
 * ---------------------------------------------------------------- */
?>

<?php if( !isset( $_SESSION[ 'loggedin' ] ) ): ?>
    <?php header( "Location: ?page=login" ); ?>
<?php endif; ?>

<?php $survey = new Survey(); ?>

<?php if( $survey->hasResults() ): ?>
    <?php for( $i = 0; $i <= 6; $i++ ): ?>
        <?php $data[$i] = $survey->setChartData( $i ); ?>
        <?php $percent = $survey->getPercent( $i ); ?>
        <div class='result-charts'>
            <h3><?php echo $survey->getLabel( $i ); ?></h3>

            <div class='result-charts-graph'>
                <canvas id='chart_<?php echo $i; ?>' class='chart' width='150' height='150' data-chart='<?php echo $data[$i]; ?>'></canvas>
            </div>
            <div class='result-charts-text'>
                <ul>
                    <?php for( $k = 1; $k <= 4; $k++ ): ?>
                    <li>
                        <span class='color-icon' style='background: <?php echo $survey->getColors( $k ); ?>;'></span>
                        <span class='percent-text <?php if($percent[$k] == 0 ) { echo "not-set"; } ?>'><?php echo $survey->getAnswers( $k ); ?>: <?php echo $percent[$k] ?> %</span>
                    </li>
                    <?php endfor; ?>
                </ul>
            </div>
        </div>
    <?php endfor; ?>
<?php else: ?>
    <div class="participated-notice">
        <h1>Keine Daten vorhanden.</h1>
        <h2>Nur Mut - und sei der Erste, der die Umfrage beantwortet!</h2>
    </div>
<?php endif; ?>