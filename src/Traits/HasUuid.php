<?php

declare(strict_types=1);

namespace RiseTechApps\HasUuid\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait HasUuid
{
    protected static function bootHasUuid(): void
    {
        static::creating(function ($model): void {
            $keyName = $model->getKeyName();

            if (empty($model->{$keyName})) {
                $model->{$keyName} = static::generateUuid();
            }
        });
    }

    protected static function generateUuid(): string
    {
        if (class_exists(\Symfony\Component\Uid\Uuid::class) && method_exists(\Symfony\Component\Uid\Uuid::class, 'v7')) {
            return \Symfony\Component\Uid\Uuid::v7()->toRfc4122();
        }

        if (method_exists(Str::class, 'orderedUuid')) {
            return (string) Str::orderedUuid();
        }

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

    /**
     * Scope para buscar modelo por UUID.
     *
     * @param Builder $query
     * @param string $uuid
     * @return Builder
     */
    public function scopeByUuid(Builder $query, string $uuid): Builder
    {
        return $query->where($this->getKeyName(), $uuid);
    }

    /**
     * Busca modelo por UUID ou falha.
     *
     * @param string $uuid
     * @return static
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public static function findByUuid(string $uuid): static
    {
        return static::byUuid($uuid)->firstOrFail();
    }

    /**
     * Busca modelo por UUID ou retorna null.
     *
     * @param string $uuid
     * @return static|null
     */
    public static function findByUuidOrNull(string $uuid): ?static
    {
        return static::byUuid($uuid)->first();
    }
}
