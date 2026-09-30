<?php

use Illuminate\Database\Capsule\Manager;

$capsule = new Manager();
$config = config('database');

// Add the default connection first
$defaultConnection = $config['default'] ?? 'mysql';
if (isset($config['connections'][$defaultConnection])) {
    $capsule->addConnection($config['connections'][$defaultConnection], $defaultConnection);
    // Also add as 'default' alias for seed/migrate commands
    $capsule->addConnection($config['connections'][$defaultConnection], 'default');
    $capsule->getDatabaseManager()->setDefaultConnection('default');
}

// Add other connections
foreach ($config['connections'] as $key => $value) {
    if ($key !== $defaultConnection) {
        $capsule->addConnection($value, $key);
    }
}

// Set the capsule as global and boot Eloquent to ensure Model::getConnectionResolver() works
$capsule->setAsGlobal();
$capsule->bootEloquent();

return [
    'enable' => true,
    'default_environment' => 'development',
    'paths' => [
        "migrations" => "database/migrations",
        "seeds"      => "database/seeders"
    ],
    'migration_table' => 'migrations',
    'db' => $capsule->getDatabaseManager()
];
