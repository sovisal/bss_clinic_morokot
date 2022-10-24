<tr>
	<td width="15%" class="text-right">Invoice Number <small class='required'>*</small></td>
	<td>
		<input type="hidden" name="exchange_rate" value="4100">
		<x-bss-form.input name='inv_number' class="" value="{{ $inv_number }}" required :disabled="$is_edit && $row->inv_number"/>
	</td>
	<td class="text-right">Patient name <small class='required'>*</small></td>
	<td>
		<x-bss-form.select name="patient_id" required :disabled="$is_edit && $row->patient_id">
			@if (!$is_edit)
				<option value="">Please choose patient</option>
			@endif
			@foreach ($patient as $data)
				<option value="{{ $data->id }}" 
					{{ ($row->patient_id ?? false) == $data->id ? 'selected' : '' }}
					data-pt_code="PT-{!! str_pad($data->id, 6, '0', STR_PAD_LEFT) !!}"
					data-gender="{{ $data->gender }}"
					data-age="{{ $data->age }}"
				>{{ render_synonyms_name($data->name_en, $data->name_kh) }}</option>
			@endforeach
		</x-bss-form.select>
	</td>
</tr>
<tr>
	<td class="text-right">Invoice Date <small class='required'>*</small></td>
	<td>
		<x-bss-form.input name='inv_date' value="{{ date('Y-m-d H:i:s') }}" required :disabled="$is_edit && $row->inv_date"/>
	</td>
	<td class="text-right">PT Code <small class='required'>*</small></td>
	<td>
		<x-bss-form.input name='pt_code' value="" required :disabled="$is_edit && $row->pt_code"/>
	</td>
</tr>
<tr>
	<td class="text-right">Doctor <small class='required'>*</small></td>
	<td>
		<x-bss-form.select name="requested_by" required :disabled="$is_edit && $row->requested_by">
			{{-- @if (!$is_edit)
				<option value="">Please choose</option>
			@endif --}}
			@foreach ($doctor as $data)
				<option value="{{ $data->id }}" {{ ($row->requested_by ?? auth()->user()->doctor ?? false) == $data->id ? 'selected' : '' }} >{{ render_synonyms_name($data->name_en, $data->name_kh) }}</option>
			@endforeach
		</x-bss-form.select>
	</td>
	<td class="text-right">Gender <small class='required'>*</small></td>
	<td>
		<x-bss-form.select name="gender" data-no_search="true">
			<option value="">---- None ----</option>
			@foreach ($gender as $id => $data)
				<option value="{{ $id }}" {{ (old('gender')==$id) ? 'selected' : '' }}>{{ $data }}</option>
			@endforeach
		</x-bss-form.select>
	</td>
</tr>
<tr>
	<td class="text-right">Remark</td>
	<td>
		<x-bss-form.input name='requested_at' class="" hasIcon="right" value="" required :disabled="$is_edit && $row->requested_at"/>
	</td>
	<td class="text-right">Age <small class='required'>*</small></td>
	<td>
		<x-bss-form.input name='age' value="" required :disabled="$is_edit && $row->age"/>
	</td>
</tr>
<?php 
	$_4level_level = get4LevelAdressSelectorByID(@$row ? $row->address_id : '', ...['xx', 'option']);
?>
<tr>
	<td class="text-right">Province</td>
	<td>
		<x-bss-form.select name="pt_province_id">
			{!! $_4level_level[0] !!}
		</x-bss-form.select>
	</td>
	<td class="text-right">District</td>
	<td>
		<x-bss-form.select name="pt_district_id">
			{!! $_4level_level[1] !!}
		</x-bss-form.select>
	</td>
</tr>
<tr>
	<td class="text-right">Commune</td>
	<td>
		<x-bss-form.select name="pt_commune_id">
			{!! $_4level_level[2] !!}
		</x-bss-form.select>
	</td>
	<td class="text-right">Village</td>
	<td>
		<x-bss-form.select name="pt_village_id">
			{!! $_4level_level[3] !!}
		</x-bss-form.select>
	</td>
</tr>