<?php

namespace Hanafalah\ModuleDisease\Models;

use Hanafalah\ModuleDisease\Resources\Disease\ViewDisease;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;

class Disease extends BaseModel
{
    use HasProps, SoftDeletes;

    protected $list  = ['id', 'name', 'local_name', 'code', 'version', 'classification_disease_id', 'props'];
    protected $show  = [];

    protected $casts = [
        'name' => 'string',
        'local_name' => 'string',
        'code' => 'string'
    ];

    public function getViewResource()
    {
        return ViewDisease::class;
    }

    public function classificationDisease()
    {
        return $this->belongsToModel('ClassificationDisease');
    }
}
