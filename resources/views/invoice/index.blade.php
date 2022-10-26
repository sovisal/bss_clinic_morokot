<x-app-layout>
	<x-slot name="header">
		<x-form.button href="{{ route('invoice.create') }}" label="Create" icon="bx bx-plus"/>
	</x-slot>
	<x-card :foot="false" :action-show="false">
		<x-slot name="header">
			<form class="w-100" action="{{ route('invoice.index') }}" method="get">
				<x-report-filter />
			</form>
		</x-slot>
		<x-table class="table-hover table-bordered" id="datatables" data-table="patients">
			<x-slot name="thead">
				<tr>
					<th>N<sup>o</sup></th>
					<th>Code</th>
					<th>Date</th>
					<th>Doctor</th>
					<th>Patient</th>
					<th>Code</th>
					<th>Gender</th>
					<th>Age</th>
					<th>Total USD</th>
					<th>Exchange Rate</th>
					<th>Total KHR</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</x-slot>
			@php
				$i = 0;
			@endphp
			@foreach($rows as $row)
				<tr>
					<td class="text-center">{{ ++$i }}</td>
					<td class="text-center">{{ $row->code }}</td>
					<td class="text-center">{{ render_readable_date($row->inv_date) }}</td>
					<td>{{ render_synonyms_name($row->doctor_en, $row->doctor_kh) }}</td>
					<td>{{ render_synonyms_name($row->patient_en, $row->patient_kh) }}</td>
					<td>{{ $row->pt_code }}</td>
					<td class="text-center">{!! getParentDataByType('gender', $row->pt_gender) !!}</td>
					<td class="text-center">{{ $row->pt_age }}</td>
					<th class="text-center">{{ number_format($row->total, 2) }}</th>
					<th class="text-center">{{ number_format($row->exchange_rate, 0) }}</th>
					<th class="text-center">{{ number_format($row->total * $row->exchange_rate, 0) }}</th>
					<td class="text-center">{!! render_record_status($row->status) !!}</td>
					<td class="text-right">
						<x-form.button color="dark" class="btn-sm" onclick="printPopup('{{ route('invoice.print', $row->id) }}')" icon="bx bx-printer" />
						@if ($row->status == 1)
							<x-form.button color="secondary" class="btn-sm" href="{{ route('invoice.edit', $row->id) }}" icon="bx bx-edit-alt" />
							<x-form.button color="danger" class="confirmDelete btn-sm" data-id="{{ $row->id }}" icon="bx bx-trash" />
							<form class="sr-only" id="form-delete-{{ $row->id }}" action="{{ route('invoice.delete', $row->id) }}" method="POST">
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