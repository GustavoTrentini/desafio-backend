<?php

namespace Tests\Unit\Services;

use App\Dto\Output\NotificationServiceOutput;
use App\Exceptions\NotificationException;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class NotificationServiceTest extends TestCase
{
    public function testSendEmailSuccess()
    {
        $user = new User(['email' => 'example@example.com']);

        Http::fake([
            '*' => Http::response(['message' => true], 200)
        ]);

        $service = new NotificationService();

        $result = $service->sendEmail($user);

        $this->assertInstanceOf(NotificationServiceOutput::class, $result);
        $this->assertEquals('Autorizado', $result->message);
    }

    public function testSendEmailThrowsNotificationException()
    {
        $user = new User(['email' => 'example@example.com']);

        Http::fake([
            '*' => Http::response([], 500)
        ]);

        $service = new NotificationService();

        $this->expectException(NotificationException::class);
        $this->expectExceptionMessage('Serviço de E-mail indisponível!');

        $service->sendEmail($user);
    }

    public function testSendSmsSuccess()
    {
        $user = new User(['phone' => '1234567890']);

        Http::fake([
            '*' => Http::response(['message' => 'Autorizado'], 200)
        ]);

        $service = new NotificationService();

        $result = $service->sendSms($user);

        $this->assertInstanceOf(NotificationServiceOutput::class, $result);
        $this->assertEquals('Autorizado', $result->message);
    }

    public function testSendSmsThrowsNotificationException()
    {
        $user = new User(['phone' => '1234567890']);

        Http::fake([
            '*' => Http::response([], 500)
        ]);

        $service = new NotificationService();

        $this->expectException(NotificationException::class);
        $this->expectExceptionMessage('Serviço de SMS indisponível!');

        $service->sendSms($user);
    }
}
