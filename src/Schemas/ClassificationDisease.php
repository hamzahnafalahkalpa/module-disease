<?php

namespace Hanafalah\ModuleDisease\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleDisease\Contracts\Schemas\ClassificationDisease as ContractsClassificationDisease;
use Hanafalah\ModuleDisease\Contracts\Data\ClassificationDiseaseData;

class ClassificationDisease extends Disease implements ContractsClassificationDisease
{
    protected string $__entity = 'ClassificationDisease';
    public static $classification_disease_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'classification_disease',
            'tags'     => ['classification_disease', 'classification_disease-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreClassificationDisease(ClassificationDiseaseData $classification_disease_dto): Model{
        $classification_disease = $this->prepareStoreDisease($classification_disease_dto);
        return static::$classification_disease_model = $classification_disease;
    }

    public function classificationDisease(mixed $conditionals = null): Builder{
        return $this->disease($conditionals);
    }
}