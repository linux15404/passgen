<?php

declare(strict_types=1);

/**
 * passgen — консольный генератор паролей
 *
 * Использование:
 *   php passgen.php              — пароль на 16 символов
 *   php passgen.php 24           — пароль на 24 символа
 *   php passgen.php 24 --no-sym  — без спецсимволов
 */

const LOWER = 'abcdefghijklmnopqrstuvwxyz';
const UPPER = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
const DIGITS = '0123456789';
const SYMBOLS = '!@#$%^&*()-_=+[]{}<>?';

function printHeader(): void
{
    $banner = <<<'BANNER'
██████╗  █████╗ ███████╗███████╗ ██████╗ ███████╗███╗   ██╗
██╔══██╗██╔══██╗██╔════╝██╔════╝██╔═════╗██╔════╝████╗  ██║
██████╔╝███████║███████╗███████╗██║  ███╗███████╗██╔██╗ ██║
██╔═══╝ ██╔══██║╚════██║╚════██║██║   ██║██╔══╝  ██║╚██╗██║
██║     ██║  ██║███████║███████║╚██████╔╝███████╗██║ ╚████║
╚═╝     ╚═╝  ╚═╝╚══════╝╚══════╝ ╚═════╝ ╚══════╝╚═╝  ╚═╝
BANNER;

    foreach (explode("\n", $banner) as $line) {
        echo "\033[1;37m{$line}\033[0m\n";
    }

    echo "\n";
    echo "  \033[1;97mpassgen\033[0m \033[90mby\033[0m \033[97mlinux15404\033[0m"
        . "  ·  \033[90mgithub.com/linux15404/passgen\033[0m\n";
    echo "  \033[90m" . str_repeat('─', 62) . "\033[0m\n";
}

function generatePassword(int $length, bool $useSymbols): string
{
    $charset = LOWER . UPPER . DIGITS;
    if ($useSymbols) {
        $charset .= SYMBOLS;
    }

    $maxIndex = strlen($charset) - 1;
    $password = '';

    for ($i = 0; $i < $length; $i++) {
        $password .= $charset[random_int(0, $maxIndex)];
    }

    return $password;
}

$length = (int)($argv[1] ?? 16);
$useSymbols = !in_array('--no-sym', $argv, true);

if (stream_isatty(STDOUT) && !getenv('NO_COLOR')) {
    printHeader();
}

if ($length < 8) {
    fwrite(STDERR, "Ошибка: минимальная длина 8 символов.\n");
    exit(1);
}

echo generatePassword($length, $useSymbols), PHP_EOL;
