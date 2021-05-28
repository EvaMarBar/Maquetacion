<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use App\Vendor\Locale\Models\LocaleSlugSeo;
use App\Vendor\Image\Models\ImageResized;
use App;

class Product extends Model
{
    protected $table = 't_products';
    protected $guarded = [];
    protected $with = ['category'];

    public function category()
    {
        return $this->belongsTo(ShirtsCategory::class);
    }

    public function specifications()
    {
        return $this->belongsTo(ShirtSpecification::class);
    }

    public function shirts_colours()
    {
        return $this->hasMany(ShirtColours::class, 'colour_id');
    }

    public function locale()
    {
        return $this->hasMany(Locale::class, 'key')->where('rel_parent', 'products')->where('language', App::getLocale());
    }

    public function seo()
    {
        return $this->hasOne(LocaleSlugSeo::class, 'key')->where('rel_parent', 'products')->where('language', App::getLocale());
    }

    public function images_featured_preview()
    {
        return $this->hasMany(ImageResized::class, 'entity_id')->where('grid', 'preview')->where('content', 'featured')->where('entity', 'products');
    }

    public function image_featured_desktop()
    {
        return $this->hasOne(ImageResized::class, 'entity_id')->where('grid', 'desktop')->where('content', 'featured')->where('entity', 'products')->where('language', App::getLocale());
    }

    public function image_featured_mobile()
    {
        return $this->hasOne(ImageResized::class, 'entity_id')->where('grid', 'mobile')->where('content', 'featured')->where('entity', 'products')->where('language', App::getLocale());
    }

    public function images_grid_preview()
    {
        return $this->hasMany(ImageResized::class, 'entity_id')->where('grid', 'preview')->where('content', 'grid')->where('entity', 'products');
    }

    public function image_grid_desktop()
    {
        return $this->hasMany(ImageResized::class, 'entity_id')->where('grid', 'desktop')->where('content', 'grid')->where('entity', 'products')->where('language', App::getLocale());
    }

    public function image_grid_mobile()
    {
        return $this->hasMany(ImageResized::class, 'entity_id')->where('grid', 'mobile')->where('content', 'grid')->where('entity', 'products')->where('language', App::getLocale());
    }
}
