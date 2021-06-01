<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use App\Vendor\Locale\Models\Locale;
use App\Vendor\Locale\Models\LocaleSlugSeo;
use App\Vendor\Image\Models\ImageResized;
use App\Vendor\Product\Models\Product;
use App;

class Shirt extends Model
{

    protected $table = 't_shirts';
    protected $guarded = [];
    protected $with = ['category'];

    public function product()
    {
        return $this->hasOne(Product::class, 'specifications_id');
    }

    public function category()
    {
        return $this->belongsTo(ShirtsCategory::class);
    }

    public function specifications()
    {
        return $this->belongsTo(Shirt::class);
    }

    public function shirts_colours()
    {
        return $this->hasMany(ShirtsColours::class, 'product_id');
    }

    public function shirts_sizes()
    {
        return $this->hasMany(ShirtsSizes::class, 'product_id');
    }


    public function locale()
    {
        return $this->hasMany(Locale::class, 'key')->where('rel_parent', 'shirts')->where('language', App::getLocale());
    }

    public function seo()
    {
        return $this->hasOne(LocaleSlugSeo::class, 'key')->where('rel_parent', 'shirts')->where('language', App::getLocale());
    }

    public function images_featured_preview()
    {
        return $this->hasMany(ImageResized::class, 'entity_id')->where('grid', 'preview')->where('content', 'featured')->where('entity', 'shirts');
    }

    public function image_featured_desktop()
    {
        return $this->hasOne(ImageResized::class, 'entity_id')->where('grid', 'desktop')->where('content', 'featured')->where('entity', 'shirts')->where('language', App::getLocale());
    }

    public function image_featured_mobile()
    {
        return $this->hasOne(ImageResized::class, 'entity_id')->where('grid', 'mobile')->where('content', 'featured')->where('entity', 'shirts')->where('language', App::getLocale());
    }

    public function images_grid_preview()
    {
        return $this->hasMany(ImageResized::class, 'entity_id')->where('grid', 'preview')->where('content', 'grid')->where('entity', 'shirts');
    }

    public function image_grid_desktop()
    {
        return $this->hasMany(ImageResized::class, 'entity_id')->where('grid', 'desktop')->where('content', 'grid')->where('entity', 'shirts')->where('language', App::getLocale());
    }

    public function image_grid_mobile()
    {
        return $this->hasMany(ImageResized::class, 'entity_id')->where('grid', 'mobile')->where('content', 'grid')->where('entity', 'shirts')->where('language', App::getLocale());
    }
}
