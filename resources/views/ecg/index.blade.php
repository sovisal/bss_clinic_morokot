<x-app-layout>
	<x-slot name="header">
		<x-form.button href="{{ route('para_clinic.ecg.create') }}" label="Create" icon="bx bx-plus"/>
	</x-slot>
	<x-card :foot="false" :action-show="false">
		<x-slot name="header">
			<form class="w-100" action="{{ route('para_clinic.ecg.index') }}" method="get">
				<x-report-filter />
			</form>
		</x-slot>
		<x-table class="table-hover table-bordered" id="datatables" data-table="patients">
			<x-slot name="thead">
				<tr>
					<th>No</th>
					<th>Code</th>
					<th>Patient</th>
					<th>Physician</th>
					<th>Requested Date</th>
					<th>Price</th>
					<th>Form</th>
					<th>Status</th>
					<th>Payment</th>
					<th>Action</th>
				</tr>
			</x-slot>
			@php
				$i = 0;
			@endphp
			@foreach($rows as $row)
				<tr>
					<td class="text-center">{{ ++$i }}</td>
					<td>{{ $row->code }}</td>
					<td>{{ render_synonyms_name($row->patient_en, $row->patient_kh) }}</td>
					<td>{{ render_synonyms_name($row->doctor_en, $row->doctor_kh) }}</td>
					<td class="text-center">{{ render_readable_date($row->requested_at) }}</td>
					<td class="text-right">{{ render_currency($row->amount) }}</td>
					<td>{{ render_synonyms_name($row->type_en, $row->type_kh) }}</td>
					<td class="text-center">{!! render_record_status($row->status) !!}</td>
					<td class="text-center">{!! render_payment_status($row->payment_status) !!}</td>
					<td class="text-right">
						<x-form.button color="info" class="btn-sm" onclick="getDetail({{ $row->id }}, '{{ route('para_clinic.ecg.getDetail', 'ECG Detail') }}')" icon="bx bx-detail" />
						<x-form.button color="dark" class="btn-sm" onclick="printPopup('{{ route('para_clinic.ecg.print', $row->id) }}')" icon="bx bx-printer" />
						@if ($row->status == 1)
							<x-form.button color="secondary" class="btn-sm" href="{{ route('para_clinic.ecg.edit', $row->id) }}" icon="bx bx-edit-alt" />
							<x-form.button color="danger" class="confirmDelete btn-sm" data-id="{{ $row->id }}" icon="bx bx-trash" />
							<form class="sr-only" id="form-delete-{{ $row->id }}" action="{{ route('para_clinic.ecg.delete', $row->id) }}" method="POST">
								@csrf
								@method('DELETE')
								<button class="sr-only" id="btn-{{ $row->id }}">Delete</button>
							</form>
						@else
							<x-form.button color="secondary" class="btn-sm" icon="bx bx-edit-alt" disabled/>
							<x-form.button color="danger" class="btn-sm" icon="bx bx-trash" disabled/>
						@endif
					</td>
				</tr>
			@endforeach
		</x-table>
	</x-card>

	<x-para-clinic.modal-detail />

	<x-modal-confirm-delete />

</x-app-layout>