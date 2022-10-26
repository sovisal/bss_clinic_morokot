<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends BaseModel
{
    use HasFactory;
    protected $guarded = ['id'];

    public function detail()
	{
		return $this->hasMany(InvoiceDetail::class, 'invoice_id');
	}
}
