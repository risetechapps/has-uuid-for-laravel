<?php

namespace RiseTechApps\HasUuid\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase;
use RiseTechApps\HasUuid\Tests\Fixtures\Client;

class HasUuidTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::dropAllTables();

        Schema::create('clients', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('name')->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropAllTables();

        parent::tearDown();
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    public function test_initializes_model_with_uuid_key_configuration(): void
    {
        $client = new Client();

        $this->assertFalse($client->getIncrementing());
        $this->assertSame('string', $client->getKeyType());
    }

    public function test_generates_uuid_when_creating_model(): void
    {
        $client = Client::create(['name' => 'Rise Tech']);

        $this->assertNotNull($client->getKey());
        $this->assertTrue(Str::isUuid($client->getKey()));
    }

    public function test_respects_manually_defined_primary_key(): void
    {
        $customId = (string) Str::uuid();

        $client = Client::create([
            'id' => $customId,
            'name' => 'Manual',
        ]);

        $this->assertSame($customId, $client->getKey());
    }
}
