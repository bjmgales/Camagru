<?php

require_once __DIR__ . '/../models/User.php';

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
        if (!$valid['ok']) {
            $user = null;
            return error_response(422, $valid['error']);
        }
        $this->_user->save();
        return success_response($this->_user);
    }

    ####################### PRIVATE #########################


    private function _validate_fields(): array
    {
        $passwordRegexp = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s])(?!.*\s).{8,72}$/';
        $usernameRegexp = '/^[A-Za-z0-9](?:[A-Za-z0-9_]{1,20}[A-Za-z0-9])$/';

        if (!filter_var($this->_user->get_mail(), FILTER_VALIDATE_EMAIL)) {
            return ["ok" => false, "error" => ""];
        } else if (!preg_match($usernameRegexp, $this->_user->get_username())) {
            return [
                "ok" => false,
                "error" =>
                "EMAIL_INVALID"
            ];
        } else if (!preg_match($passwordRegexp, $this->_user->get_password())) {
            return [
                "ok" => false,
                "error" =>
                "PASSWORD_INVALID"
            ];
        } else if ($this->_user->exists()) {
            return [
                "ok" => false,
                "error" =>
                "USER_ALREADY_EXIST"
            ];
        }

        return ["ok" => true];
    }
}
