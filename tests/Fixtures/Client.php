<?php

namespace RiseTechApps\HasUuid\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use RiseTechApps\HasUuid\Traits\HasUuid;

class Client extends Model
{
    use HasUuid;

    protected $guarded = [];

    protected $table = 'clients';
}
