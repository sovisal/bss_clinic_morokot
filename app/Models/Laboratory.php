<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Laboratory extends BaseModel
{
    use HasFactory;
    protected $guarded = ['id'];

    public function detail()
	{
		return $this->hasMany(LaborDetail::class, 'labor_id');
	}
}
