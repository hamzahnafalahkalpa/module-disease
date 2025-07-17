<?php

namespace Hanafalah\ModuleDisease;

use Hanafalah\LaravelSupport\Providers\BaseServiceProvider;

class ModuleDiseaseServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->registerMainClass(ModuleDisease::class)
            ->registerCommandService(Providers\CommandServiceProvider::class)
            ->registers([
                '*',
                'Services'  => function () {
                    $this->binds([
                        Contracts\ModuleDisease::class     => ModuleDisease::class,
                        Contracts\Disease::class => Schemas\Disease::class
                    ]);
                }
            ]);
    }

    protected function dir(): string
    {
        return __DIR__ . '/';
    }

    protected function migrationPath(string $path = ''): string
    {
        return database_path($path);
    }
}
