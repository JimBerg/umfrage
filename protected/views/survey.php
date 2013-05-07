<?php
/**
 * MODUL 133 | WEBUMFRAGE
 *
 * Template for survey questions
 *
 * @author Janina Imberg
 * @version 1.0
 *
 * ---------------------------------------------------------------- */
?>
<?php if( !isset( $_SESSION[ 'loggedin' ] ) ): ?>
    <?php header( "Location: ?page=login" ); ?>
<?php endif; ?>

<?php $questions = $user->getQuestions(); ?>
<?php if( $user->hasParticipated() == '0' ): ?>
    <h1>Fragekatalog: Altersheim</h1>
    <form id="question-form" method="post" action="#" onsubmit="return validateForm();">
        <?php foreach( $questions as $item ): ?>
            <?php if( $item[2] == 1 ) { echo "<h3>$item[0]</h3>"; } ?>
            <span class="form">
                <ul>
                    <label><?php echo $item[3]; ?></label>
                    <?php for( $i = 4; $i <= 7; $i++ ): ?>
                        <?php $value = $i - 3; ?>
                        <li>
                            <input type='radio' name='<?php echo "cat{$item[1]}_question{$item[2]}"; ?>' value='<?php echo $value; ?>' <?php Helper::setCheckboxes( "cat{$item[1]}_question{$item[2]}_{$value}" ); ?>>
                            <span class='text'><?php echo $item[$i]; ?></span>
                        </li>
                    <?php endfor; ?>
                </ul>
            </span>
        <?php endforeach; ?>
        <input type="hidden" name="question" value="question" />
        <input type="submit" value="senden" />
    </form>
<?php else: ?>
    <div class="participated-notice">
        <h1>Danke für dein Interesse.</h1>
        <h2>Aber du hast an dieser Umfrage schon teilgenommen.</h2>
    </div>
<?php endif; ?>

