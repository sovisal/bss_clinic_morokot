<x-app-layout>
	<x-slot name="js">
		<script>
			$(document).ready(function () {
				$('.table-medicine').append($('#sample_prescription').html());
				$('.table-medicine select').each((_i, e) => {
					$(e).select2({
						dropdownAutoWidth: !0,
						width: "100%",
						dropdownParent: $(e).parent()
					});
				});
				$(document).on('click', '.btn-add-medicine', function () {
					$('.table-medicine').append($('#sample_prescription').html());
					$('.table-medicine select').each((_i, e) => {
						$(e).select2({
							dropdownAutoWidth: !0,
							width: "100%",
							dropdownParent: $(e).parent()
						});
					});
				});
				$(document).on('change', '[name="qty[]"], [name="price[]"]', function () {
					$this_row = $(this).parents('tr');
					$total = 	bss_number($this_row.find('[name="qty[]"]').val()) * 
								bss_number($this_row.find('[name="price[]"]').val());

					$this_row.find('[name="total[]"]').val(bss_number($total));
				});

				$(document).on('change', '[name="medicine_id[]"]', function () {
					let name = $(this).find(":selected").html();
					let price = bss_number($(this).find(":selected").data('price'));
					$(this).parents('tr').find('[name="price[]"]').val(price).trigger('change');
					$(this).parents('tr').find('[name="item_name[]"]').val(name);
				});

				$(document).on('change', '[name="patient_id"]', function () {
					let current_option = $(this).find(":selected");
					$('[name="pt_code"]').val(current_option.data('pt_code'));
					$('[name="gender"]').val(current_option.data('gender')).trigger('change');
					$('[name="age"]').val(current_option.data('age'));
				});
			});
		</script>
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
					<x-form.button type="submit" class="btn-submit" value="1" disabled icon="bx bx-save" label="Save" />
				</div>
			</x-slot>
			<x-slot name="footer">
				<div>
					<x-form.button type="submit" class="btn-submit" value="1" disabled icon="bx bx-save" label="Save" />
				</div>
			</x-slot>		
			<table class="table-form striped">
				<tr>
					<th colspan="4" class="text-left tw-bg-gray-100">Invoice</th>
				</tr>
				@include('invoice.form_input')
			</table>
			<br>
			@include('invoice.form_input_new')
		</x-card>
	</form>
</x-app-layout>
