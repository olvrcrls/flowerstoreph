<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Attribute that the model will use as the database table;
     */
    protected $table = 'order_table';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id', 'user_id', 'quantity', 'price'
    ];

    /** Relationship to User model */
    public function user() {
        return $this->belongsTo(\App\Models\User::class);
    }

    /** Relationship to Product model */
    public function product() {
        return $this->belongsTo(\App\Models\Product::class);
    }

    /**
     * Interact with the order's price.
     * Storing float/decimal on database is heavy and don't do exactly the same thing on all databases
     * @param  string  $value
     */
    protected function setPriceAttribute($value) {
        $this->attributes['price'] = $value * 100;
    }

    /**
     * Interact with the order's price.
     * Storing float/decimal on database is heavy and don't do exactly the same thing on all databases
     * @param  string  $value
     */
    protected function getPriceAttribute($value) {
        return $value / 100;
    }

    protected function getIdAttribute($value) {
        return "ORDER-" . sprintf("%04d", $value);
    }
}
