<?php

namespace App\Models;

use App\Http\Filters\CountryFilter;
use App\Http\Filters\Filterable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Country extends Model implements HasMedia, TranslatableContract
{
    use HasFactory, InteractsWithMedia, Translatable,Filterable;

    public $translatedAttributes = ['name'];
    protected $fillable = ['code'];
    public const MEDIA_COLLECTION_NAME = 'country_avatar';
    public const MEDIA_COLLECTION_URL = 'images/country.png';

    protected $filter= CountryFilter::class;
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function getAvatar()
    {
        return $this->getFirstMediaUrl('country_avatar');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MEDIA_COLLECTION_NAME)
            ->useFallbackUrl(asset(self::MEDIA_COLLECTION_URL))
            ->useFallbackPath(asset(self::MEDIA_COLLECTION_URL));
    }
}
