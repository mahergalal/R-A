<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DAteB extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name','serial','start','max'];
    protected $dates = ['deleted_at'];
}