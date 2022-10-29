<x-app-layout>
	<x-slot name="header">
		<x-form.button href="{{ route('invoice.service.create') }}" label="Create" icon="bx bx-plus"/>
	</x-slot>
	<x-card :foot="false" :action-show="false">
		<x-slot name="header"></x-slot>
		<x-table class="table-hover table-bordered" id="datatables" data-table="patients">
			<x-slot name="thead">
				<tr>
					<th>N<sup>o</sup></th>
					<th>Name</th>
					<th>Price</th>
					<th>Description</th>
					<th>Action</th>
				</tr>
			</x-slot>
			@php
				$i = 0;
			@endphp
			@foreach($services as $row)
				<tr>
					<td class="text-center">{{ ++$i }}</td>
					<td>{{ $row->name }}</td>
					<td class="text-center">{{ number_format($row->price, 2) }}</td>
					<td>{{ $row->description }}</td>
					<td class="text-right">
					<x-form.button color="secondary" class="btn-sm" href="{{ route('invoice.service.edit', $row->id) }}" icon="bx bx-edit-alt" />
						<x-form.button color="danger" class="btn-sm" icon="bx bx-trash" disabled/>
					</td>
				</tr>
			@endforeach
		</x-table>
	</x-card>
</x-app-layout>