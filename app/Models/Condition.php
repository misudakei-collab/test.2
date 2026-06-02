<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Condition extends Model
{

    protected $fillable = ['id', 'condition'];


    protected $primaryKey = 'id';


    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'condition');
    }
}
