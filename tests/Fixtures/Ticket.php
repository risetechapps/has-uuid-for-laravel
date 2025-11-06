<?php

namespace RiseTechApps\HasUuid\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use RiseTechApps\HasUuid\Traits\HasUuid;

class Ticket extends Model
{
    use HasUuid;

    protected $guarded = [];

    protected $table = 'tickets';

    protected string $uuidColumn = 'uuid';
}
