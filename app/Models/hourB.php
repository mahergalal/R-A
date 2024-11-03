<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class hourB extends Model
{
    use HasFactory;

    use SoftDeletes;


    protected $fillable = ['name','serial','current','max'];
    protected $dates = ['deleted_at'];
}

