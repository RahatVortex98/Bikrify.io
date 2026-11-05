<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeBuildItem extends Model
{
    protected $fillable = ['title', 'description', 'url', 'sort'];
}
