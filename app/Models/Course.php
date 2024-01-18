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

class Course extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use Auditable;
    use HasFactory;

    public const TIPO_CICLO_SELECT = [
        '3' => 'Ciclo x3',
        '6' => 'Ciclo x6',
        '0' => 'Otro',
    ];

    public $table = 'courses';

    public static $searchable = [
        'name',
        'goal',
    ];

    protected $appends = [
        'imagen',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'tematica_asociada_id',
        'name',
        'goal',
        'tipo_ciclo',
        'unico',
        'additional_comments',
        'mensaje_cierre',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function courseCourseSchedules()
    {
        return $this->hasMany(CourseSchedule::class);
    }
    
    
    public function courseCourseSchedulesDay()
    {
        $dateNow = date("Y-m-d");
        return $this->hasMany(CourseSchedule::class)->where('course_schedules.start_date','>',$dateNow);
    }

    public function tematica_asociada()
    {
        return $this->belongsTo(BackgroundProcess::class, 'tematica_asociada_id');
    }

    public function getImagenAttribute()
    {
        $file = $this->getMedia('imagen')->last();
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
