<?php

declare(strict_types=1);

namespace RiseTechApps\HasUuid\Tests\Unit;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\Attributes\Test;
use RiseTechApps\HasUuid\Traits\HasUuid;

class HasUuidTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->createTestTable();
    }

    protected function getPackageProviders($app): array
    {
        return [];
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

    protected function getTestModelClass(): string
    {
        static $class = null;

        if ($class === null) {
            $class = get_class(new class extends Model {
                use HasUuid;

                protected $table = 'test_models';
                protected $keyType = 'string';
                public $incrementing = false;
                protected $fillable = ['name'];
            });
        }

        return $class;
    }

    #[Test]
    public function it_generates_uuid_on_create(): void
    {
        $modelClass = $this->getTestModelClass();

        $model = $modelClass::create(['name' => 'Test']);

        $this->assertNotNull($model->id);
        $this->assertIsString($model->id);
        $this->assertTrue($this->isValidUuid($model->id));
    }

    #[Test]
    public function it_preserves_provided_uuid(): void
    {
        $modelClass = $this->getTestModelClass();
        $customUuid = '550e8400-e29b-41d4-a716-446655440000';

        $model = $modelClass::create([
            'id' => $customUuid,
            'name' => 'Test',
        ]);

        $this->assertEquals($customUuid, $model->id);
    }

    #[Test]
    public function it_sets_key_type_to_string(): void
    {
        $modelClass = $this->getTestModelClass();
        $model = new $modelClass();

        $this->assertEquals('string', $model->getKeyType());
    }

    #[Test]
    public function it_disables_incrementing(): void
    {
        $modelClass = $this->getTestModelClass();
        $model = new $modelClass();

        $this->assertFalse($model->getIncrementing());
    }

    #[Test]
    public function it_generates_unique_uuids_for_each_model(): void
    {
        $modelClass = $this->getTestModelClass();

        $model1 = $modelClass::create(['name' => 'First']);
        $model2 = $modelClass::create(['name' => 'Second']);

        $this->assertNotEquals($model1->id, $model2->id);
        $this->assertTrue($this->isValidUuid($model1->id));
        $this->assertTrue($this->isValidUuid($model2->id));
    }

    #[Test]
    public function it_allows_finding_by_uuid(): void
    {
        $modelClass = $this->getTestModelClass();
        $created = $modelClass::create(['name' => 'Test']);

        $found = $modelClass::find($created->id);

        $this->assertNotNull($found);
        $this->assertEquals($created->id, $found->id);
    }

    private function isValidUuid(string $uuid): bool
    {
        return (bool) preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $uuid);
    }
}
