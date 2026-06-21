<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentBlock extends Model
{
    protected $fillable = ['page', 'key', 'type', 'value_en', 'value_ar'];
}
