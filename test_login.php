<?php
// test_login.php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

// Boot the application
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Now we can use Auth and other Laravel features
use Illuminate\Support\Facades\Auth;

echo "=== Testing Login Credentials ===\n\n";

// Test kredensial
$testCredentials = [
    ['username' => 'admin', 'password' => 'password123'],
    ['username' => 'petugas', 'password' => 'password123'],
    ['username' => 'anggota', 'password' => 'password123'],
    ['username' => 'admin@perpustakaan.com', 'password' => 'password123'],
];

foreach ($testCredentials as $cred) {
    echo "Testing: {$cred['username']} / {$cred['password']}\n";
    
    // Coba login dengan username
    if (Auth::attempt(['username' => $cred['username'], 'password' => $cred['password']])) {
        echo "✅ SUCCESS dengan username - Role: " . Auth::user()->role . "\n";
        Auth::logout();
    } 
    // Coba login dengan email
    elseif (Auth::attempt(['email' => $cred['username'], 'password' => $cred['password']])) {
        echo "✅ SUCCESS dengan email - Role: " . Auth::user()->role . "\n";
        Auth::logout();
    } 
    else {
        echo "❌ FAILED\n";
        
        // Check if user exists
        $user = \App\Models\User::where('username', $cred['username'])
                ->orWhere('email', $cred['username'])
                ->first();
        
        if ($user) {
            echo "   User exists but password might be wrong\n";
            echo "   User found: " . $user->username . " (" . $user->email . ")\n";
            
            // Manual password check
            if (password_verify($cred['password'], $user->password)) {
                echo "   ✅ Password verification: MATCH\n";
            } else {
                echo "   ❌ Password verification: NO MATCH\n";
            }
        } else {
            echo "   User not found\n";
        }
    }
    echo "-------------------------\n";
}

// Check user data in database
echo "\n=== Database Check ===\n";
$users = \App\Models\User::all();
foreach ($users as $user) {
    echo "User: {$user->username}, Email: {$user->email}, Role: {$user->role}\n";
    echo "Password hash: {$user->password}\n";
    echo "---\n";
}