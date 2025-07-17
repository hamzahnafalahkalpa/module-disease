<?php

namespace Hanafalah\ModuleDisease\Models;

class ClassificationDisease extends Disease
{
    protected static function booted(): void
    {
        parent::booted();
        static::addGlobalScope('classification_disease', function ($query) {
            $query->whereNotNull('classification_disease_id');
        });
    }
}
