# passgen

<img width="574" height="180" alt="Screenshot From 2026-10-27 22-39-27" src="https://github.com/user-attachments/assets/feebb965-07d9-4d8d-97d0-f7965e331287" />


Консольный генератор паролей на PHP. Криптостойкий рандом, минимум зависимостей — только PHP.

## Использование

```bash
php passgen.php              # пароль на 16 символов
php passgen.php 24           # пароль на 24 символа
php passgen.php 24 --no-sym  # без спецсимволов
```

## Установка

Требуется **PHP 8.1+**. Проверить версию:

```bash
php -v
```

### Вариант 1 — запуск из папки (без установки)

```bash
git clone https://github.com/linux15404/passgen.git
cd passgen
php passgen.php              # работает сразу
```

### Вариант 2 — поставить как команду `passgen`

```bash
git clone https://github.com/linux15404/passgen.git
cd passgen
chmod +x passgen.php
sudo ln -s "$PWD/passgen.php" /usr/local/bin/passgen   # или в ~/.local/bin без sudo

passgen                       # теперь работает откуда угодно
passgen 24 --no-sym
```

(если не запускается - php passgen.php)

### Тесты

```bash
php tests/run.php
```

## Почему random_int?

`rand()` предсказуем, `random_int()` — криптостойкий. Для паролей только второй.
