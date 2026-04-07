<?php
// Файл: index.php

// === 1. ДИНАМИЧЕСКИЙ TITLE (ФИО и группа, номер и название работы) ===
$student_info = "Еремина Анастасия, 241-352";
$lab_info = "Лабораторная работа № А-1: Конвертация статического контента в динамический";
$title = $student_info . " — " . $lab_info;

// === 2. ДАННЫЕ ДЛЯ МЕНЮ (адрес, текст, класс) ===
// Адреса ссылок
$link1 = 'index.php';
$link2 = 'page2.php';
$link3 = 'page3.php';

// Тексты ссылок
$link_text1 = 'Главная';
$link_text2 = 'Статьи';
$link_text3 = 'Контакты';

// Флаги активности
$current_page1 = true;
$current_page2 = false;
$current_page3 = false;

// === 3. ДАННЫЕ ДЛЯ ФОТОГРАФИЙ (в зависимости от секунды) ===
// Устанавливаем часовой пояс для Москвы (UTC+3)
date_default_timezone_set('Europe/Moscow');
$s = date('s'); // текущая секунда

// Определяем имя файла для ПЕРВОГО фото
if ($s % 2 == 0) {
    $photo_name1 = 'foto1.jpg';
} else {
    $photo_name1 = 'foto2.jpg';
}
$photo_path1 = 'fotos/' . $photo_name1;

// Для ВТОРОГО фото используем противоположное условие
// Чтобы фото не были одинаковыми при четной/нечетной секунде
if ($s % 2 == 0) {
    $photo_name2 = 'foto2.jpg'; // Если четная - второе foto2
} else {
    $photo_name2 = 'foto1.jpg'; // Если нечетная - второе foto1
}
$photo_path2 = 'fotos/' . $photo_name2;

// === 4. ДАННЫЕ ДЛЯ ТАБЛИЦЫ ===
$first_row = '
    <tr style="background-color: #e6f3ff;">
        <td>Ячейка 1.1 (PHP)</td>
        <td>Ячейка 1.2 (PHP)</td>
        <td>Ячейка 1.3 (PHP)</td>
    </tr>';

$cell2_1 = 'Текст A (динамика)';
$cell2_2 = 'Текст B (динамика)';
$cell2_3 = 'Текст C (динамика)';

// === 5. ПОДВАЛ ===
$footer_text = "Сформировано " . date('d.m.Y') . " в " . date('H-i:s');
?>
<!DOCTYPE html>
<html lang="ru">
<head> 
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="logo">Динамический сайт</div>
    <nav>
        <a href="<?php echo $link1; ?>" <?php if($current_page1) echo 'class="active"'; ?>><?php echo $link_text1; ?></a>
        <a href="<?php echo $link2; ?>" <?php if($current_page2) echo 'class="active"'; ?>><?php echo $link_text2; ?></a>
        <a href="<?php echo $link3; ?>" <?php if($current_page3) echo 'class="active"'; ?>><?php echo $link_text3; ?></a>
    </nav>
</header>

<main>
    <h1>Добро пожаловать на главную страницу</h1>

    <section>
        <h2>Введение в динамический контент</h2>
        <p>Это пример страницы, созданной в рамках лабораторной работы. Здесь статический HTML-код замещен PHP-программой, которая формирует этот же код динамически. Основная задача PHP — динамически формировать HTML-код страницы. Программный код выступает в роли HTML-верстальщика, который верстает страницы непосредственно перед загрузкой.</p>
        <p>PHP — это скриптовый язык общего назначения, интенсивно применяемый для разработки веб-приложений. В данном задании мы заменяем статические элементы: заголовок страницы, меню, подвал, таблицы и даже изображения, которые меняются в зависимости от текущей секунды.</p>
    </section>

    <section>
        <h2>Пример таблицы (динамические строки)</h2>
        <table>
            <thead>
                <tr>
                    <th>Колонка 1</th>
                    <th>Колонка 2</th>
                    <th>Колонка 3</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $first_row; ?>
                <tr>
                    <td><?php echo $cell2_1; ?></td>
                    <td><?php echo $cell2_2; ?></td>
                    <td><?php echo $cell2_3; ?></td>
                </tr>
            </tbody>
        </table>
    </section>

    <section>
        <h2>Фотогалерея</h2>
        <p>Обе фотографии меняются в зависимости от четности секунды:</p>
        <ul>
            <li>При четной секунде: первое фото - foto1.jpg, второе - foto2.jpg</li>
            <li>При нечетной секунде: первое фото - foto2.jpg, второе - foto1.jpg</li>
        </ul>
        <div class="photo-gallery">
            <img src="<?php echo $photo_path1; ?>" alt="Динамическое фото 1" width="300">
            <img src="<?php echo $photo_path2; ?>" alt="Динамическое фото 2" width="300">
        </div>
    </section>
</main>

<footer>
    <?php echo $footer_text; ?>
</footer>

</body>
</html>