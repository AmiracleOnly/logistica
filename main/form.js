$(document).ready(function() {
    $('#form1').submit(function(e) {
        e.preventDefault(); // Предотвращаем перезагрузку страницы

        // Получаем данные формы
        var formData = $(this).serialize();

        // Отправляем AJAX-запрос на сервер
        $.ajax({
            type: 'POST',
            url: '/send_whatsapp.php', // Укажите путь к вашему PHP-скрипту
            data: formData,
            dataType: 'json', // Ожидаем JSON-ответ от сервера
            success: function(response) {
                if (response.message) {
                    alert(response.message); // Выводим сообщение об успешной отправке
                    $('#form1')[0].reset(); // Очищаем форму
                    $('#submitBtn1').prop('disabled', true); // Делаем кнопку неактивной
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Произошла ошибка при отправке данных. Попробуйте еще раз.');
            }
        });
    });
});
