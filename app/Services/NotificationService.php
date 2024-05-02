<?php

namespace App\Services;

use App\Dto\Output\NotificationServiceOutput;
use App\Exceptions\NotificationException;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class NotificationService
{
    public function sendEmail(User $payee): NotificationServiceOutput{
        $response = Http::post(env("NOTIFICATION_SERVICE_URL"), [
            'email' => $payee->email
        ]);

        throw_if(!$response->successful(), new NotificationException(
            "Serviço de E-mail indisponível!", null, 503
        ));

        $response = new NotificationServiceOutput($response->json());

        throw_if(!isset($response->message) || $response->message != "Autorizado",
            new NotificationException("Erro ao enviar E-mail!")
        );

        return $response;
    }

    public function sendSms(User $payee): NotificationServiceOutput{
        $response = Http::post(env("NOTIFICATION_SERVICE_URL"), [
            'phone' => $payee->phone
        ]);

        throw_if(!$response->successful(), new NotificationException(
            "Serviço de SMS indisponível!", null, 503
        ));

        $response = new NotificationServiceOutput($response->json());

        throw_if(!$response->message,
            new NotificationException("Erro ao enviar SMS!")
        );

        return $response;
    }
}
