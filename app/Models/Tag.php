<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'tags';

    public static $searchable = [
        'name',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'tag_category_id',
        'comments',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function tagsResources()
    {
        return $this->belongsToMany(Resource::class);
    }

    public function tag_category()
    {
        return $this->belongsTo(TagCategory::class, 'tag_category_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
