<?php
session_start();

// ЛОГИКА ХРАНИЛИЩА (STORE) 
if(!isset($_GET['store'])) // если НЕ передано предыдущее значение
$_GET['store'] = ''; // создаем пустое хранилище
else // иначе
if(isset($_GET['key'])) // если кнопка была нажата
$_GET['store'] .= $_GET['key']; // сохранить цифру в хранилище

// ЛОГИКА СЧЕТЧИКА (COUNT) 
if(!isset($_SESSION['total_clicks'])) {
    $_SESSION['total_clicks'] = 0; // Инициализация при первом заходе (или после рестарта сервера)
}

// Если нажата любая кнопка с цифрой (параметр key есть и он не 'reset', хотя у нас reset нет в key)
if(isset($_GET['key'])) {
    $_SESSION['total_clicks']++; // Увеличиваем счетчик в сессии
}

// выводим содержимое хранилища
echo'<div class="result">'.$_GET['store']. '</div>';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Виртуальная клавиатура (ЛР3)</title>
    <style>
        /*СТИЛИ ДЛЯ ПРИЖАТОГО ПОДВАЛА (STICKY FOOTER)*/
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            display: flex;
            flex-direction: column;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        
        /* Блок-растяжка */
        .main-content {
            flex: 1 0 auto; 
            margin-top: 50px;
        }

        /* Окно просмотра результата */
        div.result {
            border: 2px solid #333;
            width: 300px;
            min-height: 50px;
            margin: 0 auto 20px auto;
            padding: 10px;
            font-size: 24px;
            background-color: #f0f0f0;
            text-align: center;
            word-wrap: break-word;
            overflow-wrap: break-word;
            line-height: 1.5;
        }
        /* Контейнер для кнопок */
        .keyboard {
            margin-bottom: 20px;
        }
        /* Стили для кнопок-ссылок */
        .btn {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            margin: 5px;
            border: 1px solid #999;
            background-color: #e0e0e0;
            text-decoration: none;
            color: #000;
            font-weight: bold;
            border-radius: 4px;
        }
        .btn:hover {
            background-color: #ccc;
        }
        .btn-reset {
            width: 100px;
            background-color: #ffcccc;
        }
        /* Подвал со счетчиком */
        footer {
            flex-shrink: 0;
            margin-top: auto;
            font-size: 14px;
            color: #555;
            border-top: 1px solid #ccc;
            padding: 10px 0 20px 0;
            background-color: #fff;
            width: 100%;
        }
    </style>
</head>
<body>

    <!-- Основной контент -->
    <div class="main-content">
        <!-- Виртуальная клавиатура -->
        <div class="keyboard">
            <!-- Ряд 1: 1 2 3 4 5 -->
            <div>
                <a href="/?key=1&store=<?php echo$_GET['store'];?>" class="btn">1</a>
                <a href="/?key=2&store=<?php echo$_GET['store'];?>" class="btn">2</a>
                <a href="/?key=3&store=<?php echo$_GET['store'];?>" class="btn">3</a>
                <a href="/?key=4&store=<?php echo$_GET['store'];?>" class="btn">4</a>
                <a href="/?key=5&store=<?php echo$_GET['store'];?>" class="btn">5</a>
            </div>
            <!-- Ряд 2: 6 7 8 9 0 -->
            <div>
                <a href="/?key=6&store=<?php echo$_GET['store'];?>" class="btn">6</a>
                <a href="/?key=7&store=<?php echo$_GET['store'];?>" class="btn">7</a>
                <a href="/?key=8&store=<?php echo$_GET['store'];?>" class="btn">8</a>
                <a href="/?key=9&store=<?php echo$_GET['store'];?>" class="btn">9</a>
                <a href="/?key=0&store=<?php echo$_GET['store'];?>" class="btn">0</a>
            </div>
            <!-- Кнопка СБРОС -->
            <div style="margin-top: 10px;">
                <a href="/" class="btn btn-reset">СБРОС</a>
            </div>
        </div>
    </div>

    <!-- Подвал с общим числом нажатий (из сессии) -->
    <footer>
        Всего нажатий: <?php echo$_SESSION['total_clicks'];?>
    </footer>

</body>
</html>