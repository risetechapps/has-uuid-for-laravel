<?php

declare(strict_types=1);

namespace RiseTechApps\HasUuid\Tests\Unit;

use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase;
use ReflectionClass;
use RiseTechApps\HasUuid\Traits\HasUuid;

class UuidGenerationTest extends TestCase
{
    /**
     * @test
     * Verifica que a trait pode ser usada em uma classe de modelo
     */
    public function trait_can_be_applied_to_model(): void
    {
        $model = new class {
            use HasUuid;
        };

        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Model::class,
            $model
        );
    }

    /**
     * @test
     * Verifica que generateUuid retorna uma string válida
     */
    public function generates_valid_uuid_string(): void
    {
        $model = new class extends \Illuminate\Database\Eloquent\Model {
            use HasUuid;
            protected $table = 'test';
        };

        $reflection = new ReflectionClass($model);
        $method = $reflection->getMethod('generateUuid');
        $method->setAccessible(true);

        $uuid = $method->invoke(null);

        $this->assertIsString($uuid);
        $this->assertTrue($this->isValidUuid($uuid));
    }

    /**
     * @test
     * Verifica formato específico do UUID
     */
    public function generated_uuid_follows_rfc4122_format(): void
    {
        $model = new class extends \Illuminate\Database\Eloquent\Model {
            use HasUuid;
            protected $table = 'test';
        };

        $reflection = new ReflectionClass($model);
        $method = $reflection->getMethod('generateUuid');
        $method->setAccessible(true);

        $uuid = $method->invoke(null);

        // RFC 4122 format: 8-4-4-4-12 hex digits
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i',
            $uuid
        );
    }

    /**
     * @test
     * Verifica que UUIDs gerados são únicos
     */
    public function generates_unique_uuids(): void
    {
        $model = new class extends \Illuminate\Database\Eloquent\Model {
            use HasUuid;
            protected $table = 'test';
        };

        $reflection = new ReflectionClass($model);
        $method = $reflection->getMethod('generateUuid');
        $method->setAccessible(true);

        $uuids = [];
        for ($i = 0; $i < 100; $i++) {
            $uuids[] = $method->invoke(null);
        }

        $uniqueUuids = array_unique($uuids);
        $this->assertCount(100, $uniqueUuids);
    }

    /**
     * @test
     * Verifica que UUID v7 (se disponível) gera valores ordenáveis
     */
    public function generates_sortable_uuids_when_symfony_available(): void
    {
        if (!class_exists(\Symfony\Component\Uid\Uuid::class)) {
            $this->markTestSkipped('Symfony UID não está disponível');
        }

        $model = new class extends \Illuminate\Database\Eloquent\Model {
            use HasUuid;
            protected $table = 'test';
        };

        $reflection = new ReflectionClass($model);
        $method = $reflection->getMethod('generateUuid');
        $method->setAccessible(true);

        // Gera UUIDs em sequência e verifica se são ordenáveis
        $uuid1 = $method->invoke(null);
        usleep(1000); // Pequena pausa para garantir timestamp diferente
        $uuid2 = $method->invoke(null);

        // UUIDs v7 são ordenáveis lexicograficamente
        $this->assertLessThan(0, strcmp($uuid1, $uuid2));
    }

    private function isValidUuid(string $uuid): bool
    {
        return (bool) preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $uuid);
    }
}
