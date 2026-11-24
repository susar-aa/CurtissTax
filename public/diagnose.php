<?php
/**
 * CurtissTax Production Diagnostics Tool
 * Access via browser: https://taxinvoice.trycurtiss.com/diagnose.php
 */

header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$baseDir = realpath(__DIR__ . '/..');

echo "<!DOCTYPE html><html><head><title>CurtissTax Server Diagnostics</title>";
echo "<style>
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, monospace; background: #0a0a0a; color: #f3f4f6; padding: 30px; line-height: 1.6; }
    .card { background: #171717; border: 1px solid #262626; border-radius: 8px; padding: 20px; margin-bottom: 20px; }
    .ok { color: #4ade80; font-weight: bold; }
    .fail { color: #f87171; font-weight: bold; }
    .warn { color: #fbbf24; font-weight: bold; }
    h1 { color: #fff; margin-bottom: 20px; }
    h2 { color: #e5e7eb; border-bottom: 1px solid #333; padding-bottom: 8px; margin-top: 0; font-size: 1.1rem; }
    pre { background: #000; padding: 12px; border-radius: 6px; overflow-x: auto; color: #fca5a5; }
</style></head><body>";

echo "<h1>CurtissTax Live Server Diagnostics</h1>";

// 1. PHP Version & Extensions
echo "<div class='card'><h2>1. PHP Runtime</h2>";
echo "PHP Version: " . PHP_VERSION . " ";
if (version_compare(PHP_VERSION, '8.0.2', '>=')) {
    echo "<span class='ok'>[OK]</span><br>";
} else {
    echo "<span class='fail'>[FAIL - Requires PHP >= 8.0.2]</span><br>";
}

$requiredExts = ['openssl', 'pdo', 'mbstring', 'tokenizer', 'xml', 'ctype', 'json', 'bcmath', 'curl', 'pdo_mysql'];
foreach ($requiredExts as $ext) {
    if (extension_loaded($ext)) {
        echo "Extension $ext: <span class='ok'>Loaded</span><br>";
    } else {
        echo "Extension $ext: <span class='fail'>Missing (Install php-$ext via aaPanel)</span><br>";
    }
}
echo "</div>";

// 2. Storage Directory Check & Auto-Creation
echo "<div class='card'><h2>2. Storage & Cache Folders</h2>";
$paths = [
    $baseDir . '/storage',
    $baseDir . '/storage/app',
    $baseDir . '/storage/app/public',
    $baseDir . '/storage/framework',
    $baseDir . '/storage/framework/cache',
    $baseDir . '/storage/framework/cache/data',
    $baseDir . '/storage/framework/sessions',
    $baseDir . '/storage/framework/views',
    $baseDir . '/storage/logs',
    $baseDir . '/bootstrap/cache',
];

$allWritable = true;
foreach ($paths as $p) {
    if (!file_exists($p)) {
        @mkdir($p, 0775, true);
    }
    $exists = file_exists($p);
    $writable = is_writable($p);
    if (!$writable) {
        $allWritable = false;
    }
    $rel = str_replace($baseDir, '', $p);
    echo "$rel: ";
    if ($exists && $writable) {
        echo "<span class='ok'>Exists & Writable</span><br>";
    } elseif ($exists) {
        echo "<span class='fail'>NOT WRITABLE (Run: chmod -R 775 storage bootstrap/cache)</span><br>";
    } else {
        echo "<span class='fail'>MISSING FOLDER</span><br>";
    }
}
if (!$allWritable) {
    echo "<p class='warn'>Fix in aaPanel Terminal: <br><code>chown -R www:www " . $baseDir . "/storage " . $baseDir . "/bootstrap/cache && chmod -R 775 " . $baseDir . "/storage " . $baseDir . "/bootstrap/cache</code></p>";
}
echo "</div>";

// 3. Environment & Vendor File Checks
echo "<div class='card'><h2>3. Files & Environment</h2>";
$envPath = $baseDir . '/.env';
if (file_exists($envPath)) {
    echo ".env file: <span class='ok'>Found</span><br>";
    $envContent = file_get_contents($envPath);
    if (preg_match('/APP_KEY=(base64:[a-zA-Z0-9+\/=]+|[a-zA-Z0-9]{32})/', $envContent)) {
        echo "APP_KEY: <span class='ok'>Configured</span><br>";
    } else {
        echo "APP_KEY: <span class='fail'>Empty or Missing in .env! Run: php artisan key:generate</span><br>";
    }
} else {
    echo ".env file: <span class='fail'>Missing .env file in project root! Create it from .env.example</span><br>";
}

$vendorPath = $baseDir . '/vendor/autoload.php';
if (file_exists($vendorPath)) {
    echo "vendor/autoload.php: <span class='ok'>Found</span><br>";
} else {
    echo "vendor/autoload.php: <span class='fail'>Missing - You must run: composer install --no-dev</span><br>";
}
echo "</div>";

// 4. Test Full Laravel Bootstrap
echo "<div class='card'><h2>4. Laravel Kernel Bootstrap Test</h2>";
try {
    if (file_exists($vendorPath) && file_exists($baseDir . '/bootstrap/app.php')) {
        require_once $vendorPath;
        $app = require_once $baseDir . '/bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
        $kernel->bootstrap();
        echo "Laravel Framework: <span class='ok'>Bootstrapped Successfully! Version: " . $app->version() . "</span><br>";

        // Test DB connection
        try {
            $pdo = \Illuminate\Support\Facades\DB::connection()->getPdo();
            echo "Database Connection: <span class='ok'>Connected successfully to [" . \Illuminate\Support\Facades\DB::connection()->getDatabaseName() . "]</span><br>";
        } catch (\Throwable $dbe) {
            echo "Database Connection: <span class='fail'>FAILED: " . htmlspecialchars($dbe->getMessage()) . "</span><br>";
        }
    } else {
        echo "<span class='fail'>Cannot bootstrap - missing vendor/autoload.php or bootstrap/app.php</span><br>";
    }
} catch (\Throwable $e) {
    echo "<span class='fail'>Bootstrap Exception: " . htmlspecialchars($e->getMessage()) . "</span><br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
echo "</div>";

echo "<p style='color:#666;font-size:0.8rem;'>CurtissTax Diagnostics. Delete public/diagnose.php once verified.</p>";
echo "</body></html>";
