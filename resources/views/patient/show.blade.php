<x-app-layout>
	<x-slot name="header">
		<x-form.button href="{{ route('patient.index') }}" color="danger" icon="bx bx-left-arrow-alt" label="Back" />
	</x-slot>

	<x-card :head="false" :foot="false">
		<table class="table-form border-none table-padding-sm">
			<tr>
				<td width="150px" rowspan="4" style="vertical-align: top; padding-left: 1.2rem !important; padding-right: 1.2rem !important;" class="text-center">
					<img src="{{ (($patient->photo)? asset('images/patients/'. $patient->photo) : asset('images/browse-image.jpg') ) }}" alt="..." class="m-auto">
				</td>
				<th width="150px">Patient Code <span class="float-right">:</span></th>
				<td width="20%">PT-{{ str_pad($patient->id, 6, '0', STR_PAD_LEFT) }}</td>
				<th width="150px">Registered <span class="float-right">:</span></th>
				<td>{{ date('d-M-Y H:m', strtotime($patient->registered_at)) }}</td>
				<td width="150px" class="text-center" rowspan="4" style="vertical-align: top;">
					<x-form.button href="{{ route('patient.edit', $patient->id) }}" class="btn-block" icon="bx bx-edit-alt" label="Edit" />
					{{-- <x-form.button href="{{ route('patient.edit', $patient->id) }}" class="btn-block" color="secondary" icon="bx bx-printer" label="Print" /> --}}
				</td>
			</tr>
			<tr>
				<th>Name KH <span class="float-right">:</span></th>
				<td>{{ $patient->name_kh }}</td>
				<th>Name EN <span class="float-right">:</span></th>
				<td>{{ $patient->name_en }}</td>
			</tr>
			<tr>
				<th>Gender <span class="float-right">:</span></th>
				<td>{{ getParentDataByType('gender', $patient->gender) }}</td>
				<th>Phone <span class="float-right">:</span></th>
				<td>{{ $patient->phone }}</td>
			</tr>
			<tr>
				<th>Age <span class="float-right">:</span></th>
				<td>{{ $patient->age }}</td>
				<th>E-mail <span class="float-right">:</span></th>
				<td>{{ $patient->email }}</td>
			</tr>
		</table>
	</x-card>

	
	<ul class="nav nav-tabs mt-3 mb-0" role="tablist">
		<li class="nav-item">
			<a class="nav-link btn-sm active" id="detail-tab" data-toggle="tab" href="#detail" aria-controls="detail" role="tab" aria-selected="true">
				<span class="align-middle">Detail</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link btn-sm" id="history-tab" data-toggle="tab" href="#history" aria-controls="history" role="tab" aria-selected="false">
				<span class="align-middle">History</span>
			</a>
		</li>
	</ul>
	<x-card :foot="false" :head="false">
		<div class="tab-content">
			<div class="tab-pane active" id="detail" aria-labelledby="detail-tab" role="tabpanel">
				<table class="table-form">
					<tr>
						<th colspan="4" class="text-center tw-bg-gray-100">Patient Information</th>
					</tr>
					<tr>
						<th width="200px">ID Card Number <span class="float-right">:</span></th>
						<td>{{ $patient->id_card_no }}</td>
						<th width="200px">Nationality <span class="float-right">:</span></th>
						<td>{{ getParentDataByType('nationality', $patient->nationality) }}</td>
					</tr>
					<tr>
						<th>Date of birth <span class="float-right">:</span></th>
						<td>{{ $patient->date_of_birth ? date('d-M-Y', strtotime($patient->date_of_birth)) : '' }}</td>
						<th>Position <span class="float-right">:</span></th>
						<td>{{ $patient->position }}</td>
					</tr>
					<tr>
						<th>Education <span class="float-right">:</span></th>
						<td>{{ $patient->education }}</td>
						<th>Marital Status <span class="float-right">:</span></th>
						<td>{{ getParentDataByType('marital_status', $patient->marital_status) }}</td>
					</tr>
					<tr>
						<th>Position <span class="float-right">:</span></th>
						<td>{{ $patient->position }}</td>
						<th>Enterprise <span class="float-right">:</span></th>
						<td>{{ $patient->enterprise }}</td>
					</tr>
					<tr>
						<th>Blood Type <span class="float-right">:</span></th>
						<td>{{ getParentDataByType('blood_type', $patient->blood_type) }}</td>
						<td colspan="2"></td>
					</tr>

					<tr>
						<th colspan="4" class="text-center tw-bg-gray-100">Patient Address</th>
					</tr>
					<tr>
						<th>House <span class="float-right">:</span></th>
						<td>{{ $patient->house_no }}</td>
						<th>Street <span class="float-right">:</span></th>
						<td>{{ $patient->street_no }}</td>
					</tr>
					<tr>
						<th>Villsage <span class="float-right">:</span></th>
						<td>{{ $patient->hasAddress ? render_synonyms_name($patient->hasAddress->village_en, $patient->hasAddress->village_kh) : 'N/A' }}</td>
						<th>Commune <span class="float-right">:</span></th>
						<td>{{ $patient->hasAddress ? render_synonyms_name($patient->hasAddress->commune_en, $patient->hasAddress->commune_kh) : 'N/A' }}</td>
					</tr>
					<tr>
						<th>District <span class="float-right">:</span></th>
						<td>{{ $patient->hasAddress ? render_synonyms_name($patient->hasAddress->district_en, $patient->hasAddress->district_kh) : 'N/A' }}</td>
						<th>Province <span class="float-right">:</span></th>
						<td>{{ $patient->hasAddress ? render_synonyms_name($patient->hasAddress->province_en, $patient->hasAddress->province_kh) : 'N/A' }}</td>
					</tr>
					<tr>
						<th>Zip Code <span class="float-right">:</span></th>
						<td>{{ $patient->zip_code }}</td>
						<td colspan="2"></td>
					</tr>
				</table>
			</div>
			<div class="tab-pane" id="history" aria-labelledby="history-tab" role="tabpanel">
				<x-table class="table-hover table-bordered" id="datatables" data-table="patients">
					<x-slot name="thead">
						<tr>
							<th>No</th>
							<th>Code</th>
							<th>Patient</th>
							<th>Requested By</th>
							<th>Requested Date</th>
							<th>Analysis By</th>
							<th>Analysis Date</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</x-slot>
					@foreach($patient->history() as $key => $row)
						<tr>
							<td class="text-center">{{ ++$key }}</td>
							<td>{{ $row->code }}</td>
							<td>{{ render_synonyms_name($row->patient_en, $row->patient_kh) }}</td>
							<td>{{ render_synonyms_name($row->requester_en, $row->requester_kh) }}</td>
							<td class="text-center">{{ render_readable_date($row->requested_at) }}</td>
							<td>{{ render_synonyms_name($row->doctor_en, $row->doctor_kh) }}</td>
							<td class="text-center">{{ render_readable_date($row->analysis_at) }}</td>
							<td class="text-center">{!! render_record_status($row->status) !!}</td>
							<td class="text-center">
								<a href="javascript:void(0);" onclick="previewPopup('{{ $row->url }}')">
									{{ Str::upper($row->row_type) }}
								</a>
							</td>
						</tr>
					@endforeach
				</x-table>
			</div>
		</div>
	</x-card>

</x-app-layout>
