<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AboutUs extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'about_us';

    protected $fillable = [
        'title',
        'description',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('img')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(200)
            ->performOnCollections('img');
    }

    public function getImgUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('img') ?: null;
    }

    public function getImgThumbUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('img', 'thumb') ?: null;
    }
}
