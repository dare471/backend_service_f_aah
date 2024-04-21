<?php

namespace App\Http\Controllers\client\send_sms;

use App\Http\Controllers\Controller;
use App\Models\ClientAuth; // Пример модели, убедитесь, что правильно указали путь
use Illuminate\Support\Facades\Http;

class SmsMessageController extends Controller
{
    public function sendVerificationCode(ClientAuth $client)
    {
        $verificationCode = rand(1000, 9999); // Генерация случайного кода
        $client->update([
            'sms_verification_code' => $verificationCode,
            'sms_verification_code_sent_at' => now()
        ]);

        // Вызов функции отправки SMS с передачей номера телефона и сформированного сообщения
        $message = "Код для авторизации : {$verificationCode}";
        $this->sendSmsApi($client->phone, $message);
    }

    private function sendSmsApi($phoneNumber, $message)
    {
        $login = 'Test'; // Укажите ваш логин
        $password = 'Testov'; // Укажите ваш пароль

        // Отправка запроса на API сервиса SMS
        $response = Http::post('https://smsc.kz/rest/send/', [
            'login' => $login,
            'psw' => $password,
            'phones' => $phoneNumber, // Номер телефона полученный из параметров
            'mes' => $message, // Сообщение сформированное в функции sendVerificationCode
        ]);

        // Ответ на вызов API
        return response()->json([
            'status' => $response->successful() ? 'success' : 'error',
            'data' => $response->json()
        ]);
    }
}
