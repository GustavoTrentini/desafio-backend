<?php

namespace App\Repositories;

use App\Dto\Input\UserRegisterInput;
use App\Models\User;

class UserRepository
{
    public function __construct(public User $userModel){}

    public function register(UserRegisterInput $userInput): User{
        return $this->userModel->create($userInput->toArray());
    }
}
