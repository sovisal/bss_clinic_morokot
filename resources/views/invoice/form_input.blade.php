<tr>
	<td width="15%" class="text-right">Invoice Number <small class='required'>*</small></td>
	<td>
		<table width="100%">
			<tr>
				<td>
					<x-bss-form.input name='inv_number' class="" value="{{ @$row->code ?: $code }}" required :disabled="true"/>
				</td>
				<td class="text-right">Exchange Rate <small class='required'>*</small></td>
				<td>
					<x-bss-form.input name='exchange_rate' class="" value="{{ @$row->exchange_rate ?: 4100 }}" required :disabled="$is_edit && $row->status > 1"/>
				</td>
			</tr>
		</table>
	</td>
	<td class="text-right">Patient name <small class='required'>*</small></td>
	<td>
		<x-bss-form.select name="patient_id" required :disabled="$is_edit && $row->patient_id">
			@if (!$is_edit)
				<option value="">Please choose patient</option>
			@endif
			@foreach ($patient as $data)
				<option value="{{ $data->id }}" 
					{{ old('patient_id', @$row->patient_id) == $data->id ? 'selected' : '' }}
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
		<x-bss-form.input name='pt_code' value="{{ old('pt_code', @$row->pt_code) }}" required :disabled="$is_edit && $row->pt_code"/>
	</td>
</tr>
<tr>
	<td class="text-right">Doctor <small class='required'>*</small></td>
	<td>
		<x-bss-form.select name="doctor_id" required :disabled="$is_edit && $row->doctor_id">
			{{-- @if (!$is_edit)
				<option value="">Please choose</option>
			@endif --}}
			@foreach ($doctor as $data)
				<option value="{{ $data->id }}" {{ ($row->doctor_id ?? auth()->user()->doctor ?? false) == $data->id ? 'selected' : '' }} >{{ render_synonyms_name($data->name_en, $data->name_kh) }}</option>
			@endforeach
		</x-bss-form.select>
	</td>
	<td class="text-right">Gender <small class='required'>*</small></td>
	<td>
		<x-bss-form.select name="pt_gender" data-no_search="true" :disabled="$is_edit && $row->pt_gender">
			<option value="">---- None ----</option>
			@foreach ($gender as $id => $data)
				<option value="{{ $id }}" {{ (old('pt_gender', @$row->pt_gender)==$id) ? 'selected' : '' }}>{{ $data }}</option>
			@endforeach
		</x-bss-form.select>
	</td>
</tr>
<tr>
	<td class="text-right">Remark</td>
	<td>
		<x-bss-form.input name='remark' value="{{ old('remark', @$row->remark) }}"/>
	</td>
	<td class="text-right">Age</td>
	<td>
		<x-bss-form.input name='pt_age' value="{{ old('pt_age', @$row->pt_age) }}" :disabled="$is_edit && $row->pt_age"/>
	</td>
</tr>
<?php 
	$_4level_level = get4LevelAdressSelectorByID(@$row ? $row->address_id : '', ...['xx', 'option']);
?>
<input type="hidden" name="address_id" value="{{ @$row->address_id }}">
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