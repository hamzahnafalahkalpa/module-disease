<?php

namespace Hanafalah\ModuleDisease\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleDisease\{
    Supports\BaseModuleDisease
};
use Hanafalah\ModuleDisease\Contracts\Schemas\ClassificationDisease as ContractsClassificationDisease;
use Hanafalah\ModuleDisease\Contracts\Data\ClassificationDiseaseData;

class ClassificationDisease extends BaseModuleDisease implements ContractsClassificationDisease
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
        $add = [
            'name' => $classification_disease_dto->name
        ];
        $guard  = ['id' => $classification_disease_dto->id];
        $create = [$guard, $add];
        // if (isset($classification_disease_dto->id)){
        //     $guard  = ['id' => $classification_disease_dto->id];
        //     $create = [$guard, $add];
        // }else{
        //     $create = [$add];
        // }

        $classification_disease = $this->usingEntity()->updateOrCreate(...$create);
        $this->fillingProps($classification_disease,$classification_disease_dto->props);
        $classification_disease->save();
        return static::$classification_disease_model = $classification_disease;
    }
}