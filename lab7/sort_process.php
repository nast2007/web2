<?php
// Функция проверки: возвращает true, если аргумент НЕ число (Листинг А-7.4)
function arg_is_not_Num($arg) {
    if ($arg === '') return true; // передана пустая строка
    
    // Проверка на отрицательные числа (допускаем минус в начале)
    $startIdx = 0;
    if ($arg[0] === '-') $startIdx = 1;
    
    // Если строка состоит только из минуса
    if ($startIdx >= strlen($arg)) return true;

    for ($i = $startIdx; $i < strlen($arg); $i++) {
        if ($arg[$i] !== '0' && $arg[$i] !== '1' && $arg[$i] !== '2' && 
            $arg[$i] !== '3' && $arg[$i] !== '4' && $arg[$i] !== '5' && 
            $arg[$i] !== '6' && $arg[$i] !== '7' && $arg[$i] !== '8' && 
            $arg[$i] !== '9') {
            return true; // если встретилась не цифра
        }
    }
    return false; // строка состоит из чисел
}

// Вспомогательная функция для вывода состояния массива
function printArrayState($arr, $iteration, $algoName) {
    echo "<div class='iteration-block'>";
    echo "<span class='iter-num'>Итерация $iteration:</span> ";
    echo "<span class='array-state'>[" . implode(", ", $arr) . "]</span>";
    echo "</div>\n";
}

// --- АЛГОРИТМЫ СОРТИРОВКИ ---

// 1. Сортировка выбором
function sorting_by_choice($arr) {
    $iterations = 0;
    echo "<h2>Алгоритм: Сортировка выбором</h2>";
    
    for ($i = 0; $i < count($arr) - 1; $i++) {
        $min = $i;
        for ($j = $i + 1; $j < count($arr); $j++) {
            $iterations++; // считаем сравнения/действия как итерации процесса
            if ($arr[$j] < $arr[$min]) {
                $min = $j;
            }
        }
        
        if ($min != $i) {
            $temp = $arr[$i];
            $arr[$i] = $arr[$min];
            $arr[$min] = $temp;
        }
        // Вывод состояния после каждого внешнего цикла (шага алгоритма)
        // Или можно выводить внутри внутреннего, но обычно под итерацией алгоритма понимают проход внешнего цикла
        // Для наглядности "каждого шага работы" будем выводить после обмена или поиска минимума
        printArrayState($arr, $iterations, 'selection');
    }
    return [$arr, $iterations];
}

// 2. Пузырьковая сортировка
function bubble_sort($arr) {
    $iterations = 0;
    echo "<h2>Алгоритм: Пузырьковая сортировка</h2>";
    
    for ($j = 0; $j < count($arr) - 1; $j++) {
        for ($i = 0; $i < count($arr) - 1 - $j; $i++) {
            $iterations++;
            if ($arr[$i] > $arr[$i + 1]) { // Исправлено условие: всплывают меньшие (или большие, зависит от направления). В задании пример: 2<4 меняются -> всплывает большее? Нет, в примере 2 и 4 поменялись местами, стало 4,2... Стоп.
                // В тексте ЛР7 сказано: "если элемент меньше следующего, то они меняются местами". 
                // Пример в ЛР7: (2, 4, 1, 3) -> итерация 0: 2<4, меняем -> (4, 2, 1, 3)? 
                // Далее в примере: 2 и 1. 1<2? Нет, 1 меньше 2. В примере написано: "единица легче двойки, поэтому ничего не происходит". 
                // Значит, сортировка по УБЫВАНИЮ? 
                // Смотрим пример результата в ЛР7 для пузырька: Исходный 2 4 1 3. Результат 4 3 2 1? 
                // В листинге А-7.5 условие: if($arr[$i]<$a[$i+1]) swap. Это сортировка по убыванию.
                // Однако стандартная задача - сортировка по возрастанию. 
                // В разделе "Справочная информация" sort() - по возрастанию.
                // Давайте сделаем по возрастанию (стандарт), так как в выборе минимума мы искали минимум.
                // Если строго следовать листингу А-7.5, то это убывание. 
                // НО, в задании на выбор есть "rsort" (убывание) и "sort" (возрастание). Обычно подразумевают возрастание.
                // Исправим на стандартное поведение (возрастание), чтобы было логично с другими алгоритмами.
                // Условие для возрастания: if ($arr[$i] > $arr[$i+1])
                
                $temp = $arr[$i];
                $arr[$i] = $arr[$i + 1];
                $arr[$i + 1] = $temp;
            }
            printArrayState($arr, $iterations, 'bubble');
        }
    }
    return [$arr, $iterations];
}

// 3. Алгоритм Шелла
function shell_sort($arr) {
    $iterations = 0;
    echo "<h2>Алгоритм: Сортировка Шелла</h2>";
    
    $n = count($arr);
    for ($k = ceil($n / 2); $k >= 1; $k = ceil($k / 2)) {
        for ($i = $k; $i < $n; $i++) {
            $val = $arr[$i];
            $j = $i - $k;
            
            while ($j >= 0 && $arr[$j] > $val) {
                $iterations++;
                $arr[$j + $k] = $arr[$j];
                $j -= $k;
                printArrayState($arr, $iterations, 'shell');
            }
            $arr[$j + $k] = $val;
            // Вывод после вставки элемента
            $iterations++; 
            printArrayState($arr, $iterations, 'shell');
        }
    }
    return [$arr, $iterations];
}

