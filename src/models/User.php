<?php

require_once __DIR__ . "/../bootstrap.php";
require_once __DIR__ . '/../mailing/mail.php';

class User
{
    private ?string $_username;
    private string $_email;
    private string $_password;

    public function __construct(string $email, string $password, ?string $username = null,)
    {
        $this->_username = $username;
        $this->_email    = $email;
        $this->_password = $password;
    }

    public function save()
    {
        try {
            sql_insert(USER_TABLE, [USERNAME => $this->_username, EMAIL => $this->_email, PASSWORD_HASH => password_hash($this->_password, PASSWORD_BCRYPT)]);

            $token_hash = send_verification_email($this->_username, $this->_email);
            $now = date('Y-m-d H:i:s', time());
            $expires_at = date('Y-m-d H:i:s', time() + 30 * 60);
            sql_update(USER_TABLE, [TOKEN_HASH => $token_hash, TOKEN_CREATION_TIME => $now, TOKEN_EXPIRES_AT => $expires_at], EMAIL, $this->_email);
        } catch (Error $err) {
            throw new Error($err);
        }
    }

    public function retrieve()
    {
        try {
            $result = sql_select(USER_TABLE, [EMAIL => $this->_email]);
            return $result;
        } catch (Error $e) {
            return $e;
        }
    }
    public function exists()
    {
        return sql_exists(USER_TABLE, [USERNAME => $this->_username, EMAIL => $this->_email]);
    }

    public function get_mail()
    {
        return $this->_email;
    }

    public function get_username()
    {
        return $this->_username;
    }

    public function get_password()
    {
        return $this->_password;
    }
}
