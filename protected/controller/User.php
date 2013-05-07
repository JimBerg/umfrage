<?php
/**
 * MODUL 133 | WEBUMFRAGE
 *
 * class User
 * user and sessionmanagement
 * read and write data to files
 *
 * @author Janina Imberg
 * @version 1.0
 *
 * ---------------------------------------------------------------- */

class User
{
    private $user;

    /**
     * stores various config parameters
     * @var array $config
     */
    private $config = array(
        'salt' => 'wLo1MbsyVM10df90DZ3d2a54p0703lzS'
    );

    /**
     * handles incoming get and post requests
     * and delegate them to the appropriate function
     */
    public function __construct()
    {
        if( !isset( $_SESSION ) ) {
            session_start();
        }
        if( isset( $_POST['login'] ) ) {
            $user = trim( htmlentities( $_POST['username'] ) );
            $pwd = $this->encryptPassword( trim( htmlentities( $_POST['pwd'] ) ) );
            $this->login( $user, $pwd );
        } else if( isset( $_POST['register'] ) ) {
            $this->register();
        } else if( isset( $_POST['question'] ) ) {
            $this->saveSurvey();
        }
        if( isset( $_GET['page'] ) && $_GET['page'] == 'logout' ) {
            $this->logout();
        }
    }

    /**
     * login process is called when form was submitted
     * check if input is valid
     * set error messages if not
     * start session and redirect to survey if valid
     *
     * @param string $user
     * @param string $pwd
     * @return void
     */
    private function login( $user, $pwd )
    {
        $valid = $this->validateLoginData( $user, $pwd );
        if( !$valid ) {
            if( isset( $_SESSION ) ) {
                $_SESSION = array();
                if( isset( $_COOKIE[ session_name() ] ) ) {
                    $cookie_expires  = time() - date('Z') - 3600;
                    setcookie( session_name(), '', $cookie_expires, '/');
                }
                session_destroy(); //just to make sure...
            }
            return $_POST['error']['login'] = "Benutzer oder Passwort falsch";
        } else {
            if( !isset( $_SESSION ) ) {
                session_start();
            }
            $_SESSION[ 'username' ] = $user;
            $_SESSION[ 'loggedin' ] = true;
            self::redirect( 'survey' );
        }
    }

    /**
     * register process
     * evaluate post data of submitted form
     * return errors if not valid
     * redirect to login if valid
     *
     * @return array | bool
     */
    private function register()
    {
        $error = $this->validateRegisterData();
        if( $error ) {
            return $error;
        } else {
            $user = trim( htmlentities( $_POST['username-register'] ) );
            $pwd = $this->encryptPassword( trim( htmlentities( $_POST['pwd-register'] ) ) );
            $data = array(
                'user' => $user,
                'password' => $pwd,
                'hasParticipated' => '0'
            );
            $this->writeUser( $data );
            $this->login( $user, $pwd );
            return;
        }
    }

    /**
     * logout process
     * clear session and cookies
     * redirect to login
     *
     * @return void
     */
    private function logout()
    {
        $_SESSION = array();
        if( isset( $_COOKIE[ session_name() ] ) ) {
            $cookie_expires  = time() - date('Z') - 3600;
            setcookie( session_name(), '', $cookie_expires, '/');
        }
        session_destroy();
        self::redirect( 'login' );
    }

    /**
     * validate user input
     * user: greater then 6 chars, only chars and _
     * pwd: exactly 6 chars only numbers
     *
     * @return array|bool
     */
    private function validateRegisterData()
    {
        $error = array();
        $valid = true;
        $username = trim( htmlentities( $_POST['username-register'] ) );
        $password = trim( htmlentities( $_POST['pwd-register'] ) );
        $passwordConfirm = trim( htmlentities( $_POST['pwd-register-confirm'] ) );

        if( strlen( $username ) <= 5 ) {
            $error['user'] = 'Name muss mindestens 6 Buchstaben haben.';
            $valid = false;
        }
        if( preg_match ( '/^[_a-z]*$/i' , trim( $username ) ) == false ) {
            $error['user'] = 'Nur Buchstaben und _ sind erlaubt.';
            $valid = false;
        }
        if( strlen( $password ) != 6 ) {
            $error['pwd'] = 'Passwort muss genau 6 Zeichen haben'; //Bedingung siehe Arbeitsblatt
            $valid = false;
        }
        if( preg_match ( '/\d/' , $password ) == false ) {
            $error['pwd'] = 'Nur Zahlen sind erlaubt.';
            $valid = false;
        }
        if( $password != $passwordConfirm ) {
            $error['pwd-confirm'] = 'Passwörter stimmen nicht überein';
            $valid = false;
        }
        if( $this->userExists( $username ) == true ) {
            $error['user'] = 'Benutzer existiert bereits';
            $valid = false;
        }
        if( $valid == false ) {
            return $_POST['error'] = $error;
        } else {
            return false;
        }
    }

