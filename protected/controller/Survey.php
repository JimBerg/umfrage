<?php
/**
 * MODUL 133 | WEBUMFRAGE
 *
 * class Survey
 * evaluates survey results
 * set data for charts
 *
 * @author Janina Imberg
 * @version 1.0
 *
 * ---------------------------------------------------------------- */

class Survey
{

    public function __construct()
    {
        //nothing to construct :)
    }

    /**
     * get file contents
     *
     * @return array
     */
    private function readFile()
    {
        $file = ANSWER_FILE;
        $content = array();
        if( $file != null && file_exists( $file ) ) {
            if( ( $handle = fopen( $file, "r" ) ) !== false ) {
                while( ( $data = fgetcsv( $handle, filesize( $file ), ';') ) !== false ) {
                    array_push( $content, $data );
                }
                fclose( $handle );
            }
        }
        return $content;
    }

    /**
     * read textfile with answers
     * loop over all results keys,
     * match same keys together
     * build new array, with arraykeys = radiobutton groups
     *
     * @return array $questions | array error
     */
    private function getResults()
    {
        $file = $this->readFile();
        $elems = sizeof( $file );
        $results = array();
        for( $i = 0; $i < $elems; $i++ ) { // loop over all records and split into questions
            foreach( $file[$i] as $key => $value ) {
                $question[$key][] = $value; // save each question bundled with its results
            }
        }
        return $question;
    }

    /**
     * get results of given question from textfile
     * array with results for values 1 - 4
     *
     * @param $key = array key
     * @return array $question
     */
    private function getSingleData( $key )
    {
        $questions = $this->getResults();
        return $questions[ $key ];
    }

    /**
     * format data for chart.js as json object
     * with keys: value and color
     *
     * @param String $key
     * @return json Object | stdClass
     */
    public function setChartData( $key )
    {
        $single = $this->getSingleData( $key );
        $values = array_count_values( $single );

        $data = array();
        foreach ( $values as $key => $value ) {
            $item = new stdClass();
            $item->key = $key;
            $item->value = $value * 10;
            $item->color = $this->getColors( $key );
            array_push( $data, $item );
        }
        return json_encode( $data );
    }

    /**
     * match colors for labels
     *
     * @param int $key = $key of answer for each group
     * @return String $color as hexvalue
     */
    public function getColors( $key )
    {
        $colors = array(
            '1' => '#E0E4CC',
            '2' => '#69D2E7',
            '3' => '#697000',
            '4' => '#F38630'
        );
        return $colors[ $key ];
    }

    /**
     * matches array keys to questions
     * and actually this should be dynamic too...
     * but well... next time ;)
     *
     * @param int $key
     * @return string
     */
    public function getLabel( $key )
    {
        $label = array(
            '0' => 'War das Essen für Sie vielseitig?',
            '1' => 'Erhalten Sie zu dem Mitagessen jeweils Salat oder Gemüse?',
            '2' => 'Nehmen Sie das Personal als freundlich wahr?',
            '3' => 'Kann Ihnen das Personal bei Fragen weiterhelfen?',
            '4' => 'Fühlen Sie sich wohl in dieser Atmosphäre?',
            '5' => 'Stehen Ihnen genügend Hilfsmittel für den Alltag zur Verfügung?',
            '6' => 'Wenn Sie weitere Hilfsmittel wünschen, wird ihrem Wunsch entsprochen?',
        );
        return $label[ $key ];
    }

    /**
     * set labels for each value
     *
     * @param $key = array key
     * @return String $answer
     */
    public function getAnswers( $key )
    {
        $answers = array(
            1 => 'Miserabel',
            2 => 'Eher schlecht',
            3 => 'Ganz in Ordnung',
            4 => 'Brilliant'
        );
        return $answers[ $key ];
    }

    /**
     * calculate percent of given answer
     *
     * @param int
     * @return array
     */
    public function getPercent( $question_id )
    {
        $file = $this->readFile();
        $total = sizeof( $file );
        $data = $this->setChartData( $question_id );
        $value = json_decode( $data );

        $percent = array(
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0
        );
        for( $j = 0; $j < sizeof( $value ); $j++ ) {
            $percent[$value[$j]->key] = round( ( $value[$j]->value / $total ), 2 ) * 10;
        }
        return $percent;
    }

    /**
     * check if survey has results
     * well, well, well I know... redundancy
     * just fetch the num of results once
     *
     * @return bool
     */
    public function hasResults()
    {
        $file = $this->readFile();
        $total = sizeof( $file );
        if( $total == 0 ) {
            return false;
        } else {
            return true;
        }
    }
}