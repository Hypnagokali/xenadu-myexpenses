<?php
namespace Model;

/**
 * User
 * User who is logged in / the authenticated user
 * User who is a friend of the authenticated user
 * and then there are Users
 */
class User implements ModelInterface
{

    private $user_id = -1;
    private $user_name = '';
    private $user_surname = '';
    private $user_nickname = '';
    private $user_email = '';
    private $user_hashed_password = '';
    private $user_rank = '';
    private $user_ip  = '';

    public function __construct($uid, $unickname, $uemail, $hashed_password, $uname = '-', $usurname = '-')
    {
        $this->user_id = $uid;
        $this->user_nickname = $unickname;
        $this->user_email = $uemail;
        $this->user_hashed_password = $hashed_password;
        $this->user_name = $uname;
        $this->user_surname = $usurname;
    }

    
    /**
     * getId
     *
     * @return void
     */
    public function getId()
    {
        return $this->user_id;
    }
    
    /**
     * setId
     *
     * @param  mixed $uid
     * @return void
     */
    public function setId($uid = null)
    {
        if (empty($uid)) {
            return false;
        }
        $this->user_id = $uid;
    }
    
    /**
     * getNickName
     *
     * @return void
     */
    public function getNickName()
    {
        return $this->user_nickname;
    }
    
    /**
     * setNickName
     *
     * @param  mixed $unickname
     * @return void
     */
    public function setNickName($unickname)
    {
        if (empty($unickname)) {
            return false;
        }
        $this->user_nickname = $unickname;
    }
    
    /**
     * getSurname
     *
     * @return void
     */
    public function getSurname()
    {
        return $this->user_surname;
    }
    
    /**
     * setSurname
     *
     * @param  mixed $usurname
     * @return void
     */
    public function setSurname($usurname = '')
    {
        if (empty($usurname)) {
            return false;
        }
        $this->user_surname = $usurname;
    }
    
    /**
     * getName
     *
     * @return void
     */
    public function getName()
    {
        return $this->user_name;
    }
    

    /**
     * setName
     *
     * @param  mixed $uname
     * @return void
     */
    public function setName($uname = '')
    {
        if (empty($uname)) {
            return false;
        }
        $this->user_name = $uname;
    }
    
    /**
     * getHashedPassword
     *
     * @return void
     */
    public function getHashedPassword()
    {
        return $this->user_hashed_password;
    }
    
    /**
     * setHashedPassword
     *
     * @param  mixed $hashed_password
     * @return void
     */
    public function setHashedPassword($hashed_password = '')
    {
        if (empty($hashed_password)) {
            return false;
        }
        $this->user_hashed_password = $hashed_password;
    }
    
    /**
     * getEmail
     *
     * @return void
     */
    public function getEmail()
    {
        return $this->user_email;
    }
    
    /**
     * setEmail
     *
     * @param  mixed $uemail
     * @return void
     */
    public function setEmail($uemail = '')
    {
        if (empty($uemail)) {
            return false;
        }
        $this->user_email = $uemail;
    }
}
