<?php
require __DIR__ . '/vendor/autoload.php';
use Twilio\Rest\Client;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$accountSid = $_ENV['TWILIO_ACCOUNT_SID'];
$authToken = $_ENV['TWILIO_AUTH_TOKEN'];
$twilioNumber = $_ENV['TWILIO_NUMBER'];
$recipientNumber = $_ENV['RECIPIENT_NUMBER'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $from = htmlspecialchars($_POST['from'] ?? '');
    $fullName = htmlspecialchars($_POST['full__name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $destination = htmlspecialchars($_POST['destination'] ?? '');
    $deliveryType = htmlspecialchars($_POST['delivery__type'] ?? '');
    $telephone = htmlspecialchars($_POST['telephone'] ?? '');
    $cargoCode = htmlspecialchars($_POST['cargo_code'] ?? '');
    $comment = htmlspecialchars($_POST['comment'] ?? '');

    $client = new Client($accountSid, $authToken);

    $messageBody = "Новые данные формы:\n";
    $messageBody .= "Откуда: $from\n";
    $messageBody .= "ФИО: $fullName\n";
    $messageBody .= "Email: $email\n";
    $messageBody .= "Куда: $destination\n";
    $messageBody .= "Тип доставки: $deliveryType\n";
    $messageBody .= "Телефон: $telephone\n";
    $messageBody .= "Код груза: $cargoCode\n";
    $messageBody .= "Комментарий: $comment";

    try {
        $client->messages->create(
            $recipientNumber,
            [
                'from' => $twilioNumber,
                'body' => $messageBody
            ]
        );
        // Сообщение об успехе
        echo "<p style='color: green;'>Данные успешно отправлены на WhatsApp.</p>";
    } catch (Exception $e) {
        // Сообщение об ошибке
        echo "<p style='color: red;'>Ошибка при отправке данных: " . $e->getMessage() . "</p>";
    }
}
