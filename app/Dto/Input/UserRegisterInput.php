<?php

namespace App\Dto\Input;

use App\Dto\BaseInput;

class UserRegisterInput extends BaseInput
{
    public string $name;
    public string $email;
    public string $password;
    public string $password_confirmation;
    public string $document;
    public int $type_user_id;
}
