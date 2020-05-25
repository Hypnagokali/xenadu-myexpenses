<?php
namespace Db;

use Auth\AuthToken;
use DateTime;
use PDO;
use PDOException;
use Model\User;

class MySQLConnection
{

    private $connectionString = '';
    private $dbConnection = null;

    public function __construct($db_array = [])
    {
        if (!isset($db_array['db_host']) ||
            !isset($db_array['db_name']) ||
            !isset($db_array['db_user']) ||
            !isset($db_array['db_password'])) {
                return false;
        }
        $dbhost = $db_array['db_host'];
        $dbname = $db_array['db_name'];
        $user = $db_array['db_user'];
        $password = $db_array['db_password'];
        $this->connectionString = "mysql:host=$dbhost;dbname=$dbname;charset=utf8mb4";
        
        try {
            $this->dbConnection = new PDO($this->connectionString, $user, $password);
        } catch (PDOException $e) {
            echo $e->getMessage() . '<br>';
            die();
        }
    }

    public function fetchFirst(string $sql, array $data)
    {
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute($data);
        $result = $stmt->fetch();
        return $result;
    }
    public function fetchAll(string $sql, array $data)
    {
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute($data);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function query(string $sql, array $values)
    {
        try {
            $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $this->dbConnection->prepare($sql);
            $result = $stmt->execute($values);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
        return $result;
    }

    public function getLastInsertedId()
    {
        return $this->dbConnection->lastInsertId();
    }



    public function getAllExpensesFromUser($uid = -1)
    {
        $stmt = $this->dbConnection->prepare('SELECT * FROM expenses WHERE user_id = ?');
        $stmt->execute([$uid]);
        $result = $stmt->fetchAll();
        return $result;
    }


    private function createUser($result)
    {
        $user = new User(
            $result['id'],
            $result['nickname'],
            $result['email'],
            $result['password'],
            $result['name'],
            $result['surname']
        );
        return $user;
    }

    public function getUserByEmail($email)
    {
        $stmt = $this->dbConnection->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $result = $stmt->fetch();

        $user = $this->createUser($result);

        return $user;
    }
    
    public function getUserById($id)
    {
        $sqlString = 'SELECT * FROM users WHERE id = ?';
        $stmt = $this->dbConnection->prepare($sqlString);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $this->createUser($result);
    }

    /**
     * addUserAuthToken
     *
     * @param  Mode\User $user
     * @param  string $token
     * @param  DateTime $expires
     * @return Bool
     */
    public function addUserAuthToken(User $user, string $token, DateTime $expires)
    {
        $inputArray = [$user->getId(), $token, $expires->format('Y-m-d H:i:s')];
        $sqlString = 'INSERT INTO auth_tokens (user_id, token, expires) VALUES(?, ?, ?)';
        $stmt = $this->dbConnection->prepare($sqlString);
        $resultBool = $stmt->execute($inputArray);
        return $resultBool;
    }

    public function updateAuthToken(AuthToken $token)
    {
        $sqlString = 'UPDATE auth_tokens SET expires = ? WHERE id = ?';
        $stmt = $this->dbConnection->prepare($sqlString);
        $stmt->execute([
            $token->expires,
            $token->id
        ]);
    }

    public function getAuthToken(string $token)
    {
        $sqlString = 'SELECT * FROM auth_tokens WHERE token = ?';
        $stmt = $this->dbConnection->prepare($sqlString);
        $stmt->execute([$token]);
        
        if (!$stmt->rowCount() > 0) {
            return false;
        }

        $result = $stmt->fetch();
        $authToken = new AuthToken(
            $result['id'],
            $result['user_id'],
            $result['token'],
            $result['expires']
        );
        return $authToken;
    }

    public function getUserByToken(string $token)
    {
        $sqlString = 'SELECT * FROM auth_tokens WHERE token = ?';
        $stmt = $this->dbConnection->prepare($sqlString);
        $stmt->execute([$token]);
        $result = $stmt->fetch();
        $uid = $result['user_id'];
        $user = $this->getUserById($uid);
        return $user;
    }

    public function deleteAuthToken(User $user)
    {
        $sqlString = 'DELETE FROM auth_tokens WHERE user_id = ?';
        $stmt = $this->dbConnection->prepare($sqlString);
        $stmt->execute([$user->getId()]);
    }
}
