function toggleMenu() {
    const menu = document.getElementById('dropdown-menu');
    menu.classList.toggle('active');

    // Добавляем обработчик события для закрытия меню при клике на любую ссылку внутри него
    const links = menu.querySelectorAll('.nav__link');
    links.forEach(link => {
        link.addEventListener('click', () => {
            menu.classList.remove('active'); // Закрываем меню
        });
    });
}

$(document).ready(function() {
    $('#form1').submit(function(e) {
        e.preventDefault(); // Предотвращаем стандартное поведение отправки формы
    
        // Получаем данные формы
        var formData = $(this).serialize();
    
        // Отправляем AJAX-запрос на сервер для первой формы
        $.ajax({
            type: 'POST',
            url: '/send_whatsapp.php',
            data: formData,
            success: function(response) {
                // Обработка успешного ответа от сервера
                alert('Данные успешно отправлены');
                document.getElementById('form1').reset(); // Очищаем форму
                document.getElementById('submitBtn1').disabled = true; // Отключаем кнопку отправки формы
                document.getElementById('form1').setAttribute('data-submitted', 'true'); // Устанавливаем атрибут, указывающий на отправку формы
            },
            error: function(xhr, status, error) {
                // Обработка ошибок при выполнении запроса
                console.error(error);
                alert('Произошла ошибка. Попробуйте еще раз позже');
            }
        });
    });
    
    
    $('#form2').submit(function(e) {
        e.preventDefault(); // Предотвращаем стандартное поведение отправки формы
    
        // Получаем данные формы
        var formData = $(this).serialize();
    
        // Отправляем AJAX-запрос на сервер для третьей формы
        $.ajax({
            type: 'POST',
            url: '/send_whatsapp.php',
            data: formData,
            success: function(response) {
                // Обработка успешного ответа от сервера
                alert('Данные успешно отправлены');
                document.getElementById('form2').reset(); // Очищаем форму
                document.getElementById('submitBtn2').disabled = true; // Отключаем кнопку отправки формы
                document.getElementById('form2').setAttribute('data-submitted', 'true'); // Устанавливаем атрибут, указывающий на отправку формы
            },
            error: function(xhr, status, error) {
                // Обработка ошибок при выполнении запроса
                console.error(error);
                alert('Произошла ошибка. Попробуйте еще раз позже');
            }
        });
    });
    
});