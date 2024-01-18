<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Resource extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use Auditable;
    use HasFactory;

    public $table = 'resources';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'imagen_archivo',
        'file',
        'image_pdf',
        'manual',
        'image_manual',
    ];

    protected $fillable = [
        'name',
        'resourcescategory_id',
        'link',
        'comments',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function resourcescategory()
    {
        return $this->belongsTo(ResourcesCategory::class, 'resourcescategory_id');
    }

    public function resource_subcategories()
    {
        return $this->belongsToMany(ResourcesSubcategory::class);
    }

    public function getImagenArchivoAttribute()
    {
        $file = $this->getMedia('imagen_archivo')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getFileAttribute()
    {
        return $this->getMedia('file')->last();
    }

    public function getImagePdfAttribute()
    {
        $file = $this->getMedia('image_pdf')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function tag_categories()
    {
        return $this->belongsToMany(TagCategory::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getManualAttribute()
    {
        return $this->getMedia('manual')->last();
    }

    public function getImageManualAttribute()
    {
        $file = $this->getMedia('image_manual')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
