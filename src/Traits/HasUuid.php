<?php

namespace RiseTechApps\HasUuid\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasUuid
{
    public function initializeHasUuid(): void
    {
        if ($this->uuidColumnIsPrimaryKey()) {
            $this->setIncrementing(false);
            $this->setKeyType('string');
        }
    }

    protected static function bootHasUuid(): void
    {
        static::creating(function (Model $model): void {
            $column = $model->getUuidColumn();

            if (! $model->getAttribute($column)) {
                $model->setAttribute($column, (string) $model->newUuid());
            }
        });
    }

    protected function newUuid(): string
    {
        return (string) Str::uuid();
    }

    protected function getUuidColumn(): string
    {
        if (property_exists($this, 'uuidColumn') && isset($this->uuidColumn) && $this->uuidColumn !== '') {
            return $this->uuidColumn;
        }

        return $this->getKeyName();
    }

    protected function uuidColumnIsPrimaryKey(): bool
    {
        return $this->getUuidColumn() === $this->getKeyName();
    }
}
