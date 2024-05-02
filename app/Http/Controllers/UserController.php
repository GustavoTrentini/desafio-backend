<?php

namespace App\Http\Controllers;

use App\Dto\BaseOutput;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public $service;

    public function __construct(){
        $userRepository = new UserRepository(new User());
        $walletRepository = new WalletRepository(new Wallet());
        $this->service = new UserService($userRepository, $walletRepository);
    }

    public function register(UserRegisterRequest $request){
        $response = new BaseOutput(
            "Usuário cadastrado com sucesso!",
            $this->service->register($request)
        );

        return $response->render(200);
    }

    public function getLoggedUser(Request $request){
        $response = new BaseOutput(
            "Usuário logado",
            $request->user()
        );

        return $response->render(200);
    }
}
