<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    protected $hidden = [
        'create_at',
        'update_at',
    ];
    function getSlug() {
        return $this->hasOne('App\Models\Slug','id','slug_id');
    }
    function getMedia() {
        return $this->hasOne('App\Model\Media','id','media_id');
    }
}
