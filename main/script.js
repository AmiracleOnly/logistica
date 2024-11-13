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

jQuery(document).ready(function(){
	jQuery("form").submit(function() { // Событие отправки с формы
		var form_data = jQuery(this).serialize(); // Собираем данные из полей
		jQuery.ajax({
			type: "POST", // Метод отправки
			url: "send_whatsapp.php", // Путь к PHP обработчику sendform.php
			data: form_data,
			success: swal({
				title: "Спасибо за заявку!",
                type: "success",
                showConfirmButton: false,
                timer: 2000
            })
        });
        $(this).find('input, textarea').prop('disabled', true);
        event.preventDefault();
    });
});