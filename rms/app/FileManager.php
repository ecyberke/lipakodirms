<?php

namespace App;

use App\FileManager;
use Illuminate\Database\Eloquent\Model;

class FileManager extends Model
{
    protected $guarded = [];

    protected $table = 'filemanager';
}
