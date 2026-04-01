<?php
$root = dirname(__DIR__);

echo "<pre style='font-family:monospace;font-size:14px;padding:20px'>";

echo "=== PHP ===\n";
echo "Version:        " . PHP_VERSION . "\n";
echo "Binary:         " . PHP_BINARY . "\n";

echo "\n=== Shell functions ===\n";
$fns = ['exec','shell_exec','proc_open','passthru','system','popen'];
$disabled = array_map('trim', explode(',', ini_get('disable_functions')));
foreach ($fns as $fn) {
    $available = function_exists($fn) && !in_array($fn, $disabled);
    echo str_pad($fn, 15) . ($available ? "AVAILABLE" : "DISABLED") . "\n";
}

echo "\n=== Composer ===\n";
$composerPaths = ['/usr/local/bin/composer', '/usr/bin/composer', $root . '/composer.phar'];
foreach ($composerPaths as $p) {
    echo str_pad($p, 40) . (file_exists($p) ? "FOUND" : "not found") . "\n";
}

$out = '';
foreach (['exec','shell_exec'] as $fn) {
    if (function_exists($fn) && !in_array($fn, $disabled)) {
        if ($fn === 'exec') { exec('which composer 2>&1', $lines); $out = implode('', $lines); }
        else { $out = shell_exec('which composer 2>&1'); }
        echo "which composer:  " . trim((string)$out) . "\n";
        break;
    }
}

echo "\n=== vendor/ ===\n";
echo "autoload.php:   " . (file_exists($root . '/vendor/autoload.php') ? "EXISTS" : "MISSING") . "\n";

echo "\n=== Paths ===\n";
echo "Project root:   " . $root . "\n";
echo "Document root:  " . ($_SERVER['DOCUMENT_ROOT'] ?? 'n/a') . "\n";

echo "\n=== Permissions ===\n";
foreach ([$root, $root . '/.env', $root . '/storage'] as $p) {
    echo str_pad(str_replace($root, '', $p) ?: '/', 20) . (is_writable($p) ? "writable" : "NOT writable") . "\n";
}

echo "</pre>";
