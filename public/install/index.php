<?php
/**
 * Ostex Admin - Web Installer
 * Visit: http://yourdomain.com/install/
 */

$root = dirname(dirname(__DIR__));
$envPath = $root . '/.env';
$envExample = $root . '/.env.example';

$step = $_GET['step'] ?? 'requirements';
$message = '';
$error = '';

// ── Requirements ────────────────────────────────────────────
function checkRequirements(): array {
    return [
        ['PHP >= 8.2', version_compare(PHP_VERSION, '8.2.0', '>='), PHP_VERSION],
        ['PDO MySQL', extension_loaded('pdo_mysql'), extension_loaded('pdo_mysql') ? 'OK' : 'Missing'],
        ['OpenSSL', extension_loaded('openssl'), extension_loaded('openssl') ? 'OK' : 'Missing'],
        ['Mbstring', extension_loaded('mbstring'), extension_loaded('mbstring') ? 'OK' : 'Missing'],
        ['Tokenizer', extension_loaded('tokenizer'), extension_loaded('tokenizer') ? 'OK' : 'Missing'],
        ['JSON', extension_loaded('json'), extension_loaded('json') ? 'OK' : 'Missing'],
        ['Fileinfo', extension_loaded('fileinfo'), extension_loaded('fileinfo') ? 'OK' : 'Missing'],
        ['.env writable', is_writable(dirname($GLOBALS['envPath'])), is_writable(dirname($GLOBALS['envPath'])) ? 'OK' : 'Not writable'],
    ];
}

// ── Handle form posts ────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($step === 'configure') {
        $fields = ['APP_NAME','APP_URL','DB_HOST','DB_PORT','DB_DATABASE','DB_USERNAME','DB_PASSWORD',
                   'ADMIN_EMAIL','ADMIN_PASSWORD'];
        $env = file_get_contents($envExample);
        foreach ($fields as $f) {
            $val = $_POST[$f] ?? '';
            $val = addslashes($val);
            $env = preg_replace('/^' . $f . '=.*/m', $f . '="' . $val . '"', $env);
        }
        file_put_contents($envPath, $env);

        // Run artisan commands
        $output = [];
        chdir($root);
        exec('php artisan key:generate --force 2>&1', $output);
        exec('php artisan migrate --force 2>&1', $output);
        exec('php artisan db:seed --force 2>&1', $output);
        exec('php artisan storage:link 2>&1', $output);

        $imploded = implode("\n", $output);
        if (strpos($imploded, 'error') !== false || strpos($imploded, 'Error') !== false) {
            $error = htmlspecialchars($imploded);
        } else {
            header('Location: ?step=success');
            exit;
        }
    }
}

$reqs = checkRequirements();
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
.req-list li{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f3f4f6;font-size:.9rem}
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
      <span><?= $r[0] ?></span>
      <span class="<?= $r[1]?'ok':'fail' ?>"><?= $r[2] ?></span>
    </li>
    <?php endforeach; ?>
  </ul>
  <?php if ($allPassed): ?>
    <a href="?step=configure" class="btn">Continue →</a>
  <?php else: ?>
    <p style="color:#dc2626">Please fix the requirements above before continuing.</p>
  <?php endif; ?>

<?php elseif ($step === 'configure'): ?>
  <h2 style="margin-bottom:16px">Step 2: Configuration</h2>
  <?php if ($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
  <form method="POST">
    <p class="section-title">Application</p>
    <div class="form-group"><label>App Name</label><input name="APP_NAME" value="Ostex Admin" required></div>
    <div class="form-group"><label>App URL</label><input name="APP_URL" value="http://localhost:8000" required></div>

    <p class="section-title">Database (MySQL)</p>
    <div class="form-group"><label>DB Host</label><input name="DB_HOST" value="127.0.0.1" required></div>
    <div class="form-group"><label>DB Port</label><input name="DB_PORT" value="3306" required></div>
    <div class="form-group"><label>DB Name</label><input name="DB_DATABASE" value="ostex_admin" required></div>
    <div class="form-group"><label>DB Username</label><input name="DB_USERNAME" value="root" required></div>
    <div class="form-group"><label>DB Password</label><input name="DB_PASSWORD" type="password" value=""></div>

    <p class="section-title">Admin Account</p>
    <div class="form-group"><label>Admin Email</label><input name="ADMIN_EMAIL" type="email" value="admin@ostex.com" required></div>
    <div class="form-group"><label>Admin Password</label><input name="ADMIN_PASSWORD" type="password" value="password" required></div>

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
