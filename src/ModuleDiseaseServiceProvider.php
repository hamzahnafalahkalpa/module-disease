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
                '*'
            ]);
    }

    protected function dir(): string
    {
        return __DIR__ . '/';
    }
}
