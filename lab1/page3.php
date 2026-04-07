<?php
// Файл: page3.php

// === 1. TITLE ===
$student_info = "Еремина Анастасия, 241-352";
$lab_info = "Лабораторная работа № А-1: Конвертация статического контента в динамический";
$title = $student_info . " — " . $lab_info;

// === 2. МЕНЮ ===
$link1 = 'index.php';
$link2 = 'page2.php';
$link3 = 'page3.php';

$link_text1 = 'Главная';
$link_text2 = 'Статьи';
$link_text3 = 'Контакты';

$current_page1 = false;
$current_page2 = false;
$current_page3 = true;

// === 3. ФОТО ===
date_default_timezone_set('Europe/Moscow');
$s = date('s');

// Первое фото
if ($s % 2 == 0) {
    $photo_name1 = 'foto1.jpg';
} else {
    $photo_name1 = 'foto2.jpg';
}
$photo_path1 = 'fotos/' . $photo_name1;

// Второе фото (противоположное первому)
if ($s % 2 == 0) {
    $photo_name2 = 'foto2.jpg';
} else {
    $photo_name2 = 'foto1.jpg';
}
$photo_path2 = 'fotos/' . $photo_name2;

// === 4. ТАБЛИЦА ===
$first_row = '
    <tr style="background-color: #f0f0f0;">
        <td>Контакт A</td>
        <td>Контакт B</td>
        <td>Контакт C</td>
    </tr>';
$cell2_1 = 'Телефон: 123-45-67';
$cell2_2 = 'Email: example@mail.ru';
$cell2_3 = 'Skype: Eremina';

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
    <h1>Контакты</h1>

    <section>
        <h2>Свяжитесь с нами</h2>
        <p>Это страница контактов. Здесь вы можете найти наши координаты. Как и на других страницах, подвал содержит актуальную дату и время формирования страницы, а фотографии меняются каждую секунду.</p>
        <p>Адрес: г. Москва, ул. Программная, д. 1. Время работы: круглосуточно.</p>
    </section>

    <section>
        <h2>Таблица контактов</h2>
        <table>
            <thead>
                <tr><th>Тип</th><th>Детали</th><th>Примечание</th></tr>
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
        <h2>Наше местоположение</h2>
        <div class="photo-gallery">
            <img src="<?php echo $photo_path1; ?>" alt="Динамическая карта" width="300">
            <img src="<?php echo $photo_path2; ?>" alt="Динамическое фото офиса" width="300">
        </div>
    </section>
</main>

<footer>
    <?php echo $footer_text; ?>
</footer>

</body>
</html>