<?php
namespace Auth;

use DateTime;
use Db\MySQLConnection;
use Model\User as UserModel;

class User
{

    // private static $instance = null;

    private static $uid = null;
    const USER_COOKIE_NAME = 'myexpenses.user';
    const USER_CREDENTIALS_EXPIRES = 60 * 60 * 24 * 3;


    protected function __construct()
    {
    }

    // public static function getInstance()
    // {
    //     if (self::$instance === null) {
    //         self::$instance = new User();
    //     }
    //     return self::$instance;
    // }


    private static function generateToken()
    {
        $length = 20;
        return bin2hex(random_bytes($length));
    }

    private static function getUserToken()
    {
        if (empty($_SESSION[User::USER_COOKIE_NAME])) {
            return false;
        }
        return $_SESSION[User::USER_COOKIE_NAME];
    }

    private static function isUserSessionSet()
    {
        if (!empty($_SESSION['user'])) {
            return true;
        }
        return false;
    }

    private static function isUserCookieSet()
    {
        if (!empty($_COOKIE[User::USER_COOKIE_NAME])) {
            return true;
        }
        return false;
    }

    private static function setSession(UserModel $user)
    {
        $_SESSION['user']['id'] = $user->getId();
        $_SESSION['user']['nickname'] = $user->getNickName();
        $_SESSION['user']['email'] = $user->getEmail();
        $_SESSION['user']['hashedpassword'] = $user->getHashedPassword();
        $_SESSION['user']['name'] = $user->getName();
        $_SESSION['user']['surname'] = $user->getSurname();
    }

    public static function getUser()
    {
        if (!empty($_SESSION['user'])) {
            $user = new UserModel(
                $_SESSION['user']['id'],
                $_SESSION['user']['nickname'],
                $_SESSION['user']['email'],
                $_SESSION['user']['hashedpassword'],
                $_SESSION['user']['name'],
                $_SESSION['user']['surname']
            );
            return $user;
        }
    }

    private static function createCredentials(MySQLConnection $conn, UserModel $user)
    {
        //set token
        $uToken = self::generateToken();
        $_SESSION['uid'] = $uToken;
        //save token in cookie
        $expires = time() + User::USER_CREDENTIALS_EXPIRES;
        $dateTime = new DateTime();
        $expiresDateTime = $dateTime->setTimestamp($expires);
        setcookie(User::USER_COOKIE_NAME, $uToken, $expires);
        //reference token to user-id and write to db
        $result = $conn->addUserAuthToken($user, $uToken, $expiresDateTime);
        
    }

    public static function login($email, $password)
    {
        $dbConfig = app('db');
        $conn = new MySQLConnection($dbConfig);
        /* get email and password from db */
        $user = $conn->getUserByEmail($email);
        $verify = password_verify($password, $user->getHashedPassword());
        //phpcs:disable
        if (!$verify) return false;
        //phpcs:enable
        if (!self::createCredentials($conn, $user)) {
            echo "DB Fehler! Konnte Credentials nicht anlegen.";
        } else {
            echo "Alle hat funktioniert";
        }
        exit();
        //write token to DB
    }

    public static function auth()
    {
        if (self::isUserSessionSet()) {
            return true;
        } elseif (self::isUserCookieSet()) {
            //get User from Database and set SESSION!
            return true;
        } else {
            return false;
        }
    } 
}