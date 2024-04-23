<?php

namespace Tests\Unit;

use DragonCode\Contracts\Cashier\Resources\Model;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class GenericModelTestCase extends TestCase
{
    protected function testConfigurations(
        $model,
        $fillable = [],
        $guarded = [],
        $visible = [],
        $hidden = [],
        $casts = ['id' => 'int'],
        $dates = ['created_at', 'updated_at'],
        $connection = null,
        $table = null,
        $primaryKey = 'id',
        $collectionClass = Collection::class
    ) {
        if (!($model instanceof Model)) {
            $model = new $model();
        }

        $this->assertEquals($fillable, $model->getFillable());
        $this->assertEquals($guarded, $model->getGuarded());
        $this->assertEquals($visible, $model->getVisible());
        $this->assertEquals($hidden, $model->getHidden());
        $this->assertEquals($casts, $model->getCasts());
        $this->assertEquals($dates, $model->getDates());

        if ($connection !== null) {
            $this->assertEquals($connection, $model->getConnectionName());
        }

        if ($table !== null) {
            $this->assertEquals($table, $model->getTable());
        }

        if ($primaryKey !== null) {
            $this->assertEquals($primaryKey, $model->getKeyName());
        }

        $c = $model->newCollection();
        $this->assertEquals($collectionClass, get_class($c));
        $this->assertInstanceOf(Collection::class, $c);
    }
}
