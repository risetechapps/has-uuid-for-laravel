<?php

namespace RiseTechApps\HasUuid\Traits\HasUuid;

use Illuminate\Support\Str;

trait HasUuid
{
    protected static function bootHasUuid(){

        static::creating(function ($model) {

            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string)Str::uuid(4);
            }
        });
    }

    public function getIncrementing(): bool
    {
        return false;
    }

    public function getKeyType(): string
    {
        return 'string';
    }
}
