<?php
namespace Auth;

use DateTime;
use Db\MySQLConnection;
use Model\User as User;

class Auth
{

    // private static $instance = null;
    const USER_COOKIE_NAME = 'user';
    const USER_CREDENTIALS_EXPIRES = 60 * 60 * 24 * 3;


    protected function __construct()
    {
    }

    private static function generateToken()
    {
        $length = 20;
        return bin2hex(random_bytes($length));
    }

    private static function getUserToken()
    {
        if (empty($_SESSION[Auth::USER_COOKIE_NAME])) {
            return false;
        }
        return $_SESSION[Auth::USER_COOKIE_NAME];
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
        if (isset($_COOKIE[Auth::USER_COOKIE_NAME])) {
            return true;
        }
        return false;
    }

    private static function setSession(User $user)
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
            $user = new User(
                $_SESSION['user']['id'],
                $_SESSION['user']['nickname'],
                $_SESSION['user']['email'],
                $_SESSION['user']['hashedpassword'],
                $_SESSION['user']['name'],
                $_SESSION['user']['surname']
            );
            return $user;
        } elseif (!empty($_COOKIE[Auth::USER_COOKIE_NAME])) {
            $config = app('db');
            $conn = new MySQLConnection($config);
            $authToken = $conn->getAuthToken($_COOKIE[Auth::USER_COOKIE_NAME]);
            if ($authToken) {
                //User is logged in
                //check if token is expired
                if ($authToken->isExpired()) {
                    self::destroyAll();
                } else {
                    //refresh token
                    $authToken->refresh();
                    $conn->updateAuthToken($authToken);
                    //return logged in user
                    $user = $conn->getUserByToken($authToken->token);
                    return $user;
                }
            }
            self::destroyAll();
            return false;
        }
    }

    private static function destroyAll()
    {
        unset($_SESSION['user']);
        unset($_COOKIE[Auth::USER_COOKIE_NAME]);
        setcookie(Auth::USER_COOKIE_NAME, '', time() - 3600, '/');
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');
    }

    private static function createCredentials(MySQLConnection $conn, User $user)
    {
        //set token
        $uToken = self::generateToken();
        self::setSession($user);
        //save token in cookie
        $expires = time() + Auth::USER_CREDENTIALS_EXPIRES;
        $dateTime = new DateTime();
        $expiresDateTime = $dateTime->setTimestamp($expires);
        setcookie(Auth::USER_COOKIE_NAME, $uToken, $expires, '/');
        //reference token to user-id and write to db
        $conn->addUserAuthToken($user, $uToken, $expiresDateTime);
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
        self::createCredentials($conn, $user);
        //write token to DB
        return true;
    }

    public static function auth()
    {
        if (self::isUserSessionSet()) {
            return true;
        } elseif (self::isUserCookieSet()) {
            //get User from Database and set SESSION!
            $user = self::getUser();
            //phpcs:disable
            if (!$user) return false;
            //phpcs:enable
            self::setSession($user);
            return true;
        } else {
            return false;
        }
    }

    public static function logout()
    {
        $dbConfig = app('db');
        $conn = new MySQLConnection($dbConfig);
        $user = self::getUser();
        $conn->deleteAuthToken($user);
        self::destroyAll();
    }
}