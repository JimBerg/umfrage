<?php

class Helper {

    public static function setCheckboxes( $name )
    {
        $selectedElems = array();
        if( isset( $_POST['question'] ) ) {
            $selected = $_POST;
            foreach( $selected as $key => $value ) {
                $selectedElems[] = $key."_".$value;
            }
        }
        if( in_array( $name, $selectedElems ) ) {
            echo "checked";
            return;
        } else {
            return "";
        }
    }
}
