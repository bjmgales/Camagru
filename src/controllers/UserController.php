<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../bootstrap.php';

class UserController
{
    private User $_user;

    public function __construct(User $user)
    {
        $this->_user = $user;
    }
    ####################### PUBLIC #########################

    public function register()
    {
        $valid = $this->_validate_fields();
        if (!$valid[SUCCESS]) {
            $user = null;
            return error_response(422, $valid[ERROR]);
        }
        $this->_user->save();
        success_response([SUCCESS => true, MESSAGE => TOKEN_SENT]);
    }

    public function retrieve()
    {
        try {
            $user_data = $this->_user->retrieve();
            if (!$user_data) {
                throw new Error();
            } else if (!password_verify($this->_user->get_password(), $user_data[0][PASSWORD_HASH])) {
                error_response(500, WRONG_PASSWORD);
                exit();
            }
            $_SESSION[EMAIL] = $user_data[0][EMAIL];
            $_SESSION[USERNAME] = $user_data[0][USERNAME];
            success_response([SUCCESS => true]);
            exit;
        } catch (Error) {
            error_response(404, LOGIN_FAILURE);
            exit;
        }
    }
    ####################### PRIVATE #########################


    private function _validate_fields(): array
    {
        $passwordRegexp = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s])(?!.*\s).{8,72}$/';
        $usernameRegexp = '/^[A-Za-z0-9](?:[A-Za-z0-9_]{1,20}[A-Za-z0-9])$/';

        if (!filter_var($this->_user->get_mail(), FILTER_VALIDATE_EMAIL)) {
            return [SUCCESS => false, ERROR => EMAIL_INVALID];
        } else if (!preg_match($usernameRegexp, $this->_user->get_username())) {
            return [
                SUCCESS => false,
                ERROR =>
                USERNAME_INVALID
            ];
        } else if (!preg_match($passwordRegexp, $this->_user->get_password())) {
            return [
                SUCCESS => false,
                ERROR =>
                PASSWORD_INVALID
            ];
        } else if ($this->_user->exists()) {
            return [
                SUCCESS => false,
                ERROR =>
                DUPLICATE_USER
            ];
        }

        return [SUCCESS => true];
    }
}
