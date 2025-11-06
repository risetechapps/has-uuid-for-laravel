<?php

namespace RiseTechApps\HasUuid\Tests\Fixtures;

class CustomUuidTicket extends Ticket
{
    protected function newUuid(): string
    {
        return 'custom-uuid';
    }
}
