<?php

namespace Hanafalah\ModuleDisease\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleDisease\Contracts\Data\ClassificationDiseaseData as DataClassificationDiseaseData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class ClassificationDiseaseData extends Data implements DataClassificationDiseaseData
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