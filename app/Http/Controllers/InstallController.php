<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InstallController extends Controller
{
    protected string $progressFile;

    public function __construct()
    {
        $this->progressFile = storage_path('app/install_progress.json');
    }

    protected function saveProgress(array $data): void
    {
        $existing = $this->getProgress();
        $merged   = array_merge($existing, $data);
        @mkdir(dirname($this->progressFile), 0755, true);
        file_put_contents($this->progressFile, json_encode($merged));
    }

    protected function getProgress(): array
    {
        if (!file_exists($this->progressFile)) return [];
        return json_decode(file_get_contents($this->progressFile), true) ?? [];
    }

    protected function writeEnv(array $values): void
    {
        $envPath = base_path('.env');
        if (!file_exists($envPath)) {
            copy(base_path('.env.example'), $envPath);
        }
        $contents = file_get_contents($envPath);
        foreach ($values as $key => $value) {
            $escaped = addcslashes((string) $value, '"\\');
            if (preg_match("/^{$key}=/m", $contents)) {
                $contents = preg_replace("/^{$key}=.*/m", "{$key}=\"{$escaped}\"", $contents);
            } else {
                $contents .= "\n{$key}=\"{$escaped}\"";
            }
        }
        file_put_contents($envPath, $contents);
    }

    protected function runChecks(): array
    {
        return [
            ['label' => 'PHP >= 8.2',             'pass' => version_compare(PHP_VERSION, '8.2.0', '>='), 'value' => PHP_VERSION],
            ['label' => 'PDO Extension',           'pass' => extension_loaded('pdo'),         'value' => extension_loaded('pdo')         ? 'Enabled' : 'Missing'],
            ['label' => 'PDO MySQL',               'pass' => extension_loaded('pdo_mysql'),   'value' => extension_loaded('pdo_mysql')   ? 'Enabled' : 'Missing'],
            ['label' => 'OpenSSL Extension',       'pass' => extension_loaded('openssl'),     'value' => extension_loaded('openssl')     ? 'Enabled' : 'Missing'],
            ['label' => 'Mbstring Extension',      'pass' => extension_loaded('mbstring'),    'value' => extension_loaded('mbstring')    ? 'Enabled' : 'Missing'],
            ['label' => 'cURL Extension',          'pass' => extension_loaded('curl'),        'value' => extension_loaded('curl')        ? 'Enabled' : 'Missing'],
            ['label' => 'Fileinfo Extension',      'pass' => extension_loaded('fileinfo'),    'value' => extension_loaded('fileinfo')    ? 'Enabled' : 'Missing'],
            ['label' => 'Storage Writable',        'pass' => is_writable(storage_path()),     'value' => is_writable(storage_path())     ? 'Writable' : 'Not Writable'],
            ['label' => 'Bootstrap/Cache Writable','pass' => is_writable(base_path('bootstrap/cache')), 'value' => is_writable(base_path('bootstrap/cache')) ? 'Writable' : 'Not Writable'],
            ['label' => '.env Writable',           'pass' => is_writable(base_path('.env')) || !file_exists(base_path('.env')), 'value' => (is_writable(base_path('.env')) || !file_exists(base_path('.env'))) ? 'Writable' : 'Not Writable'],
        ];
    }

    public function index()
    {
        $checks    = $this->runChecks();
        $allPassed = collect($checks)->every(fn($c) => $c['pass']);
        return view('install.step1', compact('checks', 'allPassed'));
    }

    public function databaseForm()
    {
        $progress = $this->getProgress();
        return view('install.step2', compact('progress'));
    }

    public function databaseStore(Request $request)
    {
        $data = $request->validate([
            'db_host'     => 'required',
            'db_port'     => 'required',
            'db_name'     => 'required',
            'db_username' => 'required',
            'db_password' => 'nullable',
        ]);

        try {
            $dsn = "mysql:host={$data['db_host']};port={$data['db_port']};dbname={$data['db_name']}";
            new \PDO($dsn, $data['db_username'], $data['db_password'] ?? '');
        } catch (\PDOException $e) {
            return back()->withErrors(['db_name' => 'Connection failed: ' . $e->getMessage()])->withInput();
        }

        $this->saveProgress($data);
        return redirect()->route('install.admin');
    }

    public function adminForm()
    {
        $progress = $this->getProgress();
        return view('install.step3', compact('progress'));
    }

    public function adminStore(Request $request)
    {
        $data = $request->validate([
            'name'                  => 'required',
            'email'                 => 'required|email',
            'password'              => 'required|min:8|confirmed',
        ]);

        $this->saveProgress([
            'admin_name'     => $data['name'],
            'admin_email'    => $data['email'],
            'admin_password' => $data['password'],
        ]);

        return redirect()->route('install.run-form');
    }

    public function runForm()
    {
        return view('install.step4');
    }

    protected function reloadDbConfig(): void
    {
        $envPath = base_path('.env');
        if (file_exists($envPath)) {
            foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
                if (str_starts_with(trim($line), '#')) continue;
                [$key, $value] = array_pad(explode('=', $line, 2), 2, '');
                $key   = trim($key);
                $value = trim(trim($value), '"\'');
                putenv("{$key}={$value}");
                $_ENV[$key]    = $value;
                $_SERVER[$key] = $value;
            }
        }

        config([
            'database.default'                            => 'mysql',
            'database.connections.mysql.host'             => env('DB_HOST', '127.0.0.1'),
            'database.connections.mysql.port'             => env('DB_PORT', '3306'),
            'database.connections.mysql.database'         => env('DB_DATABASE', ''),
            'database.connections.mysql.username'         => env('DB_USERNAME', ''),
            'database.connections.mysql.password'         => env('DB_PASSWORD', ''),
        ]);

        DB::purge('mysql');
        DB::setDefaultConnection('mysql');
        DB::reconnect('mysql');
    }

    protected function createStorageLink(): void
    {
        try {
            Artisan::call('storage:link');
        } catch (\Throwable $e) {
            $link = public_path('storage');
            if (!file_exists($link) && !is_link($link)) {
                @symlink(storage_path('app/public'), $link);
            }
        }
    }

    public function runInstall(Request $request)
    {
        $progress = $this->getProgress();
        $steps    = [];

        try {
            $steps[] = 'Writing environment configuration...';
            $this->writeEnv([
                'APP_NAME'    => $progress['app_name']    ?? 'Ostex Admin',
                'APP_URL'     => $progress['app_url']     ?? url('/'),
                'DB_CONNECTION' => 'mysql',
                'DB_HOST'     => $progress['db_host']     ?? '127.0.0.1',
                'DB_PORT'     => $progress['db_port']     ?? '3306',
                'DB_DATABASE' => $progress['db_name']     ?? '',
                'DB_USERNAME' => $progress['db_username'] ?? '',
                'DB_PASSWORD' => $progress['db_password'] ?? '',
            ]);

            $steps[] = 'Generating application key...';
            Artisan::call('key:generate', ['--force' => true]);

            $steps[] = 'Connecting to database...';
            $this->reloadDbConfig();

            $steps[] = 'Running database migrations...';
            Artisan::call('migrate', ['--force' => true]);

            $steps[] = 'Seeding database...';
            foreach ([
                \Database\Seeders\SettingsSeeder::class,
                \Database\Seeders\ServicesSeeder::class,
                \Database\Seeders\TeamSeeder::class,
                \Database\Seeders\BlogSeeder::class,
                \Database\Seeders\PortfolioSeeder::class,
                \Database\Seeders\TestimonialSeeder::class,
                \Database\Seeders\StatsSeeder::class,
                \Database\Seeders\FaqSeeder::class,
                \Database\Seeders\PricingSeeder::class,
            ] as $seeder) {
                try {
                    Artisan::call('db:seed', ['--class' => $seeder, '--force' => true]);
                } catch (\Throwable $e) {
                    $steps[] = 'Warning: ' . class_basename($seeder) . ' skipped – ' . $e->getMessage();
                }
            }

            $steps[] = 'Creating admin account...';
            if (!empty($progress['admin_email'])) {
                User::updateOrCreate(
                    ['email' => $progress['admin_email']],
                    [
                        'name'               => $progress['admin_name']     ?? 'Admin',
                        'password'           => Hash::make($progress['admin_password'] ?? 'password'),
                        'email_verified_at'  => now(),
                    ]
                );
            }

            $steps[] = 'Creating storage symlink...';
            $this->createStorageLink();

            $steps[] = 'Finalizing installation...';
            // Switch session & cache to database now that tables exist
            $this->writeEnv([
                'SESSION_DRIVER' => 'database',
                'CACHE_STORE'    => 'database',
            ]);
            file_put_contents(storage_path('app/.installed'), date('Y-m-d H:i:s'));

            if (file_exists($this->progressFile)) {
                @unlink($this->progressFile);
            }

            $steps[] = 'Clearing application cache...';
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');

            $steps[] = 'Installation complete!';

            return response()->json(['success' => true, 'steps' => $steps]);

        } catch (\Throwable $e) {
            $steps[] = 'ERROR: ' . $e->getMessage();
            return response()->json(['success' => false, 'steps' => $steps, 'error' => $e->getMessage()], 500);
        }
    }

    public function complete()
    {
        return view('install.step5');
    }
}
