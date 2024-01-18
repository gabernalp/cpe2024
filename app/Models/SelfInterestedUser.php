<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SelfInterestedUser extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Auditable;

    public const EDUCATION_BACKGROUND_RADIO = [
        'Si' => 'Si',
        'No' => 'No',
    ];

    public const LIVING_ZONE_SELECT = [
        'Rural'  => 'Rural',
        'Urbana' => 'Urbana',
    ];

    public const MODALITY_SELECT = [
        'Institucional'          => 'Institucional',
        'Familiar'               => 'Familiar',
        'Comunitaria'            => 'Comunitaria',
        'Propia e intercultural' => 'Propia e intercultural',
        'Otra no determinada'    => 'Otra no determinada',
    ];

    public $table = 'self_interested_users';

    protected $dates = [
        'document_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'profile_id',
        'name',
        'lastname',
        'email',
        'documenttype_id',
        'document',
        'document_date',
        'phone',
        'education_background',
        'modality',
        'department_id',
        'city_id',
        'living_zone',
        'contacted',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    public function documenttype()
    {
        return $this->belongsTo(DocumentType::class, 'documenttype_id');
    }

    public function getDocumentDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDocumentDateAttribute($value)
    {
        $this->attributes['document_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function courseshooks()
    {
        return $this->belongsToMany(CoursesHook::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
