<?php

namespace Tests\Unit\Models;

use App\Models\Registration;
use Tests\Unit\GenericModelTestCase;

class RegistrationTest extends GenericModelTestCase
{
    public function testModelConfiguration()
    {
        $this->testConfigurations(
            Registration::class,
            [],
            ['id'],
            [],
            [],
            [
                'id' => 'int',
            ],
            ['created_at', 'updated_at'],
            null,
            'registrations',
            'id'
        );
    }
}
