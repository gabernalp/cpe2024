<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagCategory extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'tag_categories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'comments',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function tagCategoryTags()
    {
        return $this->hasMany(Tag::class, 'tag_category_id', 'id');
    }

    public function tagCategoryResources()
    {
        return $this->belongsToMany(Resource::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
