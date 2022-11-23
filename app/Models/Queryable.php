<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait Queryable
{

    public function scopeQuery(Builder $query)
    {
        return $query;
    }

    public static function getTableColumns()
    {
        $table = (new static)->getTable();
        return DB::getSchemaBuilder()->getColumnListing($table);

        // OR

        return Schema::getColumnListing($table);
    }
}
