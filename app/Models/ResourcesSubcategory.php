<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResourcesSubcategory extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'resources_subcategories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'resourcescategory_id',
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function resourceSubcategoryResources()
    {
        return $this->belongsToMany(Resource::class);
    }

    public function resourcescategory()
    {
        return $this->belongsTo(ResourcesCategory::class, 'resourcescategory_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
