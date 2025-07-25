<?php

namespace Hanafalah\ModuleDisease\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleDisease\{
    Supports\BaseModuleDisease
};
use Hanafalah\ModuleDisease\Contracts\Schemas\Illness as ContractsIllness;
use Hanafalah\ModuleDisease\Contracts\Data\IllnessData;

class Illness extends BaseModuleDisease implements ContractsIllness
{
    protected string $__entity = 'Illness';
    public static $illness_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'illness',
            'tags'     => ['illness', 'illness-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreIllness(IllnessData $illness_dto): Model{
        $add = [
            'name' => $illness_dto->name
        ];
        $guard  = ['id' => $illness_dto->id];
        $create = [$guard, $add];
        // if (isset($illness_dto->id)){
        //     $guard  = ['id' => $illness_dto->id];
        //     $create = [$guard, $add];
        // }else{
        //     $create = [$add];
        // }

        $illness = $this->usingEntity()->updateOrCreate(...$create);
        $this->fillingProps($illness,$illness_dto->props);
        $illness->save();
        return static::$illness_model = $illness;
    }
}