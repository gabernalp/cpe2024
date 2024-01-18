<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResourcesAudit extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Auditable;

    public $table = 'resources_audits';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'recurso_id',
        'ip',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function recurso()
    {
        return $this->belongsTo(Resource::class, 'recurso_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
