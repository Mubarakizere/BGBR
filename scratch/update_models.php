<?php

$dir = __DIR__ . '/../app/Models/';
$files = scandir($dir);

foreach ($files as $file) {
    if (in_array($file, ['.', '..', 'User.php']) || !str_ends_with($file, '.php')) continue;

    $path = $dir . $file;
    $content = file_get_contents($path);

    if (!str_contains($content, 'HasUuids')) {
        $content = str_replace(
            "use Illuminate\Database\Eloquent\Model;",
            "use Illuminate\Database\Eloquent\Model;\nuse Illuminate\Database\Eloquent\Concerns\HasUuids;\nuse App\Models\Scopes\TenantScope;",
            $content
        );
        $content = str_replace(
            "use HasFactory;",
            "use HasFactory, HasUuids;\n\n    protected \$guarded = [];\n\n    protected static function booted(): void\n    {\n        static::addGlobalScope(new TenantScope);\n    }",
            $content
        );

        file_put_contents($path, $content);
        echo "Updated $file\n";
    }
}
