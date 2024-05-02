<?php

namespace App\Services;

use App\Dto\Input\UserRegisterInput;
use App\Dto\Input\WalletInput;
use App\Exceptions\UserException;
use App\Http\Requests\UserRegisterRequest;
use App\Models\TypeUser;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        public UserRepository $userRepository,
        public WalletRepository $walletRepository
    ){}

    public function register(UserRegisterRequest $request, ): User{
        try{
            $userData = $request->all();
            $userData["password"] = Hash::make($request->input('password'));

            $userCreated = $this->userRepository->register(
                new UserRegisterInput($userData)
            );

            $userCreated->wallet = $this->walletRepository->newWallet(new WalletInput([
                'user_id' => $userCreated->id
            ]));

            return $userCreated;

        }catch(\Exception $e){
            if(isset($userCreated) && $userCreated){
                $userCreated->delete();
            }

            throw new UserException("Erro no cadastro de Usuário", $e->getMessage());
        }
    }

    public function autenticatedUserIsComum(): bool{
        $typeUserModel = new TypeUser();
        $typeUser = $typeUserModel->firstWhere('id', auth()->user()->type_user_id);

        return $typeUser->description == 'Comum';
    }
}
