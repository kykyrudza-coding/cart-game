# Cart Navigation System

## Опис проєкту
Додаток для керування  візком (Cart), який обробляє закодовані команди для переміщення по 2D-сітці.

## Функціональність
- Переміщення візка по 2D-сітці (X, Y).
- Підйом (`PICK`) і розміщення (`DROP`) товарів у вказаних координатах.
- Обробка послідовності команд.
- Валідація некоректних команд.

## Структура проєкту
```
📂 src/
 ├── 📂 Classes/
 │    ├── 📂 Base/
 │    │    ├── Cart.php                                   # Основний клас керування візком
 │    │    ├── Grid.php                                   # Клас для роботи з сіткою
 │    │    ├── Move.php                                   # Клас для руху
 │    ├── 📂 Commands/
 │    │    ├── CommandFactory.php                         # Фабрика команд
 │    │    ├── DropCommand.php                            # Команда DROP
 │    │    ├── MoveCommand.php                            # Команда руху
 │    │    ├── PickCommand.php                            # Команда PICK
 │    ├── 📂 Contracts/
 │    │    ├── AppInterface.php                           # Інтерфейс застосунку
 │    │    ├── CommandInterface.php                       # Інтерфейс команд
 │    │    ├── MovableInterface.php                       # Інтерфейс рухомих об'єктів
 │    ├── 📂 Core/
 │    │    ├── App.php                                    # Основний застосунок
 │    │    ├── CommandExecutor.php                        # Виконавець команд
 │    ├── 📂 Exceptions/
 │    │    ├── InvalidCommandException.php                # Обробка винятків
 │    ├── 📂 Traits/
 │    │    ├── 📂 Cart/
 │    │    │    ├── CarryingItemTrait.php                 # Трейт для перенесення товару
 │    │    │    ├── CartTrait.php                         # Основний трейт візка
 │    │    │    ├── PositionTrait.php                     # Трейт позиції візка
 │    │    ├── MoveTrait.php                              # Трейт для руху
 ├── config.php                                           # Конфігурація програми (розмір сітки)
 ├── index.php                                            # Точка входу
```

## Встановлення і запуск

### Кроки встановлення:
1. Клонувати репозиторій:
   ```sh
   git clone https://github.com/kykyrudza/Cart-Test-Exerice.git
   cd Cart-Test-Exerice
   ```
2. Встановити залежності:
   ```sh
   composer install
   ```
3. Запустити програму в терміналі:
   ```sh
   php src/index.php
   ```

## Використання
Після запуску програма очікує введення команд. Приклад команд:
```
RIGHT-3-UP-2-PICK-3,2-LEFT-1-DROP-2,2
```
### Опис команд:
| Команда  | Дія                                                                      |
|----------|--------------------------------------------------------------------------|
| PICK-X,Y | Взяти товар у точці (X,Y) (тільки якщо візок знаходиться в цій точці)    |
| DROP-X,Y | Покласти товар у точці (X,Y) (тільки якщо візок знаходиться в цій точці) |
| RIGHT-N  | Переміститися вправо на N кроків                                         |
| LEFT-N   | Переміститися вліво на N кроків                                          |
| UP-N     | Переміститися вгору на N кроків                                          |
| DOWN-N   | Переміститися вниз на N кроків                                           |

## Приклади введення і виведення
### Вхід:

1. По черзі виконуються команди:
```
RIGHT-3
UP-3
PICK-3,3
DOWN-3
LEFT-3
DROP-0,0
```

2. Введення команд в одному рядку:
```
RIGHT-3-UP-3-PICK-3,3-DOWN-3-LEFT-3-DROP-0,0
```

3. Для виходу з програми введіть `exit`.

4. Для виявлення помилок введіть некоректну команду.
```sh
UP-10
PICK-10,10
```
### Вивід:
```
\Cart-Test-Exerice> php src/index.php
Grid size: 10x10
Enter command (or type 'exit' to quit): RIGHT-3
Cart position: (3, 0)
Carrying item: No
Enter command (or type 'exit' to quit): UP-3
Cart position: (3, 3)
Carrying item: No
Enter command (or type 'exit' to quit): PICK-3,3
Item picked on (3, 3)
Cart position: (3, 3)
Carrying item: Yes
Enter command (or type 'exit' to quit): DOWN-3
Cart position: (3, 0)
Carrying item: Yes
Enter command (or type 'exit' to quit): LEFT-3
Cart position: (0, 0)
Carrying item: Yes
Enter command (or type 'exit' to quit): DROP-0,0
Item dropped on (0, 0)
Cart position: (0, 0)
Carrying item: No
Enter command (or type 'exit' to quit): UP-10
Error: Cannot move up, out of bounds
Enter command (or type 'exit' to quit): PICK-10,10
Error: Cannot pick item at (10, 10)
Enter command (or type 'exit' to quit): 
```

## Обробка помилок
- Некоректні команди викликають помилку і не виконуються.
- Переміщення за межі сітки заборонено.
- Невірний формат команди `DROP` викликає помилку.
- Команда `PICK` або `DROP` може бути виконана лише в тому випадку, якщо координати візка збігаються з координатами команди.
