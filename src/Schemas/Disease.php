<?php

namespace Hanafalah\ModuleDisease\Schemas;

use Hanafalah\ModuleDisease\Contracts\Schemas\Disease as ContractsDisease;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleFunding\Contracts\Data\DiseaseData;

class Disease extends PackageManagement implements ContractsDisease
{
    protected string $__entity   = 'Disease';
    public $disease_model;

    public function prepareStoreDisease(?DiseaseData $disease_dto = null): Model{
        $add = [
            'name'                      => $disease_dto->name, 
            'local_name'                => $disease_dto->local_name, 
            'code'                      => $disease_dto->code, 
            'version'                   => $disease_dto->version, 
            'classification_disease_id' => $disease_dto->classification_disease_id,
        ];

        if (isset($attributes['id'])) {
            $guard = ['id' => $attributes['id']];
            $create = [$guard, $add];
        }else{
            $create = [$add];
        }

        $disease = $this->usingEntity()->updateOrCreate(...$create);
        return $this->disease_model = $disease;
    }
}
