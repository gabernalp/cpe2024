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

class Challenge extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use Auditable;
    use HasFactory;

    public const CHALLENGE_ACTION_SELECT = [
        'Leer'        => 'Leer',
        'Reflexionar' => 'Reflexionar',
        'Observar'    => 'Observar',
        'Investigar'  => 'Investigar',
        'Crear'       => 'Crear',
        'Compartir'   => 'Compartir',
        'Escribir'    => 'Escribir',
        'Pintar'      => 'Pintar',
        'Cantar'      => 'Cantar',
        'Contar'      => 'Contar',
    ];

    public $table = 'challenges';

    public static $searchable = [
        'name',
        'goal',
    ];

    protected $appends = [
        'capsule_file',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'course_id',
        'name',
        'goal',
        'referencetype_capsule_id',
        'capsule_content',
        'challenge_action',
        'action_detail',
        'referencetype_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function challengeChallengesUsers()
    {
        return $this->hasMany(ChallengesUser::class, 'challenge_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function referencetype_capsule()
    {
        return $this->belongsTo(ReferenceType::class, 'referencetype_capsule_id');
    }

    public function getCapsuleFileAttribute()
    {
        return $this->getMedia('capsule_file')->last();
    }

    public function referencetype()
    {
        return $this->belongsTo(ReferenceType::class, 'referencetype_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
