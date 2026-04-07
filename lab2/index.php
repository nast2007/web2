<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛР №А-2 | Еремина А.С. | Группа 241-352 | Вариант 8</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <div class="logo">
        <img src="logo.png" alt="Университет" style="height: 100px;">
    </div>
    <div class="header-info">
        <h1>Лабораторная работа №А-2</h1>
        <p>Выполнил: Еремина Анастасия Сергеевна</p>
        <p>Группа: 241-352</p>
        <p>Вариант: 8</p>
    </div>
</header>

<main>
    <?php
    // 1. Инициализация числовых переменных 
    $start_value = -10;      // начальное значение аргумента
    $encounting = 20;        // количество вычисляемых значений (ограничено для наглядности)
    $step = 2;               // шаг изменения аргумента
    $min_value = -100;       // минимальное значение функции для остановки
    $max_value = 1000;       // максимальное значение функции для остановки

    // 2. Инициализация строковой переменной типа верстки
    $type = 'B';             // Доступные типы: 'A', 'B', 'C', 'D', 'E'

    // Переменные для статистики
    $sum = 0;
    $count_valid = 0;
    $func_min = null;
    $func_max = null;

    // Текущее значение аргумента
    $x = $start_value;

    // Начало вывода в зависимости от типа верстки (открывающие теги)
    if ($type == 'B') echo '<ul>';
    if ($type == 'C') echo '<ol>';
    if ($type == 'D') echo '<table border="1" style="border-collapse: collapse; border: 1px solid black;"><tr><th>№</th><th>Аргумент (x)</th><th>Значение (f)</th></tr>';
    if ($type == 'E') echo '<div style="display: flex; flex-wrap: wrap;">';

    // 3. Цикл вычисления значений функции 
    for ($i = 0; $i < $encounting; $i++, $x += $step) {
        
        // Вычисление функции для Вариант 8
        // f(x) = { 7*x + 18, при x <= 10
        //          (x - 17) / (8 - x*0.5), при x > 10 и x < 20
        //          (x + 4) * (x - 7), при x >= 20 }
        
        $f = 0;
        $is_error = false;

        if ($x <= 10) {
            $f = 7 * $x + 18;
        } elseif ($x > 10 && $x < 20) {
            $denominator = 8 - $x * 0.5;
            if ($denominator == 0) {
                $f = "error";
                $is_error = true;
            } else {
                $f = ($x - 17) / $denominator;
            }
        } else { // x >= 20
            $f = ($x + 4) * ($x - 7);
        }

        // Проверка на бесконечность или NaN 
        if (!$is_error && (is_infinite($f) || is_nan($f))) {
            $f = "error";
            $is_error = true;
        }

        // 4. Проверка условий остановки (мин/макс значение функции)
        // Если значение вышло за рамки - прекращаем цикл 
        if (!$is_error && ($f >= $max_value || $f < $min_value)) {
            break;
        }

        // Округление до 3 знаков 
        if (!$is_error) {
            $f = round($f, 3);
        }

        // Обновление статистики 
        if (!$is_error) {
            $sum += $f;
            $count_valid++;
            if ($func_min === null || $f < $func_min) $func_min = $f;
            if ($func_max === null || $f > $func_max) $func_max = $f;
        }

        // 5. Вывод в зависимости от типа верстки
        $output_line = "f(" . $x . ")=" . $f;

        switch ($type) {
            case 'A':
                // Простая верстка текстом
                echo $output_line;
                if ($i < $encounting - 1) echo '<br>';
                break;
            
            case 'B':
                // Маркированный список
                echo '<li>' . $output_line . '</li>';
                break;
            
            case 'C':
                // Нумерованный список
                echo '<li>' . $output_line . '</li>';
                break;
            
            case 'D':
                // Табличная верстка
                echo '<tr>';
                echo '<td style="border: 1px solid black; padding: 5px;">' . ($i + 1) . '</td>';
                echo '<td style="border: 1px solid black; padding: 5px;">' . $x . '</td>';
                echo '<td style="border: 1px solid black; padding: 5px;">' . $f . '</td>';
                echo '</tr>';
                break;
            
            case 'E':
                // Блочная верстка (горизонтально, красная рамка 2px, отступ 8px)
                echo '<div style="border: 2px solid red; margin: 8px; padding: 5px;">' . $output_line . '</div>';
                break;
        }
    }

    // Закрытие тегов в зависимости от типа верстки
    if ($type == 'B') echo '</ul>';
    if ($type == 'C') echo '</ol>';
    if ($type == 'D') echo '</table>';
    if ($type == 'E') echo '</div>';

    // 6. Вывод статистики
    echo '<hr>';
    echo '<h3>Статистика вычислений:</h3>';
    echo '<p>Сумма значений: ' . round($sum, 3) . '</p>';
    echo '<p>Минимальное значение: ' . ($func_min !== null ? $func_min : 'нет') . '</p>';
    echo '<p>Максимальное значение: ' . ($func_max !== null ? $func_max : 'нет') . '</p>';
    
    $average = ($count_valid > 0) ? round($sum / $count_valid, 3) : 0;
    echo '<p>Среднее арифметическое: ' . $average . '</p>';
    echo '<p>Количество вычисленных значений: ' . $count_valid . '</p>';
    ?>
</main>

<footer>
    <div class="footer-content">
        <p>Тип верстки: <?php echo $type; ?></p>
        <p>&copy; 2026 Лабораторная работа №А-2</p>
    </div>
</footer>

</body>
</html>