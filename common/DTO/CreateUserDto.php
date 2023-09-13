<?php

namespace common\DTO;

class CreateUserDto
{
    public string|null $username;
    public string|null $password_hash;
    public string|null $auth_key;
    public string|null $email;
    public int|null $phone_number;
    public int $user_id;
}