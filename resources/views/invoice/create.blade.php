<x-app-layout>
	<x-slot name="js">
		@include('invoice.script')
	</x-slot>
	<x-slot name="header">
		<x-form.button href="{{ route('invoice.index') }}" color="danger" icon="bx bx-left-arrow-alt" label="Back" />
	</x-slot>
	<form action="{{ route('invoice.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
		@method('PUT')
		@csrf
		<input type="hidden" name="status" value="1" />
		<x-card bodyClass="pb-0" :actionShow="false">
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
			<table class="table-form striped">
				<tr>
					<th colspan="4" class="text-left tw-bg-gray-100">Invoice</th>
				</tr>
				@include('invoice.form_input')
			</table>
			<br>
			@include('invoice.form_input_detail')
		</x-card>
	</form>
	<div>
    	<table id="sample_prescription" class="hidden">
			@include('invoice.form_sample_item')
		</table>
	</div>
</x-app-layout>
