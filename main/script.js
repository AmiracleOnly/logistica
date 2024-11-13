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
    // Общая функция для отправки формы
    function handleFormSubmit(formId, submitBtnId) {
        $(formId).submit(function(e) {
            e.preventDefault(); // Предотвращаем стандартное поведение отправки формы

            // Получаем данные формы
            var formData = $(this).serialize();

            // Отправляем AJAX-запрос на сервер
            $.ajax({
                type: 'POST',
                url: '/send_whatsapp.php',
                data: formData,
                success: function(response) {
                    // Обработка успешного ответа от сервера
                    alert('Данные успешно отправлены');
                    $(formId)[0].reset(); // Очищаем форму
                    $(submitBtnId).prop('disabled', true); // Отключаем кнопку отправки формы
                    $(formId).attr('data-submitted', 'true'); // Устанавливаем атрибут, указывающий на отправку формы
                },
                error: function(xhr, status, error) {
                    // Обработка ошибок при выполнении запроса
                    console.error(error);
                    alert('Произошла ошибка. Попробуйте еще раз позже');
                }
            });
        });
    }

    // Применяем общую функцию для обеих форм
    handleFormSubmit('#form1', '#submitBtn1');
    handleFormSubmit('#form2', '#submitBtn2');
});
