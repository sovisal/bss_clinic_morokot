<tr>
    <td>
        <input type="hidden" name="inv_item_id[]" value="{{ @$item ? $item->id : '0' }}">
        <input type="hidden" name="service_type[]" value="{{ @$item ? $item->service_type : '' }}">
        <input type="hidden" name="service_name[]" value="{{ @$item ? $item->service_name : '' }}">
        <x-bss-form.select name="service_id[]" id="" required :select2="false">
            <option value="">Please choose</option>
            @foreach ($medicine as $data)
                <option value="{{ $data->id }}"
                    {{ @$item && $item->service_id == $data->id ? 'selected' : '' }}
                    data-price="{{ $data->price }}">{{ $data->name }}</option>
            @endforeach
        </x-bss-form.select>
    </td>
    <td>
        <x-bss-form.input type="number" name='qty[]' value="{{ @$item ? $item->qty : 1 }}" required class="text-center"/>
    </td>
    <td>
        <x-bss-form.input type="number" name='price[]' value="{{ @$item ? $item->price : 0 }}" required class="text-center"/>
    </td>
    <td>
        <x-bss-form.input type="text" name='description[]' value="{{ @$item ? $item->description : '' }}"/>
    </td>
    <td>
        <x-bss-form.input type="number" name='total[]' value="{{ @$item ? $item->total : 0 }}" required class="text-center"/>
    </td>
    <td class="text-center">
        <x-form.button color="danger" class="btn-sm" icon="bx bx-trash" onclick="$(this).parents('tr').remove();"/>
    </td>
</tr>