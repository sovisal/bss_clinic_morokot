<input type="hidden" name="is_treament_plan" value="0">
<table class="table-form table-padding-sm table-striped table-medicine">
    <thead>
        <tr>
            <th colspan="10" class="tw-bg-gray-100">
                <div class="d-flex justify-content-between align-items-center">
                    Result
                    <div>
                        <x-form.button class="btn-add-medicine" icon="bx bx-plus" label="Add Medicine" />
                    </div>
                </div>
            </th>
        </tr>
        <tr class="text-center">
            <th>Service <small class="required">*</small></th>
            <th width="100px">Qty <small class="required">*</small></th>
            <th width="100px">Price <small class="required">*</small></th>
            <th>Description</th>
            <th width="100px">Total <small class="required">*</small></th>
            <th width="80px">Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- JS dynamic -->
    </tbody>
</table>
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
                <x-bss-form.input type="text" name='description[]' value="" required class="text-center"/>
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