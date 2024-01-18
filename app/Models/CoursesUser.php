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

class CoursesUser extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use Auditable;
    use HasFactory;

    public const ALERT_MESSAGES_SELECT = [
        'email' => 'Correo electrónico',
        'sms'   => 'Mensaje de texto',
    ];

    public const STATUS_SELECT = [
        'Inscrito'    => 'Inscrito',
        'En progreso' => 'En progreso',
        'Finalizado'  => 'Finalizado',
    ];

    public $table = 'courses_users';

    protected $appends = [
        'file',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'course_schedule_id',
        'course_name',
        'whatsapp_user',
        'actual_challenge',
        'alert_messages',
        'manual_feedback',
        'additional_link',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course_schedule()
    {
        return $this->belongsTo(CourseSchedule::class, 'course_schedule_id');
    }

    public function getFileAttribute()
    {
        return $this->getMedia('file')->last();
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
