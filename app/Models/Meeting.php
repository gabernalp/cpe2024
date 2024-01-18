<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Meeting extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use Auditable;
    use HasFactory;

    public const METHODOLOGY_SELECT = [
        'Foro'         => 'Foro abierto',
        'Charla'       => 'Charla',
        'Presentación' => 'Presentación',
    ];

    public const MEETING_TERM_SELECT = [
        '30'  => '30 minutos',
        '45'  => '45 minutos',
        '60'  => '1 hora',
        '90'  => '1:30 horas',
        '120' => '2 horas',
    ];

    public $table = 'meetings';

    protected $appends = [
        'file',
    ];

    protected $dates = [
        'date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'date',
        'time',
        'meeting_term',
        'methodology',
        'teachers_network',
        'otro_referente',
        'link',
        'observaciones',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function meetingMeetingAttendants()
    {
        return $this->hasMany(MeetingAttendant::class, 'meeting_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function technical_referrers()
    {
        return $this->belongsToMany(TechnicalReferrer::class);
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
