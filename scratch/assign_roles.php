<?php
use App\Models\User;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = User::whereIn('email', ['expiring@example.com', 'expired@example.com', 'pending@example.com', 'active@example.com'])->get();
foreach ($users as $user) {
    $user->assignRole('Member');
    echo "Assigned Member role to {$user->email}\n";
}
