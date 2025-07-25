<?php

namespace Hanafalah\ModuleDisease\Contracts\Schemas;

use Hanafalah\ModuleDisease\Contracts\Data\IllnessData;
//use Hanafalah\ModuleDisease\Contracts\Data\IllnessUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleDisease\Schemas\Illness
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateIllness(?IllnessData $illness_dto = null)
 * @method Model prepareUpdateIllness(IllnessData $illness_dto)
 * @method bool deleteIllness()
 * @method bool prepareDeleteIllness(? array $attributes = null)
 * @method mixed getIllness()
 * @method ?Model prepareShowIllness(?Model $model = null, ?array $attributes = null)
 * @method array showIllness(?Model $model = null)
 * @method Collection prepareViewIllnessList()
 * @method array viewIllnessList()
 * @method LengthAwarePaginator prepareViewIllnessPaginate(PaginateData $paginate_dto)
 * @method array viewIllnessPaginate(?PaginateData $paginate_dto = null)
 * @method array storeIllness(?IllnessData $illness_dto = null)
 * @method Collection prepareStoreMultipleIllness(array $datas)
 * @method array storeMultipleIllness(array $datas)
 */

interface Illness extends DataManagement
{
    public function prepareStoreIllness(IllnessData $illness_dto): Model;
}