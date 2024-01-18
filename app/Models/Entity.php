<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'entities';

    public static $searchable = [
        'name',
        'initials',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'initials',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function entidadCoursesHooks()
    {
        return $this->hasMany(CoursesHook::class, 'entidad_id', 'id');
    }

    public function entidadAsociadaProfiles()
    {
        return $this->hasMany(Profile::class, 'entidad_asociada_id', 'id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
