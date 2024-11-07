<?php
require __DIR__ . '/vendor/autoload.php';
use Twilio\Rest\Client;

// Загрузить переменные из .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Использовать переменные окружения
$accountSid = $_ENV['TWILIO_ACCOUNT_SID'];
$authToken = $_ENV['TWILIO_AUTH_TOKEN'];
$twilioNumber = $_ENV['TWILIO_NUMBER'];
$recipientNumber = $_ENV['RECIPIENT_NUMBER'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $client = new Client($accountSid, $authToken);

    try {
        $client->messages->create(
            $recipientNumber,
            [
                'from' => $twilioNumber,
                'body' => "Новые данные формы:\nИмя: $name\nEmail: $email\nСообщение: $message"
            ]
        );

        echo 'Данные успешно отправлены на WhatsApp';
    } catch (Exception $e) {
        echo 'Ошибка при отправке данных: ' . $e->getMessage();
    }
}
