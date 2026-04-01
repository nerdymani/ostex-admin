<?php
/**
 * Ostex Admin - Web Installer
 * Visit: http://yourdomain.com/install/
 */

$root     = dirname(dirname(__DIR__));
$envPath  = $root . '/.env';
$envExample = $root . '/.env.example';
$autoload = $root . '/vendor/autoload.php';

$step  = $_GET['step'] ?? 'requirements';
$error = '';

// ── Requirements ─────────────────────────────────────────────
function checkRequirements(string $envPath, string $autoload): array {
    $vendorOk = file_exists($autoload);

    return [
        ['PHP >= 8.2',   version_compare(PHP_VERSION, '8.2.0', '>='), PHP_VERSION],
        ['PDO MySQL',    extension_loaded('pdo_mysql'),  extension_loaded('pdo_mysql')  ? 'OK' : 'Missing'],
        ['OpenSSL',      extension_loaded('openssl'),    extension_loaded('openssl')    ? 'OK' : 'Missing'],
        ['Mbstring',     extension_loaded('mbstring'),   extension_loaded('mbstring')   ? 'OK' : 'Missing'],
        ['Tokenizer',    extension_loaded('tokenizer'),  extension_loaded('tokenizer')  ? 'OK' : 'Missing'],
        ['JSON',         extension_loaded('json'),       extension_loaded('json')       ? 'OK' : 'Missing'],
        ['Fileinfo',     extension_loaded('fileinfo'),   extension_loaded('fileinfo')   ? 'OK' : 'Missing'],
        ['vendor/ folder', $vendorOk, $vendorOk ? 'OK' : 'Missing — upload the vendor/ folder or run: composer install'],
        ['.env writable',  is_writable(dirname($envPath)), is_writable(dirname($envPath)) ? 'OK' : 'Not writable'],
    ];
}

// ── Handle form POST ──────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $step === 'configure') {

    if (!file_exists($envExample)) {
        $error = '.env.example not found in project root. Cannot continue.';
    } elseif (!file_exists($autoload)) {
        $error = 'vendor/autoload.php not found. Make sure vendor.zip is in the project root and ZipArchive is enabled, or upload the vendor/ folder directly.';
    } else {
        // 1. Build and write .env from .env.example
        $fields = ['APP_NAME','APP_URL','DB_HOST','DB_PORT','DB_DATABASE','DB_USERNAME','DB_PASSWORD',
                   'ADMIN_EMAIL','ADMIN_PASSWORD'];
        $env = file_get_contents($envExample);

        foreach ($fields as $f) {
            $val = $_POST[$f] ?? '';
            $val = str_replace('"', '\\"', $val);
            if (preg_match('/^' . $f . '=/m', $env)) {
                $env = preg_replace('/^' . $f . '=.*/m', $f . '="' . $val . '"', $env);
            } else {
                $env .= "\n" . $f . '="' . $val . '"';
            }
        }

        // 2. Generate APP_KEY — pure PHP, no exec() needed
        $appKey = 'base64:' . base64_encode(random_bytes(32));
        $env    = preg_replace('/^APP_KEY=.*/m', 'APP_KEY=' . $appKey, $env);

        if (file_put_contents($envPath, $env) === false) {
            $error = 'Could not write .env — check write permissions on the project root.';
        } else {
            // 3. Bootstrap Laravel and run migrations/seeders — no exec() needed
            try {
                require $autoload;

                $app     = require $root . '/bootstrap/app.php';
                $artisan = $app->make(\Illuminate\Contracts\Console\Kernel::class);

                $exitCode = $artisan->call('migrate', ['--force' => true]);
                if ($exitCode !== 0) {
                    throw new \RuntimeException('Migration failed. Check your database credentials.');
                }

                $artisan->call('db:seed', ['--force' => true]);

                // Storage symlink — pure PHP, no exec() needed
                $storagePublic = $root . '/public/storage';
                $storageTarget = $root . '/storage/app/public';
                if (!file_exists($storagePublic) && !is_link($storagePublic)) {
                    symlink($storageTarget, $storagePublic);
                }

                $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
                header('Location: ' . $scheme . '://' . $_SERVER['HTTP_HOST'] . '/install/?step=success');
                exit;

            } catch (\Throwable $e) {
                $error = htmlspecialchars($e->getMessage());
            }
        }
    }
}

