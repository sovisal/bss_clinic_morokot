<x-app-layout>
	<x-slot name="header">
		<x-form.button href="{{ route('invoice.service.index') }}" color="danger" icon="bx bx-left-arrow-alt" label="Back" />
	</x-slot>
	<form action="{{ route('invoice.service.update', $row->id) }}" method="POST" autocomplete="off">
		@method('PUT')
		@csrf
		<x-card bodyClass="pb-0">
			<table class="table-form striped">
				<tr>
					<th colspan="4" class="text-left tw-bg-gray-100">Service Information</th>
				</tr>
				<tr>
					<td width="20%" class="text-right">Name <small class='required'>*</small></td>
					<td width="30%">
						<x-bss-form.input name="name" value="{{ old('name', $row->name) }}" required autofocus />
					</td>
					<td width="20%" class="text-right">Price <small class='required'>*</small></td>
					<td width="30%">
						<x-bss-form.input name="price" class="is_number" value="{{ old('price', $row->price) }}" />
					</td>
				</tr>
				<tr>
					<td class="text-right">Description</td>
					<td colspan="3">
						<x-bss-form.textarea name="description" row="2">{{ old('description', $row->description) }}</x-bss-form.textarea>
					</td>
				</tr>
			</table>

			<x-slot name="footer">
				<x-form.button type="submit" icon="bx bx-save" label="Save" />
			</x-slot>
		</x-card>
	</form>

	<x-modal-image-crop />
</x-app-layout>