// 4. Алгоритм садового гнома
function gnome_sort($arr) {
    $iterations = 0;
    echo "<h2>Алгоритм: Садовый гном</h2>";
    
    $i = 1;
    $j = 2;
    while ($i < count($arr)) {
        $iterations++;
        if (!$i || $arr[$i - 1] <= $arr[$i]) {
            $i = $j;
            $j++;
        } else {
            $temp = $arr[$i];
            $arr[$i] = $arr[$i - 1];
            $arr[$i - 1] = $temp;
            $i--;
        }
        printArrayState($arr, $iterations, 'gnome');
    }
    return [$arr, $iterations];
}

// 5. Быстрая сортировка
// Глобальная переменная для подсчета итераций и вывода, т.к. функция рекурсивная
$quickIterations = 0;

function quickSortRecursive(&$arr, $left, $right) {
    global $quickIterations;
    
    $l = $left;
    $r = $right;
    $point = $arr[floor(($left + $right) / 2)]; // опорная точка
    
    do {
        while ($arr[$l] < $point) $l++;
        while ($arr[$r] > $point) $r--;
        
        if ($l <= $r) {
            $temp = $arr[$l];
            $arr[$l] = $arr[$r];
            $arr[$r] = $temp;
            $l++;
            $r--;
            
            $quickIterations++;
            printArrayState($arr, $quickIterations, 'quick');
        }
    } while ($l <= $r);
    
    if ($r > $left) quickSortRecursive($arr, $left, $r);
    if ($l < $right) quickSortRecursive($arr, $l, $right);
}

function quick_sort_wrapper($arr) {
    global $quickIterations;
    $quickIterations = 0;
    echo "<h2>Алгоритм: Быстрая сортировка</h2>";
    
    if (count($arr) > 0) {
        quickSortRecursive($arr, 0, count($arr) - 1);
    }
    return [$arr, $quickIterations];
}


// --- ОСНОВНАЯ ЛОГИКА ОБРАБОТКИ ---

// 1. Если данные не переданы
if (!isset($_POST['element0'])) {
    echo '<h1>Ошибка</h1>';
    echo 'Массив не задан, сортировка невозможна';
    exit();
}

// 2. Валидация входных данных
$arrLength = (int)$_POST['arrLength'];
$inputArr = [];
$isValid = true;

for ($i = 0; $i < $arrLength; $i++) {
    $key = 'element' . $i;
    if (isset($_POST[$key])) {
        $val = $_POST[$key];
        // Проверка на пустое поле считаем как ошибку или пропускаем? 
        // По заданию: "Если среди элементов массива есть не числа – сортировка не выполняется"
        if (arg_is_not_Num($val)) {
            echo '<h1>Ошибка валидации</h1>';
            echo 'Элемент массива "' . htmlspecialchars($val) . '" (индекс ' . $i . ') – не число';
            exit();
        }
        $inputArr[] = (int)$val; // Приводим к числу для корректной сортировки
    }
}

if (empty($inputArr)) {
     echo '<h1>Ошибка</h1>';
     echo 'Входных данных нет – сортировка не выполняется';
     exit();
}

// 3. Выбор алгоритма и запуск
$algorithm = $_POST['algoritm'];
$resultArr = $inputArr;
$totalIterations = 0;

echo '<!DOCTYPE html>';
echo '<html lang="ru"><head><meta charset="UTF-8"><title>Результат сортировки</title>';
echo '<link rel="stylesheet" href="style.css"></head><body>';
echo '<div class="container result-container">';

echo '<h1>Процесс сортировки</h1>';
echo '<div class="info-block">';
echo '<p><strong>Выбранный алгоритм:</strong> ' . htmlspecialchars($algorithm) . '</p>';
echo '<p><strong>Входные данные:</strong> [' . implode(", ", $inputArr) . ']</p>';
echo '<p><strong>Статус валидации:</strong> Все элементы являются числами.</p>';
echo '</div>';

echo '<h3>Ход выполнения:</h3>';
echo '<div class="process-log">';

$timeStart = microtime(true);

switch ($algorithm) {
    case 'selection':
        list($resultArr, $totalIterations) = sorting_by_choice($inputArr);
        break;
    case 'bubble':
        list($resultArr, $totalIterations) = bubble_sort($inputArr);
        break;
    case 'shell':
        list($resultArr, $totalIterations) = shell_sort($inputArr);
        break;
    case 'gnome':
        list($resultArr, $totalIterations) = gnome_sort($inputArr);
        break;
    case 'quick':
        list($resultArr, $totalIterations) = quick_sort_wrapper($inputArr);
        break;
    case 'php_builtin':
        echo "<h2>Алгоритм: Встроенная функция PHP (sort)</h2>";
        echo "<p>Примечание: Встроенная функция не предоставляет пошаговый вывод итераций в стандартном режиме.</p>";
        sort($resultArr);
        $totalIterations = 0; // Неизвестно
        printArrayState($resultArr, 1, 'php_builtin');
        break;
    default:
        echo "Неизвестный алгоритм";
        exit();
}

$timeEnd = microtime(true);
$executionTime = $timeEnd - $timeStart;

echo '</div>'; // end process-log

echo '<div class="final-result">';
echo '<h3>Итоговый результат:</h3>';
echo '<p class="sorted-array">[' . implode(", ", $resultArr) . ']</p>';
echo '<p class="summary">Сортировка завершена, проведено ' . $totalIterations . ' итераций.</p>';
echo '<p class="summary">Сортировка заняла ' . number_format($executionTime, 6) . ' секунд.</p>';
echo '</div>';

echo '</div></body></html>';
?>