$reqs      = checkRequirements($envPath, $autoload);
$allPassed = array_reduce($reqs, fn($c, $r) => $c && $r[1], true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ostex Admin - Installer</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:system-ui,sans-serif;background:#0c214f;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
.card{background:#fff;border-radius:16px;padding:40px;max-width:600px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,.3)}
h1{color:#0c214f;font-size:1.8rem;margin-bottom:4px}
.brand{color:#fa5a0d;font-weight:800}
.subtitle{color:#666;margin-bottom:30px;font-size:.9rem}
.step-bar{display:flex;gap:8px;margin-bottom:30px}
.step{flex:1;height:4px;border-radius:2px;background:#e5e7eb}
.step.active{background:#fa5a0d}
.step.done{background:#0c214f}
.req-list{list-style:none;margin-bottom:24px}
.req-list li{display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid #f3f4f6;font-size:.9rem;gap:12px}
.req-list li span:first-child{flex-shrink:0}
.req-list li span:last-child{text-align:right;word-break:break-word}
.ok{color:#16a34a;font-weight:600}
.fail{color:#dc2626;font-weight:600}
.form-group{margin-bottom:16px}
label{display:block;font-size:.85rem;font-weight:600;color:#374151;margin-bottom:4px}
input{width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:.95rem}
input:focus{outline:none;border-color:#fa5a0d;box-shadow:0 0 0 3px rgba(250,90,13,.1)}
.btn{display:inline-block;background:#fa5a0d;color:#fff;padding:12px 28px;border-radius:8px;border:none;cursor:pointer;font-size:1rem;font-weight:600;text-decoration:none;margin-top:8px}
.btn:hover{background:#e04e09}
.btn-sec{background:#0c214f}
.btn-sec:hover{background:#0a1c43}
.error{background:#fef2f2;border:1px solid #fecaca;color:#dc2626;padding:12px;border-radius:8px;margin-bottom:16px;font-size:.85rem;white-space:pre-wrap}
.success-icon{font-size:4rem;text-align:center;margin-bottom:16px}
.section-title{font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#9ca3af;margin:20px 0 8px}
</style>
</head>
<body>
<div class="card">
  <h1><span class="brand">Ostex</span> Admin</h1>
  <p class="subtitle">Web Installer — follow the steps below</p>

  <div class="step-bar">
    <div class="step <?= $step==='requirements'?'active':($step!=='requirements'?'done':'') ?>"></div>
    <div class="step <?= $step==='configure'?'active':($step==='success'?'done':'') ?>"></div>
    <div class="step <?= $step==='success'?'active':'' ?>"></div>
  </div>

<?php if ($step === 'requirements'): ?>
  <h2 style="margin-bottom:16px">Step 1: Requirements</h2>
  <ul class="req-list">
    <?php foreach ($reqs as $r): ?>
    <li>
      <span><?= htmlspecialchars($r[0]) ?></span>
      <span class="<?= $r[1] ? 'ok' : 'fail' ?>"><?= htmlspecialchars((string)$r[2]) ?></span>
    </li>
    <?php endforeach; ?>
  </ul>
  <?php if ($allPassed): ?>
    <a href="?step=configure" class="btn">Continue →</a>
  <?php else: ?>
    <p style="color:#dc2626;margin-top:8px">Please fix the requirements above before continuing.</p>
  <?php endif; ?>

<?php elseif ($step === 'configure'): ?>
  <h2 style="margin-bottom:16px">Step 2: Configuration</h2>
  <?php if ($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
  <form method="POST">
    <p class="section-title">Application</p>
    <div class="form-group"><label>App Name</label><input name="APP_NAME" value="Ostex Admin" required></div>
    <div class="form-group"><label>App URL</label><input name="APP_URL" value="<?= htmlspecialchars(( (!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')?'https':'http').'://'.$_SERVER['HTTP_HOST']) ?>" required></div>

    <p class="section-title">Database (MySQL)</p>
    <div class="form-group"><label>DB Host</label><input name="DB_HOST" value="127.0.0.1" required></div>
    <div class="form-group"><label>DB Port</label><input name="DB_PORT" value="3306" required></div>
    <div class="form-group"><label>DB Name</label><input name="DB_DATABASE" value="ostex_admin" required></div>
    <div class="form-group"><label>DB Username</label><input name="DB_USERNAME" value="root" required></div>
    <div class="form-group"><label>DB Password</label><input name="DB_PASSWORD" type="password"></div>

    <p class="section-title">Admin Account</p>
    <div class="form-group"><label>Admin Email</label><input name="ADMIN_EMAIL" type="email" value="admin@ostex.com" required></div>
    <div class="form-group"><label>Admin Password</label><input name="ADMIN_PASSWORD" type="password" placeholder="Min 8 characters" required></div>

    <button type="submit" class="btn">Install →</button>
  </form>

<?php elseif ($step === 'success'): ?>
  <div class="success-icon">✅</div>
  <h2 style="text-align:center;margin-bottom:8px">Installation Complete!</h2>
  <p style="text-align:center;color:#666;margin-bottom:24px">Ostex Admin has been installed successfully.</p>
  <div style="text-align:center">
    <a href="/admin" class="btn btn-sec">Go to Admin Panel →</a>
  </div>
  <p style="text-align:center;margin-top:20px;font-size:.8rem;color:#9ca3af">
    ⚠️ Delete or protect the <code>/public/install/</code> directory after setup.
  </p>
<?php endif; ?>

</div>
</body>
</html>
