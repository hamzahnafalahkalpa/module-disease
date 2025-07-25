<?php

namespace Hanafalah\ModuleDisease\Models;

use Hanafalah\ModuleDisease\Resources\Disease\ViewDisease;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Disease extends BaseModel
{
    use HasProps, SoftDeletes, HasUlids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    protected $list  = [
        'id', 'name', 'flag','local_name', 'code', 
        'version', 'classification_disease_id', 'props'
    ];
    protected $show  = [];

    protected $casts = [
        'name' => 'string',
        'local_name' => 'string',
        'code' => 'string'
    ];

    protected static function booted():void{
        parent::booted();
        static::creating(function($query){
            $query->flag = (new static)->getMorphClass();
        });
    }

    public function getViewResource(){return ViewDisease::class;}
    public function getShowResource(){return ViewDisease::class;}
    public function classificationDisease(){return $this->belongsToModel('ClassificationDisease');}
}
