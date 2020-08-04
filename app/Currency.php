<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class Currency extends Model
{
    use InsertOnDuplicateKey;
    protected $table = 'currencies';

    public $timestamps = false;

    protected $fillable = ['name', 'rate', 'date'];

    protected $likeFilterFields = ['name', 'date'];

    /**
     * add filtering.
     *
     * @param  $builder: query builder.
     * @param  $filters: array of filters.
     * @return query builder.
     */
    public function scopeFilter($builder, $filters = []) {
        if(!$filters) {
            return $builder;
        }

        $date = Carbon::now()->format('Y-m-d');
        if (isset($filters['date'])) {
            $date = Carbon::parse($filters['date'])->format('Y-m-d');
        }
        if(isset($filters['name'])) {
            $builder->where('name', $filters['name']);
        }

        $builder->where('date', $date);

        return $builder;
    }
}
