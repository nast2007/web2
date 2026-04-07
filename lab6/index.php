<?php
// Генерация случайных чисел от 0 до 100 (вещественные)
function getRandomValue() {
    return mt_rand(0, 10000) / 100;
}

// Инициализация переменных
$fio = "";
$group = "";
$about = "";
$email = "";
$valA = getRandomValue();
$valB = getRandomValue();
$valC = getRandomValue();
$userResult = "";
$taskType = "mean";
$viewMode = "browser";
$resultCalculated = null;
$isSubmitted = false;
$messageStatus = "";
$out_text = "";

// ПРОВЕРКА: Была ли отправлена форма (наличие поля 'A' в POST)
if (isset($_POST['A'])) {
    $isSubmitted = true;

    // 1. Получение данных из формы
    $fio = $_POST['FIO'] ?? '';
    $group = $_POST['GROUP'] ?? '';
    $about = $_POST['ABOUT'] ?? '';
    $email = $_POST['MAIL'] ?? '';
    
    // Обработка чисел (замена запятой на точку для корректности)
    $valA = isset($_POST['A']) ? floatval(str_replace(',', '.', $_POST['A'])) : 0;
    $valB = isset($_POST['B']) ? floatval(str_replace(',', '.', $_POST['B'])) : 0;
    $valC = isset($_POST['C']) ? floatval(str_replace(',', '.', $_POST['C'])) : 0;
    
    $userResult = $_POST['RESULT'] ?? '';
    $taskType = $_POST['TASK'] ?? 'mean';
    $viewMode = $_POST['VIEW_MODE'] ?? 'browser';

    // 2. Автоматическое решение задачи (согласно листингу А-6.3)
    if ($taskType == 'mean') {
        $resultCalculated = round(($valA + $valB + $valC) / 3, 2);
    } elseif ($taskType == 'perimetr') {
        $resultCalculated = $valA + $valB + $valC;
    } elseif ($taskType == 'area_triangle') {
        $p = ($valA + $valB + $valC) / 2;
        $s = $p * ($p - $valA) * ($p - $valB) * ($p - $valC);
        $resultCalculated = ($s > 0) ? round(sqrt($s), 2) : 0;
    } elseif ($taskType == 'volume_box') {
        $resultCalculated = round($valA * $valB * $valC, 2);
    } elseif ($taskType == 'max_val') {
        $resultCalculated = max($valA, $valB, $valC);
    } elseif ($taskType == 'min_val') {
        $resultCalculated = min($valA, $valB, $valC);
    } else {
        $resultCalculated = 0;
    }

    // 3. Формирование отчета в переменную $out_text (согласно листингу А-6.6)
    $out_text .= "ФИО: " . $fio . "\n";
    $out_text .= "Группа: " . $group . "\n";
    
    if ($about) {
        $out_text .= "О себе: " . $about . "\n";
    }

    $out_text .= "Решаемая задача: ";
    if ($taskType == 'mean') $out_text .= "СРЕДНЕЕ АРИФМЕТИЧЕСКОЕ";
    elseif ($taskType == 'perimetr') $out_text .= "ПЕРИМЕТР ТРЕУГОЛЬНИКА";
    elseif ($taskType == 'area_triangle') $out_text .= "ПЛОЩАДЬ ТРЕУГОЛЬНИКА";
    elseif ($taskType == 'volume_box') $out_text .= "ОБЪЕМ ПАРАЛЛЕЛЕПИПЕДА";
    elseif ($taskType == 'max_val') $out_text .= "МАКСИМАЛЬНОЕ ЗНАЧЕНИЕ";
    elseif ($taskType == 'min_val') $out_text .= "МИНИМАЛЬНОЕ ЗНАЧЕНИЕ";
    
    $out_text .= "\nВходные данные: A={$valA}, B={$valB}, C={$valC}\n";

    // Проверка ответа
    if ($userResult === "") {
        $out_text .= "Ваш ответ: Задача самостоятельно решена не была\n";
        $testPassed = false;
    } else {
        $userResultFloat = round(floatval(str_replace(',', '.', $userResult)), 2);
        $out_text .= "Ваш ответ: {$userResult}\n";
        $out_text .= "Вычисленный программой результат: {$resultCalculated}\n";

        // Сравнение (согласно листингу А-6.5)
        if ($userResultFloat === $resultCalculated) {
            $out_text .= "ТЕСТ ПРОЙДЕН\n";
            $testPassed = true;
        } else {
            $out_text .= "ОШИБКА: ТЕСТ НЕ ПРОЙДЕН!\n";
            $testPassed = false;
        }
    }

    // 4. Отправка почты (согласно листингу А-6.6)
    // Проверяем, установлен ли флажок send_mail
    if (isset($_POST['send_mail']) && !empty($email)) {
        $subject = "Результат тестирования";
        // Заменяем переносы строк для почтового формата
        $mailMessage = str_replace("\n", "\r\n", $out_text);
        $headers = "From: auto@mami.ru\n" . "Content-Type: text/plain; charset=utf-8\n";

        // Попытка отправки
        if (mail($email, $subject, $mailMessage, $headers)) {
            $messageStatus = "<div class='success-msg'>Результаты теста были автоматически отправлены на e-mail: <b>" . htmlspecialchars($email) . "</b></div>";
        } else {
            // Если сервер не настроен (localhost)
            $messageStatus = "<div class='error-msg'>Внимание: Функция отправки почты не выполнена сервером (требуется настройка SMTP).<br>Тем не менее, данные были готовы к отправке на: <b>" . htmlspecialchars($email) . "</b></div>";
        }
    }
} else {
    // Если форма не отправлена, проверяем GET параметры (кнопка "Повторить тест")
    if (isset($_GET['F']) && isset($_GET['G'])) {
        $fio = $_GET['F'];
        $group = $_GET['G'];
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Лабораторная работа №А-6: Тест математических знаний</title>
    <link rel="stylesheet" href="style.css">
    <script>
        // JavaScript для скрытия/показа поля Email (согласно справочной информации)
        function toggleEmail() {
            var checkbox = document.getElementById('send_mail_check');
            var emailBlock = document.getElementById('email_block');
            if (checkbox.checked) {
                emailBlock.style.display = 'flex';
            } else {
                emailBlock.style.display = 'none';
            }
        }
    </script>
</head>
<body>

<div class="container">
    <?php if ($isSubmitted): ?>
        <!-- Блок вывода результатов -->
        <div class="report-block <?php echo ($viewMode == 'print') ? 'print-mode' : 'browser-mode'; ?>">
            <h2>Отчет о тестировании</h2>
            <p><strong>ФИО:</strong> <?php echo htmlspecialchars($fio); ?></p>
            <p><strong>Группа:</strong> <?php echo htmlspecialchars($group); ?></p>
            
            <?php if (!empty($about)): ?>
                <p><strong>О себе:</strong> <?php echo nl2br(htmlspecialchars($about)); ?></p>
            <?php endif; ?>

            <p><strong>Решаемая задача:</strong> 
            <?php 
                if ($taskType == 'mean') echo "СРЕДНЕЕ АРИФМЕТИЧЕСКОЕ";
                elseif ($taskType == 'perimetr') echo "ПЕРИМЕТР ТРЕУГОЛЬНИКА";
                elseif ($taskType == 'area_triangle') echo "ПЛОЩАДЬ ТРЕУГОЛЬНИКА";
                elseif ($taskType == 'volume_box') echo "ОБЪЕМ ПАРАЛЛЕЛЕПИПЕДА";
                elseif ($taskType == 'max_val') echo "МАКСИМАЛЬНОЕ ЗНАЧЕНИЕ";
                elseif ($taskType == 'min_val') echo "МИНИМАЛЬНОЕ ЗНАЧЕНИЕ";
            ?>
            </p>
            
            <p><strong>Входные данные:</strong> A=<?php echo $valA; ?>, B=<?php echo $valB; ?>, C=<?php echo $valC; ?></p>
            
            <?php if ($userResult === ""): ?>
                <p><strong>Ваш ответ:</strong> Задача самостоятельно решена не была</p>
            <?php else: ?>
                <p><strong>Ваш ответ:</strong> <?php echo htmlspecialchars($userResult); ?></p>
                <p><strong>Вычисленный программой результат:</strong> <?php echo $resultCalculated; ?></p>
                
                <?php 
                $userResultFloat = round(floatval(str_replace(',', '.', $userResult)), 2);
                if ($userResultFloat === $resultCalculated): ?>
                    <p class="status-pass"><b>ТЕСТ ПРОЙДЕН</b></p>
                <?php else: ?>
                    <p class="status-fail"><b>ОШИБКА: ТЕСТ НЕ ПРОЙДЕН!</b></p>
                <?php endif; ?>
            <?php endif; ?>

            <?php echo $messageStatus; ?>

            <?php if ($viewMode == 'browser'): ?>
                <div class="retry-block">
                    <!-- Кнопка оформлена в виде ссылки <a> (согласно заданию) -->
                    <a href="?F=<?php echo urlencode($fio); ?>&G=<?php echo urlencode($group); ?>" class="retry-button">Повторить тест</a>
                </div>
            <?php endif; ?>
        </div>

    <?php else: ?>
        <!-- Блок формы -->
        <form name="math_test" method="post" action="">
            <h1>Тест математических знаний</h1>
            
            <div class="form-row">
                <label>ФИО:</label>
                <input type="text" name="FIO" value="<?php echo htmlspecialchars($fio); ?>" required>
            </div>

            <div class="form-row">
                <label>Номер группы:</label>
                <input type="text" name="GROUP" value="<?php echo htmlspecialchars($group); ?>" required>
            </div>

            <div class="form-row">
                <label>Значение А:</label>
                <input type="text" name="A" value="<?php echo $valA; ?>" required>
            </div>

            <div class="form-row">
                <label>Значение В:</label>
                <input type="text" name="B" value="<?php echo $valB; ?>" required>
            </div>

            <div class="form-row">
                <label>Значение С:</label>
                <input type="text" name="C" value="<?php echo $valC; ?>" required>
            </div>

            <div class="form-row">
                <label>Выберите задачу:</label>
                <select name="TASK">
                    <option value="area_triangle">Площадь треугольника</option>
                    <option value="perimetr">Периметр треугольника</option>
                    <option value="volume_box">Объем параллелепипеда</option>
                    <option value="mean">Среднее арифметическое</option>
                    <option value="max_val">Максимальное из трех (доп.)</option>
                    <option value="min_val">Минимальное из трех (доп.)</option>
                </select>
            </div>

            <div class="form-row">
                <label>Ваш ответ:</label>
                <input type="text" name="RESULT" value="<?php echo htmlspecialchars($userResult); ?>">
            </div>

            <div class="form-row">
                <label>Немного о себе:</label>
                <textarea name="ABOUT"><?php echo htmlspecialchars($about); ?></textarea>
            </div>

            <div class="form-row">
                <label>
                    <!-- Имя 'send_mail' как в листинге А-6.6 -->
                    <input type="checkbox" name="send_mail" id="send_mail_check" value="1" onclick="toggleEmail()">
                    Отправить результат теста по е-майл
                </label>
            </div>

            <div id="email_block" class="form-row" style="display: none;">
                <label>Ваш е-майл:</label>
                <input type="email" name="MAIL" value="<?php echo htmlspecialchars($email); ?>">
            </div>

            <div class="form-row">
                <label>Версия просмотра:</label>
                <select name="VIEW_MODE">
                    <option value="browser">Версия для просмотра в браузере</option>
                    <option value="print">Версия для печати</option>
                </select>
            </div>

            <div class="form-row button-row">
                <button type="submit" class="check-button">Проверить</button>
            </div>
        </form>
    <?php endif; ?>
</div>

</body>
</html>