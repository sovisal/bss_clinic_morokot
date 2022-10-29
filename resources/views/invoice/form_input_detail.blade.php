<table class="table-form table-padding-sm table-striped table-medicine" id="table_result">
    <thead>
        <tr>
            <th colspan="10" class="tw-bg-gray-100">
                <div class="d-flex justify-content-between align-items-center">
                    Result
                    <div>
                        <!-- <x-form.button class="btn-add-medicine" icon="bx bx-plus" label="Add Medicine" /> -->
                        <x-form.button class="btn-add-service" icon="bx bx-plus" label="Add Service" />
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
        <!-- JS dynamic & preload in Edit screen-->
        @if(@$invoice_detail)
            @foreach ($invoice_detail as $item)
                @include('invoice.form_sample_item')
            @endforeach
        @endif
    </tbody>
</table>