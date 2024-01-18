<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TechnicalReferrer extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'technical_referrers';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'link',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function technicalReferrersMeetings()
    {
        return $this->belongsToMany(Meeting::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
