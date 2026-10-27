# passgen

<img width="574" height="180" alt="Screenshot From 2026-10-27 22-39-27" src="https://github.com/user-attachments/assets/feebb965-07d9-4d8d-97d0-f7965e331287" />


Консольный генератор паролей на PHP. Криптостойкий рандом, минимум зависимостей — только PHP.

## Использование

```bash
php passgen.php              # пароль на 16 символов
php passgen.php 24           # пароль на 24 символа
php passgen.php 24 --no-sym  # без спецсимволов
```

## Требования

- PHP 8.1+

## Почему random_int?

`rand()` предсказуем, `random_int()` — криптостойкий. Для паролей только второй.
