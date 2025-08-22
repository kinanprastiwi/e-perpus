<?php
// test_eperpus.php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle($request = Illuminate\Http\Request::capture());

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

echo "=== E-PERPUS COMPREHENSIVE TEST ===\n\n";

// 1. Test Database Connection
echo "1. Testing Database Connection...\n";
try {
    DB::connection()->getPdo();
    echo "✅ Database connected: " . DB::connection()->getDatabaseName() . "\n";
} catch (\Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    exit;
}

// 2. Check Users Table
echo "\n2. Checking Users Table...\n";
$users = DB::table('users')->get();
echo "Total users: " . $users->count() . "\n";

foreach ($users as $user) {
    echo " - {$user->username} ({$user->email}) - Role: {$user->role}\n";
}

// 3. Test Authentication
echo "\n3. Testing Authentication...\n";
$testCases = [
    ['username' => 'admin', 'password' => 'password123', 'role' => 'admin'],
    ['username' => 'petugas', 'password' => 'password123', 'role' => 'petugas'],
    ['username' => 'anggota', 'password' => 'password123', 'role' => 'anggota']
];

foreach ($testCases as $test) {
    echo "Testing: {$test['username']}/{$test['password']}\n";
    
    $userExists = DB::table('users')
        ->where('username', $test['username'])
        ->orWhere('email', $test['username'])
        ->exists();
    
    if (!$userExists) {
        echo "❌ User not found\n";
        continue;
    }
    
    $success = Auth::attempt([
        'username' => $test['username'], 
        'password' => $test['password']
    ]);
    
    if ($success) {
        $user = Auth::user();
        echo "✅ Login SUCCESS - Role: {$user->role}\n";
        
        // Test role-based access
        if (in_array($user->role, ['admin', 'petugas'])) {
            echo "   Access: ADMIN area\n";
        } else {
            echo "   Access: USER area\n";
        }
        
        Auth::logout();
    } else {
        echo "❌ Login FAILED\n";
        
        // Check password
        $user = DB::table('users')->where('username', $test['username'])->first();
        $passwordValid = password_verify($test['password'], $user->password);
        echo "   Password valid: " . ($passwordValid ? 'YES' : 'NO') . "\n";
        
        if (!$passwordValid) {
            echo "   Resetting password...\n";
            DB::table('users')
                ->where('username', $test['username'])
                ->update(['password' => bcrypt($test['password'])]);
            echo "   Password reset to: {$test['password']}\n";
        }
    }
    echo str_repeat("-", 50) . "\n";
}

// 4. Test Middleware
echo "\n4. Testing Middleware...\n";
$middlewareExists = class_exists('App\Http\Middleware\CheckRole');
echo "CheckRole Middleware: " . ($middlewareExists ? '✅ EXISTS' : '❌ MISSING') . "\n";

if ($middlewareExists) {
    try {
        $middleware = new App\Http\Middleware\CheckRole();
        echo "✅ Middleware instantiated successfully\n";
    } catch (Exception $e) {
        echo "❌ Middleware error: " . $e->getMessage() . "\n";
    }
}

// 5. Test Routes
echo "\n5. Testing Routes...\n";
$routes = [
    '/login',
    '/register', 
    '/admin/dashboard',
    '/user/dashboard',
    '/test-simple'
];

foreach ($routes as $route) {
    try {
        $request = Request::create($route);
        $response = app()->handle($request);
        echo "{$route}: ✅ " . $response->getStatusCode() . "\n";
    } catch (Exception $e) {
        echo "{$route}: ❌ " . $e->getMessage() . "\n";
    }
}

echo "\n=== TEST COMPLETED ===\n";