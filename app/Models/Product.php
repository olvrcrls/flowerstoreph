<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    /**
     * Attribute that the model will use as the database table;
     */
    protected $table = 'product_table';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_name', 'product_description', 'quantity', 'price', 'status',
    ];

    /**
     * Interact with the prodcut's name.
     * To make all values stored in database be homogeneous
     * @param  string  $value
     */
    protected function setProductNameAttribute($value) {
        $this->attributes['product_name'] = strtolower($value);
    }

    /**
     * Interact with the product's name.
     * To make all values stored in database be homogeneous
     * @param  string  $value
     */
    protected function getProductNameAttribute($value) {
        return ucwords($value);
    }

    /**
     * Interact with the product's price.
     * Storing float/decimal on database is heavy and don't do exactly the same thing on all databases
     * @param  string  $value
     */
    protected function setPriceAttribute($value) {
        $this->attributes['price'] = $value * 100;
    }

    /**
     * Interact with the product's price.
     * Storing float/decimal on database is heavy and don't do exactly the same thing on all databases
     * @param  string  $value
     */
    protected function getPriceAttribute($value) {  
        return $value / 100;
    }

    public function orders() {
        return $this->hasMany(\App\Models\Order::class);
    }

    protected static function boot() {
        parent::boot();
        Product::saving(function ($model) {
            if ($model->quantity <= 0 && isset($model->quantity)) {
                if (env('APP_ENV') == 'local') {
                    Log::info("Product {$model->product_name} has now 0 quantity. Disabling item automatically.");
                }
                $model->status = false;
            } else if ($model->getOriginal('status') == false && $model->quantity > 0 && isset($model->quantity)) {
                if (env('APP_ENV') == 'local') {
                    Log::info("Disabled product {$model->product_name} has been re-enabled automatically.");
                }
                $model->status = true;
            }
        });
    }

    public function scopeFilter($query, array $filters) {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('product_name', 'like', '%'.$search.'%')
                    ->orWhere('product_description', 'like', '%'.$search.'%');
            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->where('status', true)
                    ->orWhere('status', false);
            } elseif ($trashed === 'only') {
                $query->where('status', false);
            } elseif (is_null($trashed)) {
                $query->where('status', true);
            }
        });
    }

    public function scopeOrderByCreatedAt($query) {
        $query->orderBy('created_at','desc');
    }

    // This will allow route binding on trashed model records if SoftDeletes is implemented
    // public function resolveRouteBinding($value, $field = null) {
    //     return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    // }
}
