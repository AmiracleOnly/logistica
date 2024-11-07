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
    // Получение данных из формы
    $from = htmlspecialchars($_POST['from']);
    $fullName = htmlspecialchars($_POST['full__name']);
    $email = htmlspecialchars($_POST['email']);
    $destination = htmlspecialchars($_POST['destination']);
    $deliveryType = htmlspecialchars($_POST['delivery__type']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $cargoCode = htmlspecialchars($_POST['cargo_code']);
    $comment = htmlspecialchars($_POST['comment']);

    // Инициализация клиента Twilio
    $client = new Client($accountSid, $authToken);

    // Формирование сообщения
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
        // Отправка сообщения через Twilio
        $client->messages->create(
            $recipientNumber,
            [
                'from' => $twilioNumber,
                'body' => $messageBody
            ]
        );

        echo 'Данные успешно отправлены на WhatsApp';
    } catch (Exception $e) {
        echo 'Ошибка при отправке данных: ' . $e->getMessage();
    }
}
?>
