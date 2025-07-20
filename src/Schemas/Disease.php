<?php

namespace Hanafalah\ModuleDisease\Schemas;

use Hanafalah\ModuleDisease\Contracts\Disease as ContractsDisease;
use Hanafalah\ModuleDisease\Resources\Disease\ViewDisease;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Hanafalah\LaravelSupport\Supports\PackageManagement;

class Disease extends PackageManagement implements ContractsDisease
{
    protected array $__guard     = ['name'];
    protected array $__add       = ['code', 'version', 'classification_disease_id', 'props'];
    protected string $__entity   = 'Disease';
    public $disease_model;

    protected array $__resources = [
        'view' => ViewDisease::class,
    ];

    protected array $__schema_contracts = [];

    public function prepareUpdateClassificationDisease(?array $attributes = null): Model
    {
        $attributes ??= request()->all();
        if (!isset($attributes['id'])) throw new \Exception('id is required', 422);
        if (!isset($attributes['classification_disease_id'])) throw new \Exception('classification_disease_id is required', 422);

        $current_dissease = $this->DiseaseModel()->find($attributes['id']);
        $classification = $this->DiseaseModel()->find($attributes['classification_disease_id']);
        if (isset($attributes['classification_disease_id']) && !isset($classification)) throw new \Exception('classification_disease_id not found', 422);

        $disease = $this->disease()->updateOrCreate([
            'id'   => $attributes['id'] ?? null,
        ], [
            'classification_disease_id' => $attributes['classification_disease_id']
        ]);

        return $this->disease_model = $disease;
    }

    public function prepareStoreDisease(?array $attributes = null): Model
    {
        $attributes ??= request()->all();
        if (!isset($attributes['name'])) throw new \Exception('name is required', 422);

        if (isset($attributes['id'])) {
            $current_dissease = $this->DiseaseModel()->find($attributes['id']);
            $id               = $current_dissease->getKey();
            $current_name     = $current_dissease->name;
            $current_code     = $current_dissease->code;
        }

        if (isset($attributes['classification_disease_id'])) {
            $classification = $this->DiseaseModel()->find($attributes['classification_disease_id']);
            $current_classification_name = $classification->name;
        }

        $name = $current_classification_name ?? $attributes['name'];
        $disease = $this->disease()->firstOrCreate([
            'name'                      => $current_name ?? $attributes['name'],
            'code'                      => $current_code ?? $attributes['code'] ?? ''
        ], [
            'code'                      => $attributes['code'] ?? '',
            'name'                      => $name,
            'local_name'                => $this->translate($name),
            'version'                   => $attributes['version'] ?? null,
            'classification_disease_id' => $attributes['classification_disease_id'] ?? null
        ]);

        return $this->disease_model = $disease;
    }

    public function updateClassificationDisease(): array
    {
        return $this->transaction($this->__resources['view'], function () {
            return $this->prepareUpdateClassificationDisease();
        });
    }

    public function storeDisease(): array
    {
        return $this->transaction($this->__resources['view'], function () {
            return $this->prepareStoreDisease();
        });
    }

    public function prepareViewDiseasePaginate(int $perPage = 50, array $columns = ['*'], string $pageName = 'page', ?int $page = null, ?int $total = null): LengthAwarePaginator
    {
        $paginate_options = compact('perPage', 'columns', 'pageName', 'page', 'total');
        return $this->disease_model = $this->disease()->paginate($perPage);
    }

    public function viewDiseasePaginate(int $perPage = 50, array $columns = ['*'], string $pageName = 'page', ?int $page = null, ?int $total = null): array
    {
        $paginate_options = compact('perPage', 'columns', 'pageName', 'page', 'total');
        return $this->transforming($this->__resources['view'], function () use ($paginate_options) {
            return $this->prepareViewDiseasePaginate(...$this->arrayValues($paginate_options));
        });
    }

    public function disease(mixed $conditionals = null): Builder
    {
        $this->booting();
        if (isset(request()->disease)) {
            request()->merge([
                'search_name'    => request()->disease,
                'search_code'    => request()->disease,
                'search_disease' => null
            ]);
        }

        return $this->DiseaseModel()->withParameters('or')
            ->conditionals($conditionals)
            ->when(isset(request()->type), function ($query) {
                $type = request()->type;
                switch ($type) {
                    case 'classification':
                        $query->whereNotNull('classification_disease_id');
                        break;
                    case 'icd':
                        $query->whereNotNull('code');
                        break;
                }
            })->orderBy('code', 'desc')->orderBy('name', 'desc');
    }
}
