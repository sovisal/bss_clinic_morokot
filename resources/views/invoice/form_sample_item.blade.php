<div>
    <table id="sample_prescription" class="hidden">
        <tr>
            <td>
                <input type="hidden" name="type[]" value="medicine">
                <input type="hidden" name="item_name[]" value="">
                <x-bss-form.select name="medicine_id[]" id="" required :select2="false">
                    <option value="">Please choose</option>
                    @foreach ($medicine as $data)
                        <option value="{{ $data->id }}" data-price="{{ $data->price }}">{{ $data->name }}</option>
                    @endforeach
                </x-bss-form.select>
            </td>
            <td>
                <x-bss-form.input type="number" name='qty[]' value="1" required class="text-center"/>
            </td>
            <td>
                <x-bss-form.input type="number" name='price[]' value="0" required class="text-center"/>
            </td>
            <td>
                <x-bss-form.input type="text" name='description[]' value="" class="text-center"/>
            </td>
            <td>
                <x-bss-form.input type="number" name='total[]' value="0" required class="text-center"/>
            </td>
            <td class="text-center">
                <x-form.button color="danger" class="btn-sm" icon="bx bx-trash" onclick="$(this).parents('tr').remove();"/>
            </td>
        </tr>
    </table>
</div>