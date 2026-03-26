<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Таблица умножения (ЛР5)</title>
    <!-- Подключение внешнего файла стилей -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="page-wrapper">

    <?php

    // Функция возвращает число как ссылку (если число <= 9)
    // Важно: функция возвращает значение (return), а не выводит (echo), 
    // чтобы можно было использовать её внутри других echo.
    function outNumAsLink($x) {
        if ($x <= 9) {
            // Ссылки сбрасывают тип верстки (параметр html_type не передаем)
            return '<a href="?content=' . $x . '" class="num_link">' . $x . '</a>';
        } else {
            return $x;
        }
    }

    // Функция выводит один столбец таблицы умножения
    function outRow($n) { //заполнение
        for ($i = 2; $i <= 9; $i++) {
            // Формируем строку 
            echo outNumAsLink($n) . ' &times; ' . outNumAsLink($i) . ' = ' . outNumAsLink($i * $n) . '<br>';
        }
    }

    // Функция выводит таблицу в ТАБЛИЧНОЙ форме (<table>)
    function outTableForm() {
        echo '<table class="mult_table">';
        
        if (!isset($_GET['content'])) {
            // Вывод всей таблицы (8 колонок)
            for ($i = 2; $i <= 9; $i++) {
                echo '<td>';
                outRow($i); //вызов функции заполнения
                echo '</td>';
            }
        } else {
            // Вывод одной колонки (крупно)
            echo '<td>';
            outRow($_GET['content']); //вызов функции заполнения
            echo '</td>';
        }
        
        echo '</table>';
    }

    // Функция выводит таблицу в БЛОЧНОЙ форме (<div>)
    function outDivForm() {
        if (!isset($_GET['content'])) {
            // Вывод всей таблицы (8 блоков)
            for ($i = 2; $i <= 9; $i++) {
                echo '<div class="ttRow">';
                outRow($i); //вызов функции заполнения
                echo '</div>';
            }
        } else {
            // Вывод одного блока
            echo '<div class="ttSingleRow">';
            outRow($_GET['content']); //вызов функции заполнения
            echo '</div>';
        }
    }

    
    // ОПРЕДЕЛЕНИЕ ТЕКУЩЕГО СОСТОЯНИЯ
    
    // По умолчанию табличная верстка
    $current_type = 'TABLE';
    if (isset($_GET['html_type']) && $_GET['html_type'] == 'DIV') {
        $current_type = 'DIV';
    }

    // 1. ГЛАВНОЕ МЕНЮ (ШАПКА)
    ?>
    <div id="main_menu">
        <?php
        // Ссылка "Табличная верстка"
        echo '<a href="?html_type=TABLE'; //URL
        // Сопряжении: сохраняем параметр content, если он есть
        if (isset($_GET['content'])) {
            echo '&content=' . $_GET['content'];
        }
        echo '"';
        // Выделение: только если параметр html_type явно равен TABLE
        // Если параметра нет вообще  - ничего не выделено
        if (isset($_GET['html_type']) && $_GET['html_type'] == 'TABLE') {
            echo ' class="selected"';
        }
        echo '>Табличная верстка</a> ';

        // Ссылка "Блочная верстка"
        echo '<a href="?html_type=DIV';
        if (isset($_GET['content'])) {
            echo '&content=' . $_GET['content'];
        }
        echo '"';
        // Выделение: только если параметр html_type явно равен DIV
        if (isset($_GET['html_type']) && $_GET['html_type'] == 'DIV') {
            echo ' class="selected"';
        }
        echo '>Блочная верстка</a>';
        ?>
    </div>

    <!-- Область основного контента (Меню + Таблица) -->
    <div class="main-content-area">
        
        <?php
        // 2. ОСНОВНОЕ МЕНЮ (СЛЕВА)
        ?>
        <div id="product_menu">
            <?php
            // Ссылка "Всё"
            echo '<a href="?';
            // Сохраняем тип верстки
            if (isset($_GET['html_type'])) {
                echo 'html_type=' . $_GET['html_type'];
            }
            echo '"';
            // Выделение: если параметр content НЕ передан
            if (!isset($_GET['content'])) {
                echo ' class="selected"';
            }
            echo '>Всё</a>';

            // Цикл для цифр 2-9
            for ($i = 2; $i <= 9; $i++) {
                echo '<a href="?content=' . $i;
                // Сохраняем тип верстки
                if (isset($_GET['html_type'])) {
                    echo '&html_type=' . $_GET['html_type'];
                }
                echo '"';
                // Выделение: если переданный content равен текущей цифре
                if (isset($_GET['content']) && $_GET['content'] == $i) {
                    echo ' class="selected"';
                }
                echo '>' . $i . '</a>';
            }
            ?>
        </div>

        <?php
        // 4. ТАБЛИЦА УМНОЖЕНИЯ (ОСНОВНАЯ ЧАСТЬ)
        ?>
        <div id="content_area">
            <?php
            if ($current_type == 'TABLE') {
                outTableForm();
            } else {
                outDivForm();
            }
            ?>
        </div>
    </div> <!-- Конец main-content-area -->

    <?php
    // 3. ИНФОРМАЦИЯ (ПОДВАЛ)
    ?>
    <div id="footer">
        <?php
        $info_text = '';
        
        // Тип верстки
        if ($current_type == 'TABLE') {
            $info_text .= 'Табличная верстка. ';
        } else {
            $info_text .= 'Блочная верстка. ';
        }

        // Название таблицы
        if (!isset($_GET['content'])) {
            $info_text .= 'Таблица умножения полностью. ';
        } else {
            $info_text .= 'Столбец таблицы умножения на ' . $_GET['content'] . '. ';
        }

        // Дата и время
        $info_text .= date('d.Y.M H:i:s');

        echo $info_text;
        ?>
    </div>

</div> <!-- Конец page-wrapper -->

</body>
</html>