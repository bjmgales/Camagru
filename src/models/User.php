<?php

require_once __DIR__ . "/../db.php";
require_once __DIR__ . "/../utils/sql_queries.php";
require_once __DIR__ . '/../utils/mail.php';

class User
{
    private string $_username;
    private string $_email;
    private string $_password;

    public function __construct(string $username, string $email, string $password)
    {
        $this->_username = $username;
        $this->_email    = $email;
        $this->_password = $password;
    }

    public function save()
    {
        try {
            sql_insert("users", ['username' => $this->_username, 'email' => $this->_email, 'password_hash' => password_hash($this->_password, PASSWORD_BCRYPT)]);
            send_verification_email($this->_username, $this->_email);
        } catch (Error $err) {
            throw new Error($err);
        }
    }

    public function exists()
    {
        return sql_exists("users", ['username' => $this->_username, 'email' => $this->_email]);
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
