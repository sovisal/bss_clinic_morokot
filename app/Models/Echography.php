<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Echography extends BaseModel
{
    use HasFactory;
    protected $guarded = ['id'];
}
