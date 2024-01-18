<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'products';
    protected $fillable = [
        'namePro',
        'image',
        'slug',
        'quantity',
        'price',
        'discounts',
        'Description',
        'status',
        'category_id',
        'supplier_id',
        'users_id',
        'origin_id',
        'cost'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function origin()
    {
        return $this->belongsTo(Origin::class, 'origin_id');
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function sale()
    {
        return $this->hasMany(Sale::class, 'sale_id');
    }
    public function User()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function scopeFilter($query, array $filters)
    {
        // lọc cho người dùng
        $query->when($filters['categories_slug'] ?? false, function ($query, $categories_slug) {
            $query->where('category_id', $categories_slug->id);
        });
        $query->when($filters['min'] ?? false, function ($query, $min) {
            //    lọc sản phẩm có giá tối thiểu
            $query->where('price', '>=', $min);
        });
        $query->when($filters['max'] ?? false, function ($query, $max) {
            //  lọc sản phẩm có giá tối đa
            $query->where('price', '<=', $max);
        });
        $query->when($filters['sort'] ?? false, function ($query, $sort) {
            //  lọc sản phẩm có giá tối đa
            if ($sort == 'ASC' || $sort == "DESC") {
                $query->orderBy('price', $sort);
            }
        });


        // lọc cho admin
        $query->when($filters['category_id'] ?? false, function ($query, $category_id) {
            $query->where('category_id', $category_id);
        });
        $query->when($filters['supplier_id'] ?? false, function ($query, $supplier_id) {
            $query->where('supplier_id', $supplier_id);
        });
        $query->when($filters['origin_id'] ?? false, function ($query, $origin_id) {
            $query->where('origin_id', $origin_id);
        });
        $query->when($filters['status'] ?? false, function ($query, $status) {
            if ($status == 2 || $status == 1) {
                $status = $status == 2 ? 0 : 1;
                $query->where('status', $status);
            }
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->Where('namePro', 'LIKE', '%' . $search . '%');
        });
    }
}
