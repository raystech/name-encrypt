<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['name_raw', 'name_enc', 'type', 'dept', 'dir'];
    protected $dates = ['deleted_at'];
}
