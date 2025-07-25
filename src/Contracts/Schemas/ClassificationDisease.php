<?php

namespace Hanafalah\ModuleDisease\Contracts\Schemas;

use Hanafalah\ModuleDisease\Contracts\Data\ClassificationDiseaseData;
//use Hanafalah\ModuleDisease\Contracts\Data\ClassificationDiseaseUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleDisease\Schemas\ClassificationDisease
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateClassificationDisease(?ClassificationDiseaseData $classification_disease_dto = null)
 * @method Model prepareUpdateClassificationDisease(ClassificationDiseaseData $classification_disease_dto)
 * @method bool deleteClassificationDisease()
 * @method bool prepareDeleteClassificationDisease(? array $attributes = null)
 * @method mixed getClassificationDisease()
 * @method ?Model prepareShowClassificationDisease(?Model $model = null, ?array $attributes = null)
 * @method array showClassificationDisease(?Model $model = null)
 * @method Collection prepareViewClassificationDiseaseList()
 * @method array viewClassificationDiseaseList()
 * @method LengthAwarePaginator prepareViewClassificationDiseasePaginate(PaginateData $paginate_dto)
 * @method array viewClassificationDiseasePaginate(?PaginateData $paginate_dto = null)
 * @method array storeClassificationDisease(?ClassificationDiseaseData $classification_disease_dto = null)
 * @method Collection prepareStoreMultipleClassificationDisease(array $datas)
 * @method array storeMultipleClassificationDisease(array $datas)
 */

interface ClassificationDisease extends DataManagement
{
    public function prepareStoreClassificationDisease(ClassificationDiseaseData $classification_disease_dto): Model;
}