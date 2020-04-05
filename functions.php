<?php

class func
{
    public static function checkLoginState($dbh)
    {
        if (!isset($_SESSION/*['id']) || !isset($_COOKIE['PHPSESSID']*/)) {
            session_start();
        }
        if (isset($_COOKIE['user_id']) && isset($_COOKIE['token']) && isset($_COOKIE['serial'])) {
            $query = "SELECT * FROM sessions WHERE session_userid = :userid AND session_token = :token AND session_serial = :serial;";
            $userid = $_COOKIE['user_id'];
            $token = $_COOKIE['token'];
            $serial = $_COOKIE['serial'];

            $stmt = $dbh->prepare($query);
            $stmt->execute(array(':userid' => $userid,
                ':token' => $token,
                ':serial' => $serial));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row['session_userid'] > 0) {
                if (
                    $row['session_userid'] == $_COOKIE['user_id'] &&
                    $row['session_token'] == $_COOKIE['token'] &&
                    $row['session_serial'] == $_COOKIE['serial']
                ) {
                    if (
                        $row['session_userid'] == $_COOKIE['user_id'] &&
                        $row['session_token'] == $_COOKIE['token'] &&
                        $row['session_serial'] == $_COOKIE['serial']
                    ) {
                        return true;
                    } else {
                        func::createSession($_COOKIE['username'], $_COOKIE['user_id'], $_COOKIE['token'], $_COOKIE['serial']);
                        return true;
                    }

                }

            }

        }
    }


    public static function createRecord($dbh, $user_username, $user_id)
    {
        $query = 'INSERT INTO `sessions`(`session_userid`,`session_token`, `session_serial`, `session_date`) 
                VALUES (:user_id,:token , :serial , "19/08/2018") ';

        $stmt = $dbh->prepare("DELETE FROM sessions where session_userid= :session_userid;")->execute(
            array(':session_userid' => $user_id)
        );


        $token = func::createString(30);
        $serial = func::createString(30);

        func::createCookie($user_username, $user_id, $token, $serial);
        func::createSession($user_username, $user_id, $token, $serial);


        //$stmt->execute(array());
        $stmt = $dbh->prepare($query);
        $stmt->execute(array(':user_id' => $user_id, ':token' => $token, ':serial' => $serial));


    }

    public static function createCookie($user_username, $user_id, $token, $serial)
    {
        setcookie('user_id', $user_id, time() + (86400) * 30, "/");
        setcookie('users_username', $user_username, time() + (86400) * 30, "/");
        setcookie('token', $token, time() + (86400) * 30, "/");
        setcookie('serial', $serial, time() + (86400) * 30, "/");
    }
    public static function deleteCookie()
    {
        setcookie('user_id', '', time() - 1, "/");
        setcookie('users_username', '', time()  - 1, "/");
        setcookie('token', '', time()  - 1, "/");
        setcookie('serial', '', time()  - 1,"/");
        session_destroy();
    }

    public static function createSession($user_username, $user_id, $token, $serial)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['user_id'] = $user_id;
        $_SESSION['token'] = $token;
        $_SESSION['serial'] = $serial;
        $_SESSION['user_username'] = $user_username;

    }


    public static function createString($len)
    {
        $string = "1qay2wsx3edc4rfv5tgb6zhn7ujm8ik9olpAQWSXEDCVFRTGBNHYZUJMKILOP";

        return substr(str_shuffle($string), 0 ,30);
    }
}