<?php
// app/Models/WebsiteProduct.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'features',
        'monthly_price', 'yearly_price', 'icon',
        'color', 'is_featured', 'is_active', 'sort_order'
    ];

    protected $casts = [
        'monthly_price' => 'decimal:2',
        'yearly_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getFeaturesArrayAttribute()
    {
        return $this->features ? json_decode($this->features, true) : [];
    }

    public function getYearlySavingsAttribute()
    {
        if ($this->yearly_price) {
            return ($this->monthly_price * 12) - $this->yearly_price;
        }
        return 0;
    }
}