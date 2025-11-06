<?php

namespace RiseTechApps\HasUuid\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    protected static function bootHasUuid(): void
    {
        static::creating(function ($model): void {
            $keyName = $model->getKeyName();

            if (empty($model->{$keyName})) {
                // Preferência: UUIDv7 (PHP 8.2+ com Symfony\Uid)
                $model->{$keyName} = static::generateUuid();
            }
        });

        // Garante que o UUID nunca seja alterado
        static::updating(function ($model): void {
            $keyName = $model->getKeyName();
            $model->{$keyName} = $model->getOriginal($keyName);
        });
    }

    protected static function generateUuid(): string
    {
        // Tenta usar UUIDv7 (se disponível)
        if (class_exists(\Symfony\Component\Uid\Uuid::class) && method_exists(\Symfony\Component\Uid\Uuid::class, 'v7')) {
            return \Symfony\Component\Uid\Uuid::v7()->toRfc4122();
        }

        // Fallback: UUID ordenado (tipo v1-like)
        if (method_exists(Str::class, 'orderedUuid')) {
            return (string) Str::orderedUuid();
        }

        // Último fallback: UUID v4 puro
        return (string) Str::uuid();
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
