<?php

namespace Hanafalah\ModuleDisease\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleFunding\Contracts\Data\DiseaseData;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleDisease\Schemas\Disease
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method mixed export(string $type)
 * @method bool deleteDisease()
 * @method bool prepareDeleteDisease(? array $attributes = null)
 * @method mixed getDisease()
 * @method ?Model prepareShowDisease(?Model $model = null, ?array $attributes = null)
 * @method array showDisease(?Model $model = null)
 * @method Collection prepareViewDiseaseList()
 * @method array viewDiseaseList()
 * @method LengthAwarePaginator prepareViewDiseasePaginate(PaginateData $paginate_dto)
 * @method array viewDiseasePaginate(?PaginateData $paginate_dto = null)
 * @method array storeDisease(?DiseaseData $disease_dto = null)
 */
interface Disease extends DataManagement{
    public function prepareStoreDisease(?DiseaseData $disease_dto = null): Model;
}
