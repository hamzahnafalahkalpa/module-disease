<?php

namespace Hanafalah\ModuleDisease\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;

interface Disease extends DataManagement
{
    public function prepareStoreDisease(?array $attributes = null): Model;
    public function prepareUpdateClassificationDisease(?array $attributes = null): Model;
    public function updateClassificationDisease(): array;
    public function storeDisease(): array;
    public function prepareViewDiseasePaginate(int $perPage = 50, array $columns = ['*'], string $pageName = 'page', ?int $page = null, ?int $total = null): LengthAwarePaginator;
    public function viewDiseasePaginate(int $perPage = 50, array $columns = ['*'], string $pageName = 'page', ?int $page = null, ?int $total = null): array;
    public function disease(mixed $conditionals = null): Builder;
}
