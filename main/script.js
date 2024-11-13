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
