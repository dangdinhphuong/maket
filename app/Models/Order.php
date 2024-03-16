<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'status',
        'address',
        'phone',
        'fullname',
        'note',
        'users_id',
        'payment_method'
    ];

    public function order_detail()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
           $query->Where('name', 'LIKE', '%' . $search . '%');
        });
        $query->when($filters['status'] ?? false, function ($query, $status) {
            $query->where('status', $status);
        });
    }
}
