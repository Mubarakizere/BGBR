<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = App\Models\User::whereDoesntHave('member')->get();
$count = 0;
foreach ($users as $u) {
    if (!$u->hasRole('Super Admin')) {
        App\Models\Member::create(['name' => $u->name, 'rank' => 'Member', 'user_id' => $u->id]);
        echo "Created member for " . $u->email . "\n";
        $count++;
    }
}
echo "Created $count member profiles for existing users.\n";
