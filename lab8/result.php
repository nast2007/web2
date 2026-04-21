<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результат анализа</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
// Функция подсчета вхождений каждого символа 
function test_symbs($text) {
    $symbs = array(); // массив символов текста
    $l_text = strtolower($text); // переводим текст в нижний регистр
    
    // последовательно перебираем все символы текста
    for ($i = 0; $i < strlen($l_text); $i++) {
        if (isset($symbs[$l_text[$i]])) // если символ есть в массиве
            $symbs[$l_text[$i]]++; // увеличиваем счетчик повторов
        else // иначе 
            $symbs[$l_text[$i]] = 1; // добавляем символ в массив
    }
    return $symbs; // возвращаем массив с числом вхождений символов в тексте
}

// Основная функция анализа 
function test_it($text) {
    // количество символов в тексте определяется функцией размера текста
    echo 'Количество символов: ' . strlen($text) . '<br>';

    // определяем ассоциированный массив с цифрами
    $cifra = array('0'=>true,'1'=>true,'2'=>true,'3'=>true,'4'=>true, 
                   '5'=>true,'6'=>true,'7'=>true,'8'=>true,'9'=>true);
    
    // определяем знаки препинания (базовый набор)
    $punct = array('.'=>true, ','=>true, '!'=>true, '?'=>true, ';'=>true, ':'=>true, 
                   '-'=>true, '('=>true, ')'=>true, '"'=>true, '\''=>true);

    // вводим переменные для хранения информации о:
    $cifra_amount = 0; // количество цифр в тексте
    $punct_amount = 0; // количество знаков препинания
    $letter_amount = 0; // количество букв
    $lower_amount = 0; // количество строчных букв
    $upper_amount = 0; // количество заглавных букв
    $word_amount = 0; // количество слов в тексте
    $word = ''; // текущее слово
    $words = array(); // список всех слов

    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];

        // Проверка на цифру
        if (array_key_exists($char, $cifra)) {
            $cifra_amount++;
        }
        
        // Проверка на знак препинания
        if (array_key_exists($char, $punct)) {
            $punct_amount++;
        }

        // Проверка на букву и регистр
        $code = ord($char);
        $is_letter = false;
        
        // Латиница
        if (($code >= 65 && $code <= 90) || ($code >= 97 && $code <= 122)) {
            $is_letter = true;
        }
        // Кириллица CP1251 (заглавные 192-223, строчные 224-255, Ё 168, ё 184)
        if (($code >= 192 && $code <= 223) || ($code >= 224 && $code <= 255) || $code == 168 || $code == 184) {
            $is_letter = true;
        }

        if ($is_letter) {
            $letter_amount++;
            // Проверка регистра
            if (($code >= 65 && $code <= 90) || ($code >= 192 && $code <= 223) || $code == 168) {
                $upper_amount++;
            } else {
                $lower_amount++;
            }
        }

        // если в тексте встретился пробел или текст закончился или знак препинания (как разделитель слов)
        if ($char == ' ' || array_key_exists($char, $punct) || $i == strlen($text) - 1) {
            
            // Коррекция для последнего символа, если он буква
            if ($i == strlen($text) - 1 && $is_letter) {
                 $word .= $char;
            }

            if ($word) { // если есть текущее слово
                // если текущее слово сохранено в списке слов
                if (isset($words[$word])) 
                    $words[$word]++; // увеличиваем число его повторов
                else 
                    $words[$word] = 1; // первый повтор слова
                
                $word = ''; // сбрасываем текущее слово
            }
        } else { 
            // если слово продолжается (не пробел и не пунктуация)
            $word .= $char; // добавляем в текущее слово новый символ
        }
    }

    // выводим статистику
    echo 'Количество букв: ' . $letter_amount . '<br>';
    echo 'Количество заглавных букв: ' . $upper_amount . '<br>';
    echo 'Количество строчных букв: ' . $lower_amount . '<br>';
    echo 'Количество знаков препинания: ' . $punct_amount . '<br>';
    echo 'Количество цифр: ' . $cifra_amount . '<br>';
    echo 'Количество слов: ' . count($words) . '<br>';
    
    echo '<hr>';
    
    // количество вхождений каждого символа текста (без различия верхнего и нижнего регистра)
    echo '<h3>Вхождения символов:</h3>';
    $symbs_count = test_symbs($text);
    ksort($symbs_count); 
    
    echo '<table border="1">';
    echo '<tr><th>Символ</th><th>Количество</th></tr>';
    foreach ($symbs_count as $char => $count) {
        // Перекодируем символ обратно в UTF-8 для вывода
        $char_utf8 = iconv("cp1251", "utf-8", $char);
        if ($char == ' ') $char_utf8 = '(пробел)';
        echo '<tr><td>' . htmlspecialchars($char_utf8) . '</td><td>' . $count . '</td></tr>';
    }
    echo '</table>';

    echo '<hr>';

    // список всех слов в тексте и количество их вхождений, отсортированный по алфавиту
    echo '<h3>Слова и их вхождения:</h3>';
    ksort($words); // сортировка ассоциативного массива по ключам (словам) по возрастанию
    
    echo '<table border="1">';
    echo '<tr><th>Слово</th><th>Количество вхождений</th></tr>';
    foreach ($words as $key => $val) {
        // перед выводом перекодируем строку обратно в UTF-8
        $word_utf8 = iconv("cp1251", "utf-8", $key);
        echo '<tr><td>' . htmlspecialchars($word_utf8) . '</td><td>' . $val . '</td></tr>';
    }
    echo '</table>';
}

// Основная логика страницы
if (isset($_POST['data']) && $_POST['data']) { // если передан текст для анализа
    
    $original_text = htmlspecialchars($_POST['data']);
    $original_text = nl2br($original_text);
    echo '<div class="src_text">' . $original_text . '</div>'; 

    test_it(iconv("utf-8", "cp1251", $_POST['data'])); 
    
} else { // если текста нет или он пустой
    echo '<div class="src_error">Нет текста для анализа</div>';
}
?>

    <br>
    <a href="index.html">Другой анализ</a>

</body>
</html>