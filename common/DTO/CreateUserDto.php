<?php

namespace common\DTO;

class CreateUserDto
{
    public string $username;
    public string $password_hash;
    public string $auth_key;
    public string $email;
    public int $phone_number;

}