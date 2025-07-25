<?php

namespace Hanafalah\ModuleDisease\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleDisease\Contracts\Data\IllnessData as DataIllnessData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class IllnessData extends Data implements DataIllnessData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('name')]
    #[MapName('name')]
    public string $name;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;
}