<?php

namespace Hanafalah\ModuleDisease\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleDisease\Contracts\Data\DiseaseData as DataDiseaseData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class DiseaseData extends Data implements DataDiseaseData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('name')]
    #[MapName('name')]
    public string $name;

    #[MapInputName('flag')]
    #[MapName('flag')]
    public ?string $flag = null;

    #[MapInputName('local_name')]
    #[MapName('local_name')]
    public ?string $local_name = null;

    #[MapInputName('code')]
    #[MapName('code')]
    public ?string $code = null;

    #[MapInputName('version')]
    #[MapName('version')]
    public ?string $version = null;

    #[MapInputName('classification_disease_id')]
    #[MapName('classification_disease_id')]
    public ?string $classification_disease_id = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;

    public static function before(array &$attributes){
        $attributes['flag'] ??= 'Disease';
        $attributes['local_name'] ??= '';
        $attributes['version'] ??= '';
        $attributes['code'] ??= '';
    }
}