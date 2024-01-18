<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use \DateTimeInterface;
use App\Notifications\VerifyUserNotification;
use App\Traits\Auditable;
use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use SoftDeletes;
    use Notifiable;
    use InteractsWithMedia;
    use Auditable;
    use HasFactory;

    public const GENDER_SELECT = [
        'Masculino' => 'Masculino',
        'Femenino'  => 'Femenino',
        'Transgenero/Trans'     => 'Transgénero/Trans',
        'Otro'     => 'Otro',
        'NR'     => 'NR',

    ];

    public const PLACE_ROLE_SELECT = [
        'ICBF'    => 'Unidad de Servicio del ICBF',
        'IED'     => 'Institución Educativa',
        'EXTERNO' => 'Otro',
    ];

    public const ETNIA_SELECT = [
        'Afrocolombiano' => 'Afrocolombiano',
        'Indígena'       => 'Indígena',
        'Raizal'         => 'Raizal',
        'Rrom gitano'    => 'Rrom gitano',
        'Otro ND'        => 'Otro ND',
    ];

    public const ACADEMIC_BACKGROUND_SELECT = [
        'Primaria'                 => 'Primaria',
        'Secundaria'               => 'Secundaria',
        'Técnico/Tecnólogo'        => 'Técnico/Tecnólogo',
        'Profesional'              => 'Profesional',
        'Especialización/Maestría' => 'Especialización/Maestría',
        'Doctorado'                => 'Doctorado',
        'Pos-doctorado'            => 'Pos-doctorado',
    ];

    public $table = 'users';

    public static $searchable = [
        'document',
    ];

    protected $appends = [
        'profile_pic',
    ];

    protected $hidden = [
        'remember_token',
        'password',
    ];

    protected $dates = [
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'documenttype_id',
        'document',
        'name',
        'gender',
        'email',
        'phone',
        'department_id',
        'city_id',
        'etnia',
        'academic_background',
        'place_role',
        'profile_id',
        'email_verified_at',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::created(function (User $user) {
            $registrationRole = config('panel.registration_default_role');
            if (!$user->roles()->get()->contains($registrationRole)) {
                $user->roles()->attach($registrationRole);
            }
        });
    }

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function userCoursesUsers()
    {
        return $this->hasMany(CoursesUser::class, 'user_id', 'id');
    }

    public function userChallengesUsers()
    {
        return $this->hasMany(ChallengesUser::class, 'user_id', 'id');
    }

    public function userMeetings()
    {
        return $this->hasMany(Meeting::class, 'user_id', 'id');
    }

    public function userCourseSchedules()
    {
        return $this->hasMany(CourseSchedule::class, 'user_id', 'id');
    }

    public function userUserFavResources()
    {
        return $this->hasMany(UserFavResource::class, 'user_id', 'id');
    }

    public function userUserAlerts()
    {
        return $this->belongsToMany(UserAlert::class);
    }

    public function documenttype()
    {
        return $this->belongsTo(DocumentType::class, 'documenttype_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function devices()
    {
        return $this->belongsToMany(Device::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    public function getProfilePicAttribute()
    {
        $file = $this->getMedia('profile_pic')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
	
	public function hasRole($role)
    {
        if ($this->roles()->where('title', $role)->first()) {
            return true;
        }
        // else
        return false;
    }
}
