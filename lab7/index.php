<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Лабораторная работа №7 - Ввод массива</title>
    <link rel="stylesheet" href="style.css">
    <script>
        // Листинг А-7.2 (Функция setHTML)
        function setHTML(element, txt) {
            if (element.innerHTML) {
                element.innerHTML = txt;
            } else {
                var range = document.createRange();
                range.selectNodeContents(element);
                range.deleteContents();
                var fragment = range.createContextualFragment(txt);
                element.appendChild(fragment);
            }
        }

        // Листинг А-7.1 (Модифицированная функция addElement)
        function addElement(table_name, amount) {
            var t = document.getElementById(table_name); // объект таблицы
            
            for (var i = 0; i < amount; i++) {
                var index = t.rows.length; // индекс новой строки
                var row = t.insertRow(index); // добавляем новую строку
                
                // Ячейка для номера элемента
                var celNum = row.insertCell(0);
                celNum.className = 'element_num';
                setHTML(celNum, index + ':'); // Номер элемента слева

                // Ячейка для поля ввода
                var celInput = row.insertCell(1);
                celInput.className = 'element_row';
                
                // Формируем html-код содержимого ячейки с уникальным именем elementX
                var celcontent = '<input type="text" name="element' + index + '">';
                
                // добавляем контент в ячейку таблицы
                setHTML(celInput, celcontent);
            }
            
            // в скрытом поле записываем количество полей(строк таблицы)
            document.getElementById('arrLength').value = t.rows.length;
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Ввод массива для сортировки</h1>
        
        <!-- Форма отправляет данные во второй файл -->
        <form action="sort_process.php" method="POST" target="_blank">
            <table id="elements">
                <!-- Первая строка создается статически, но лучше генерировать через JS при загрузке или оставить одну -->
                <tr>
                    <td class="element_num">0:</td>
                    <td class="element_row"><input type="text" name="element0"></td>
                </tr>
            </table>
            
            <!-- Скрытое поле для длины массива -->
            <input type="hidden" id="arrLength" name="arrLength" value="1">
            
            <div class="controls">
                <div class="control-group">
                    <label for="algoritm">Выберите алгоритм:</label>
                    <select name="algoritm" id="algoritm">
                        <option value="selection">Сортировка выбором</option>
                        <option value="bubble">Пузырьковый алгоритм</option>
                        <option value="shell">Алгоритм Шелла</option>
                        <option value="gnome">Алгоритм садового гнома</option>
                        <option value="quick">Быстрая сортировка</option>
                        <option value="php_builtin">Встроенная функция PHP (sort)</option>
                    </select>
                </div>

                <div class="buttons">
                    <!-- Кнопка добавляет 1 элемент без перезагрузки -->
                    <input type="button" value="Добавить еще один элемент" onClick="addElement('elements', 1);">
                    <!-- Кнопка отправляет форму -->
                    <input type="submit" value="Сортировать массив">
                </div>
            </div>
        </form>
    </div>
</body>
</html>