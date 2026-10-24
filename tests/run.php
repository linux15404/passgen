<?php

declare(strict_types=1);

/**
 * Автотесты passgen — запуск: php tests/run.php
 */

const SCRIPT = __DIR__ . '/../passgen.php';

const SYMBOLS = '!@#$%^&*()-_=+[]{}<>?';

function runScript(string ...$args): string
{
    $cmd = 'php ' . escapeshellarg(SCRIPT) . implode(' ', array_map(
        fn (string $a): string => ' ' . escapeshellarg($a),
        $args
    ));
    return trim((string)shell_exec($cmd));
}

$failures = 0;
$tests = 0;

function check(bool $condition, string $name, string $detail = ''): void
{
    global $failures, $tests;
    $tests++;
    if ($condition) {
        echo "  ✓ $name\n";
    } else {
        $failures++;
        echo "  ✗ $name $detail\n";
    }
}

// Дефолт: 16 символов
echo "Тест: дефолтный запуск\n";
$password = runScript();
check(strlen($password) === 16, 'длина 16', "(получено " . strlen($password) . ": '$password')");

// Флаг --no-sym убирает спецсимволы
echo "Тест: --no-sym\n";
$password = runScript('16', '--no-sym');
check(strlen($password) === 16, 'длина 16', "(получено '$password')");
check(strpbrk($password, SYMBOLS) === false, 'без спецсимволов', "('$password')");
check(preg_match('/^[A-Za-z0-9]+$/', $password) === 1, 'только буквы и цифры', "('$password')");

// Длина задаётся аргументом
echo "Тест: своя длина\n";
$password = runScript('24');
check(strlen($password) === 24, 'длина 24', "(получено " . strlen($password) . ": '$password')");

// Слишком короткий — ошибка
echo "Тест: короткий пароль = ошибка\n";
// STDERR не попадает в stdout через shell_exec, поэтому проверяем пустой вывод
$password = runScript('4');
check($password === '', 'короткий пароль ошивается', "(вывод: '$password')");

// Рандом: 100 паролей — все уникальные
echo "Тест: случайность\n";
$seen = [];
$duplicates = 0;
for ($i = 0; $i < 100; $i++) {
    $password = runScript();
    if (in_array($password, $seen, true)) {
        $duplicates++;
    }
    $seen[] = $password;
}
check($duplicates === 0, '100 паролей все уникальные', "(дублей: $duplicates)");

echo "\n";
echo $failures === 0
    ? "ВСЁ ЧИСТО: $tests/$tests тестов прошли\n"
    : "ПРОВАЛ: $failures из $tests тестов упали\n";
exit($failures === 0 ? 0 : 1);
