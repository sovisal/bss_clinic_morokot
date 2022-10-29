<x-app-layout>
	<x-slot name="header">
		<x-form.button href="{{ route('invoice.service.index') }}" color="danger" icon="bx bx-left-arrow-alt" label="Back" />
	</x-slot>
	<form action="{{ route('invoice.service.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
		@csrf
		<x-card bodyClass="pb-0" :actionShow="false">
			<table class="table-form striped">
				<tr>
					<th colspan="4" class="text-left tw-bg-gray-100">Service Information</th>
				</tr>
				<tr>
					<td width="20%" class="text-right">Name <small class='required'>*</small></td>
					<td width="30%">
						<x-bss-form.input name="name" required autofocus />
					</td>
					<td width="20%" class="text-right">
						Price <small class='required'>*</small>
					</td>
					<td width="30%">
						<x-bss-form.input name="price" class="is_number" required/>
					</td>
				</tr>
				<tr>
					<td class="text-right">Description</td>
					<td colspan="3">
						<x-bss-form.textarea name="description" row="2" />
					</td>
				</tr>
			</table>

			<x-slot name="action">
				<div>
					<x-form.button type="submit" class="btn-submit" value="1" icon="bx bx-save" label="Save" />
				</div>
			</x-slot>
			<x-slot name="footer">
				<div>
					<x-form.button type="submit" class="btn-submit" value="1" icon="bx bx-save" label="Save" />
				</div>
			</x-slot>
		</x-card>
	</form>
</x-app-layout>
