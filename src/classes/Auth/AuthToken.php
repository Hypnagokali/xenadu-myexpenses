<?php
namespace Auth;

use DateTime;
use Auth\Auth;

class AuthToken
{
    public $id;
    public $user_id;
    public $token;
    public $expires;

    public function __construct(int $id, int $user_id, string $token, string $expires)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->token = $token;
        $this->expires = $expires;
    }

    public function isExpired()
    {
        $dt = new DateTime('now');
        $expires = new DateTime($this->expires);
        if ($dt < $expires) {
            return false;
        }
        return true;
    }

    public function refresh()
    {
        $expires = time() + Auth::USER_CREDENTIALS_EXPIRES;
        $this->expires = $expires;
    }
}
