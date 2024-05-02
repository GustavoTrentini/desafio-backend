<?php

namespace App\Http\Middleware;

use App\Dto\BaseOutput;
use App\Models\User;
use App\Models\Wallet;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use App\Services\UserService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class TransferMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userRepository = new UserRepository(new User());
        $walletRepository = new WalletRepository(new Wallet());
        $userService = new UserService($userRepository, $walletRepository);

        if (!$userService->autenticatedUserIsComum()){
            $response = new BaseOutput(
                "Lojistas não podem realizar transferências!", null, 401
            );

            return $response->render(200);
        }

        return $next($request);
    }
}
