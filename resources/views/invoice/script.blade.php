<script>
    $(document).ready(function () {
        <?php if (!$is_edit) { ?>
            $('.table-medicine').append($('#sample_prescription').html());
        <?php } ?>
            
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

        $(document).on('change', '[name="service_id[]"]', function () {
            let name = $(this).find(":selected").html();
            let price = bss_number($(this).find(":selected").data('price'));
            $(this).parents('tr').find('[name="price[]"]').val(price).trigger('change');
            $(this).parents('tr').find('[name="service_name[]"]').val(name);
        });

        $(document).on('change', '[name="patient_id"]', function () {
            let current_option = $(this).find(":selected");
            $('[name="pt_code"]').val(current_option.data('pt_code'));
            $('[name="pt_gender"]').val(current_option.data('gender')).trigger('change');
            $('[name="pt_age"]').val(current_option.data('age'));
        });

        $('.btn-submit').click(function (){
            $('[name="status"]').val($(this).val());
        });
    });
</script>