<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'profiles';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'entidad_asociada_id',
        'comments',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function entidad_asociada()
    {
        return $this->belongsTo(Entity::class, 'entidad_asociada_id');
    }

    public function coursehooks()
    {
        return $this->belongsToMany(CoursesHook::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
