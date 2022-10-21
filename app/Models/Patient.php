<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends BaseModel
{
    use HasFactory;
	protected $guarded = ['id'];
	
	public function consultations()
	{
		return $this->hasMany(Consultation::class, 'patient_id');
	}
	public function hasAddress()
	{
		return $this->belongsTo(Address_linkable::class, 'address_id');
	}
	public function address()
	{
		return $this->belongsTo(Address_linkable::class, 'address_id')->first();
	}

	public function history()
	{
		$history = new collection();
		$history = $history->concat($this->prescriptions->map(function($row){
			$row->row_type = 'prescription';
			$row->url = route('prescription.print', $row->id);
			return $row;
		} ));
		$history = $history->concat($this->labors->map(function($row){
			$row->row_type = 'labor';
			$row->url = route('para_clinic.labor.print', $row->id);
			return $row;
		} ));
		$history = $history->concat($this->xrays->map(function($row){
			$row->row_type = 'xray';
			$row->url = route('para_clinic.xray.print', $row->id);
			return $row;
		} ));
		$history = $history->concat($this->echos->map(function($row){
			$row->row_type = 'echo';
			$row->url = route('para_clinic.echography.print', $row->id);
			return $row;
		} ));
		$history = $history->concat($this->ecgs->map(function($row){
			$row->row_type = 'ecg';
			$row->url = route('para_clinic.ecg.print', $row->id);
			return $row;
		} ));
		$history = $history->sortByDesc('requested_at');
		
		return $history;

	}

	public function prescriptions()
	{
		return $this->hasMany(Prescription::class, 'patient_id');
	}

	public function labors()
	{
		return $this->hasMany(Laboratory::class, 'patient_id');
	}

	public function xrays()
	{
		return $this->hasMany(Xray::class, 'patient_id');
	}
	
	public function echos()
	{
		return $this->hasMany(Echography::class, 'patient_id');
	}

	public function ecgs()
	{
		return $this->hasMany(Ecg::class, 'patient_id');
	}
}
