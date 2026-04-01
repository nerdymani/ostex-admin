<?php
/**
 * Ostex Admin — First-time server bootstrap
 * Upload this file, visit it ONCE, then delete it.
 */

$root = dirname(__DIR__);
echo "<pre style='font-family:monospace;font-size:13px;padding:20px;background:#111;color:#0f0;min-height:100vh'>";
echo "=== Ostex Admin Server Bootstrap ===\n\n";

// 1. Check PHP
echo "PHP: " . PHP_VERSION . "\n";
echo "Binary: " . PHP_BINARY . "\n\n";

// 2. Find a working shell function
function run(string $cmd): string {
    $disabled = array_map('trim', explode(',', ini_get('disable_functions')));
    if (function_exists('exec') && !in_array('exec', $disabled)) {
        exec($cmd . ' 2>&1', $out); return implode("\n", $out);
    }
    if (function_exists('shell_exec') && !in_array('shell_exec', $disabled)) {
        return trim((string) shell_exec($cmd . ' 2>&1'));
    }
    if (function_exists('proc_open') && !in_array('proc_open', $disabled)) {
        $p = proc_open($cmd, [1=>['pipe','w'],2=>['pipe','w']], $pipes);
        if (is_resource($p)) {
            $o  = stream_get_contents($pipes[1]) . stream_get_contents($pipes[2]);
            fclose($pipes[1]); fclose($pipes[2]); proc_close($p);
            return trim($o);
        }
    }
    return 'ERROR: No shell function available';
}

// 3. Find PHP binary
$phpCandidates = [PHP_BINARY, '/usr/local/php83/bin/php', '/usr/local/php82/bin/php', '/usr/bin/php83', '/usr/bin/php'];
$php = 'php';
foreach ($phpCandidates as $c) {
    if ($c && @file_exists($c) && @is_executable($c)) { $php = $c; break; }
}
echo "PHP binary: $php\n\n";

// 4. Find or download Composer
$composerCandidates = ['/usr/local/bin/composer', '/usr/local/cpanel/3rdparty/bin/composer', '/usr/bin/composer'];
$composerCmd = null;
foreach ($composerCandidates as $c) {
    if (@file_exists($c) && @is_executable($c)) { $composerCmd = $c; break; }
}
if (!$composerCmd && file_exists($root . '/composer.phar')) {
    $composerCmd = "$php " . escapeshellarg($root . '/composer.phar');
}
if (!$composerCmd) {
    echo "Composer not found locally — downloading composer.phar...\n";
    $phar = @file_get_contents('https://getcomposer.org/composer-stable.phar');
    if ($phar) {
        file_put_contents($root . '/composer.phar', $phar);
        $composerCmd = "$php " . escapeshellarg($root . '/composer.phar');
        echo "Downloaded OK\n";
    } else {
        echo "ERROR: Could not download composer. Try uploading composer.phar manually.\n";
    }
}
echo "Composer: " . ($composerCmd ?? 'NOT FOUND') . "\n\n";

// 5. Run composer install if vendor is missing
if (!file_exists($root . '/vendor/autoload.php')) {
    if ($composerCmd) {
        echo "vendor/ missing — running composer install...\n";
        $out = run("cd " . escapeshellarg($root) . " && $composerCmd install --no-dev --optimize-autoloader --no-interaction");
        echo $out . "\n\n";
        echo file_exists($root . '/vendor/autoload.php') ? "✓ vendor/ created successfully\n\n" : "✗ vendor/ still missing after install\n\n";
    } else {
        echo "ERROR: Cannot install — no composer available\n\n";
    }
} else {
    echo "✓ vendor/ already exists\n\n";
}

// 6. Check .env
$envExists = file_exists($root . '/.env');
echo ".env: " . ($envExists ? "EXISTS" : "MISSING — copy .env.example to .env") . "\n";
if ($envExists) {
    $env = file_get_contents($root . '/.env');
    echo "APP_KEY set: " . (str_contains($env, 'APP_KEY=base64:') ? 'YES' : 'NO — run key:generate') . "\n";
    echo "SESSION_DRIVER: " . (preg_match('/SESSION_DRIVER=(\S+)/', $env, $m) ? $m[1] : 'not found') . "\n";
}
echo "\n";

// 7. Check storage/bootstrap writable
echo "storage/ writable:         " . (is_writable($root . '/storage') ? 'YES' : 'NO') . "\n";
echo "bootstrap/cache writable:  " . (is_writable($root . '/bootstrap/cache') ? 'YES' : 'NO') . "\n\n";

// 8. If everything looks OK, proceed to installer
if (file_exists($root . '/vendor/autoload.php') && $envExists) {
    echo "=== All good! Redirecting to installer in 3 seconds... ===\n";
    echo "</pre><script>setTimeout(()=>location.href='/install',3000)</script>";
} else {
    echo "=== Fix the issues above, then visit /install ===\n";
    echo "</pre>";
}
