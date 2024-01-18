<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventsAttendant extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Auditable;

    public const ENTITY_SELECT = [
        'ICBF' => 'ICBF',
        'MEN'  => 'MEN',
        'Otro' => 'Otro',
    ];

    public const DOCUMENTTYPE_SELECT = [
        'CC' => 'Cédula de ciuadadnía',
        'CE' => 'Cédula de Extranjería',
    ];

    public $table = 'events_attendants';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'event_id',
        'name',
        'last_name',
        'documenttype',
        'document',
        'department_id',
        'city_id',
        'entity',
        'phone',
        'email',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function event()
    {
        return $this->belongsTo(EventsSchedule::class, 'event_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}