    /**
     * check if user and password match
     * @param $user
     * @param $pwd
     * @return bool
     */
    private function validateLoginData( $user, $pwd )
    {
        $content = $this->readFile( USER_FILE );
        foreach( $content as $line ) {
           if( $user == $line[0] ) {
                if( $pwd == $line[1] ) {
                    return $valid = true;
                }
            }
        }
        return $valid = false;
    }

    /**
     * checks if user already exists
     * @param $username
     * @return boolean
     */
    private function userExists( $username )
    {
        $content = $this->readFile( USER_FILE );
        foreach( $content as $user ) {
            if( $username == $user[0] ) {
                return true;
            }
        }
        return false;
    }

    /**
     * save user data to textfile
     * @param array $data( user, pwd, participated )
     * @return void
     */
    private function writeUser( $data )
    {
        $file = USER_FILE;
        if( $file != null && file_exists( $file ) ) {
            if( ( $handle = fopen( $file, "a" ) ) !== false ) {
                fputcsv( $handle, $data, ';' );
            }
        }
        fclose( $handle );
    }

    /**
     * get file contents
     *
     * @param $file
     * @return array
     */
    private function readFile( $file = null )
    {
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
     * save given questions to textfile
     * set user "hasParticpated" to true
     *
     * @return void
     */
    private function saveSurvey()
    {
        $file = ANSWER_FILE;
        $userfile = USER_FILE;
        $data = array();

        if( isset( $_POST['question'] ) ) {
            //save answers
            $data = $_POST;
            array_pop( $data ); //remove question at end
            if( $file != null && file_exists( $file ) ) {
                if( ( $handle = fopen( $file, "a" ) ) !== false ) {
                    fputcsv( $handle, $data, ';' );
                }
            }
            fclose( $handle );

            //set participated to true
            $user = $_SESSION[ 'username' ];
            $content = $this->readFile( USER_FILE );
            $line = 0;
            foreach( $content as $item ) {
                if( $user == $item[0] ) {
                    $item[2] = '1';
                    $temp = $item;
                    break;
                }
                $line++;
            }

            //hahaha performance is everything :)
            unset( $content[$line] );
            array_push( $content, $temp );
            if( ( $handle = fopen( $userfile, "w+" ) ) !== false ) {
                foreach( $content as $line ){
                    fputcsv( $handle, $line, ';' );
                }
            }
            fclose( $handle );
        }
        self::redirect( 'thankyou' );
    }

    /**
     * get all questions from textfile
     *
     * @return array
     */
    public function getQuestions()
    {
        $questions = self::readFile( QUESTION_FILE );
        unset( $questions[0] ); //remove first line
        return $questions;
    }

    /**
     * get current user
     * check if already taken the survey
     *
     * @return mixed
     */
    public function hasParticipated()
    {
        $user = $_SESSION[ 'username' ];
        $content = $this->readFile( USER_FILE );
        foreach( $content as $item ) {
            if( $user == $item[0] ) {
                return $item[2];
            }
        }
    }

    /**
     * encrypt n salt password
     *
     * @param string $pwd
     * @return string $pwd = encrypted password
     */
    private function encryptPassword( $pwd )
    {
        return hash( 'sha512', $pwd . $this->config[ 'salt' ] );
    }

    /**
     * if we want to encrypt their real names, too
     * but actually - I don't like to...
     *
     * @param string $user
     * @return string $user = encrypted
     */
    private function encryptUser( $user )
    {
        return hash( 'sha512', $user . $this->config[ 'salt' ] );
    }

    /**
     * redirect helper function
     *
     * @param string $page - where user should be redirected
     * @return string redirect location
     */
    private static function redirect( $page )
    {
        return header( "Location: ?page=$page" );
    }
}