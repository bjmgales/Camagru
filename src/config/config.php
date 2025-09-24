<?php

##################SQL#########################

    ### TABLES
    const USER_TABLE = 'users';
    const IMAGES_TABLE = 'images';
    const OVERLAYS_TABLE = 'overlays';
    const COMMENTS_TABLE = 'comments';
    const LIKES_TABLE = 'likes';

    ### COLS
    const ID = 'id';
    const USERNAME = 'username';
    const EMAIL = 'email';
    const PASSWORD_HASH = 'password_hash';
    const CREATED_AT = 'created_at';
    const TOKEN_HASH = 'token_hash';
    const TOKEN_CREATION_TIME = 'token_creation_time';
    const TOKEN_EXPIRES_AT = 'token_expires_at';
    const IS_VERIFIED = 'is_verified';
    const IS_DEFAULT = 'is_default';
    const USER_ID = 'user_id';
    const FILE_PATH = 'file_path';
    const IMAGE_ID = 'image_id';
    const CONTENT = 'content';


############# RESPONSE KEYS ##############

    ## BASIC
    const SUCCESS = 'success';

    const ERROR = 'error';
    const MESSAGE = 'message';

    ## SIGN UP
    const EMAIL_INVALID =  "EMAIL_INVALID";
    const USERNAME_INVALID =  "USERNAME_INVALID";
    const PASSWORD_INVALID = "PASSWORD_INVALID";
    const DUPLICATE_USER = "USER_ALREADY_EXIST";
    const TOKEN_SENT = "TOKEN_SENT";

    ## LOGIN
    const LOGIN_SUCCESS = "LOGIN_SUCCESS";
    const LOGIN_FAILURE = "LOGIN_FAILURE";
    const WRONG_PASSWORD = "WRONG_PASSWORD";

    ## USER VERIFICATION
    const EXPIRED_TOKEN = "EXPIRED_TOKEN";



################ ENV #####################

define('GMAIL_USER', getenv('GMAIL_USER'));
define('GMAIL_PASSWORD', getenv('GMAIL_PASSWORD'));
