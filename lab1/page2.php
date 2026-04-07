<?php
// Файл: page2.php

// === 1. ДИНАМИЧЕСКИЙ TITLE ===
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
$current_page2 = true;
$current_page3 = false;

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
    <tr style="background-color: #fff3e0;">
        <td>Строка 2.1 (PHP)</td>
        <td>Строка 2.2 (PHP)</td>
        <td>Строка 2.3 (PHP)</td>
    </tr>';
$cell2_1 = 'Данные X';
$cell2_2 = 'Данные Y';
$cell2_3 = 'Данные Z';

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
    <h1>Статьи и новости</h1>

    <section>
        <h2>Последние публикации</h2>
        <p>Это вторая страница сайта. Здесь мы размещаем информационные материалы. Контент страницы также динамически формируется с помощью PHP. Меню выделяет текущий раздел "Статьи" с помощью CSS-класса "active".</p>
        <p>Объем текста на этой странице также превышает 1 килобайт, что соответствует условиям лабораторной работы.</p>
    </section>

    <section>
        <h2>Таблица данных</h2>
        <table>
            <thead>
                <tr><th>Параметр</th><th>Значение</th><th>Ед. изм.</th></tr>
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
        <h2>Иллюстрации</h2>
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