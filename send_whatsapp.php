<?php
require __DIR__ . '/vendor/autoload.php'; // Путь к автозагрузчику Composer
use Dotenv\Dotenv;

// Загружаем переменные из .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Используем переменные окружения
$recipientEmail = $_ENV['RECIPIENT_EMAIL'];  // Email получателя
$telegramBotToken = $_ENV['TELEGRAM_BOT_TOKEN']; // Токен Telegram-бота
$telegramChatId = $_ENV['TELEGRAM_CHAT_ID'];  // Chat ID получателя в Telegram

// Проверяем, что форма отправлена
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $from = htmlspecialchars($_POST['from']);
    $fullName = htmlspecialchars($_POST['full__name']);
    $email = htmlspecialchars($_POST['email']);
    $destination = htmlspecialchars($_POST['destination']);
    $deliveryType = htmlspecialchars($_POST['delivery__type']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $cargoCode = htmlspecialchars($_POST['cargo_code']);
    $comment = htmlspecialchars($_POST['comment']);

    // Формируем сообщение
    $messageBody = "Новые данные формы:\n";
    $messageBody .= "Откуда: $from\n";
    $messageBody .= "ФИО: $fullName\n";
    $messageBody .= "Email: $email\n";
    $messageBody .= "Куда: $destination\n";
    $messageBody .= "Тип доставки: $deliveryType\n";
    $messageBody .= "Телефон: $telephone\n";
    $messageBody .= "Код груза: $cargoCode\n";
    $messageBody .= "Комментарий: $comment";

    // Отправка данных на почту
    $emailSubject = "Новые данные формы доставки";
    $emailHeaders = "From: $email";
    $emailSent = mail($recipientEmail, $emailSubject, $messageBody, $emailHeaders);

    // Отправка данных в Telegram
    $telegramUrl = "https://api.telegram.org/bot$telegramBotToken/sendMessage";
    $telegramData = [
        'chat_id' => $telegramChatId,
        'text' => $messageBody
    ];

    // Используем cURL для отправки запроса в Telegram API
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $telegramUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($telegramData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $telegramResponse = curl_exec($ch);
    curl_close($ch);

    // Проверка успешности отправки и вывод сообщения
    if ($emailSent && $telegramResponse) {
        echo json_encode(["message" => "Данные успешно отправлены на почту и в Telegram"]);
    } else {
        echo json_encode(["message" => "Ошибка при отправке данных"]);
    }
}
?>
