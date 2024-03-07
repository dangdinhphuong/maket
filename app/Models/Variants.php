<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Variants extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'variants';
    protected $fillable = ['user_id', 'name', 'type', 'slug'];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->Where('name', 'LIKE', '%' . $search . '%');
        });
    }
}
