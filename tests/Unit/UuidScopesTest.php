<?php

declare(strict_types=1);

namespace RiseTechApps\HasUuid\Tests\Unit;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\Attributes\Test;
use RiseTechApps\HasUuid\Traits\HasUuid;

class UuidScopesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createTestTable();
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
    }

    private function createTestTable(): void
    {
        Schema::create('test_models', function (Blueprint $table): void {
            $table->string('id')->primary();
            $table->string('name');
            $table->timestamps();
        });
    }

    #[Test]
    public function scope_by_uuid_returns_builder_with_uuid_filter(): void
    {
        $model = new class extends Model {
            use HasUuid;

            protected $table = 'test_models';
            protected $fillable = ['name'];
        };

        $customUuid = '550e8400-e29b-41d4-a716-446655440000';

        $query = $model::byUuid($customUuid);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Builder::class, $query);

        $sql = $query->toSql();
        $this->assertStringContainsString('where "id" = ?', $sql);
        $this->assertEquals($customUuid, $query->getBindings()[0]);
    }

    #[Test]
    public function find_by_uuid_returns_model_when_found(): void
    {
        $modelClass = new class extends Model {
            use HasUuid;

            protected $table = 'test_models';
            protected $fillable = ['name'];
        };

        $created = $modelClass::create(['name' => 'Test']);

        $found = $modelClass::findByUuid($created->id);

        $this->assertInstanceOf($modelClass::class, $found);
        $this->assertEquals($created->id, $found->id);
    }

    #[Test]
    public function find_by_uuid_throws_exception_when_not_found(): void
    {
        $modelClass = new class extends Model {
            use HasUuid;

            protected $table = 'test_models';
            protected $fillable = ['name'];
        };

        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $modelClass::findByUuid('non-existent-uuid-1234-123456789abc');
    }

    #[Test]
    public function find_by_uuid_or_null_returns_model_when_found(): void
    {
        $modelClass = new class extends Model {
            use HasUuid;

            protected $table = 'test_models';
            protected $fillable = ['name'];
        };

        $created = $modelClass::create(['name' => 'Test']);

        $found = $modelClass::findByUuidOrNull($created->id);

        $this->assertInstanceOf($modelClass::class, $found);
        $this->assertEquals($created->id, $found->id);
    }

    #[Test]
    public function find_by_uuid_or_null_returns_null_when_not_found(): void
    {
        $modelClass = new class extends Model {
            use HasUuid;

            protected $table = 'test_models';
            protected $fillable = ['name'];
        };

        $found = $modelClass::findByUuidOrNull('non-existent-uuid-1234-123456789abc');

        $this->assertNull($found);
    }
}
