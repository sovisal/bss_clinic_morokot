<script>
    $(document).ready(function () {
        <?php if (!$is_edit) { ?>
            append_render_select2();
        <?php } ?>
        
        $(document).on('click', '.btn-add-service', append_render_select2);
        $(document).on('change', '[name="qty[]"], [name="price[]"]', calculate_total_row);
        
        $(document).on('change', '[name="service_id[]"]', function () {
            let selected = $(this).find(":selected");
            $(this).parents('tr').find('[name="price[]"]').val(bss_number(selected.data('price'))).trigger('change');
            $(this).parents('tr').find('[name="service_name[]"]').val(selected.html());
        });

        $(document).on('change', '[name="patient_id"]', function () {
            let selected = $(this).find(":selected");
            $('[name="pt_code"]').val(selected.data('pt_code'));
            $('[name="pt_gender"]').val(selected.data('gender')).trigger('change');
            $('[name="pt_age"]').val(selected.data('age'));
        });

        $('.btn-submit').click(function (){
            $('[name="status"]').val($(this).val());
        });

        function append_render_select2() {
            $('#table_result').append($('#sample_result_row').html()).find('select').each((_i, e) => {
                $(e).select2({
                    dropdownAutoWidth: !0,
                    width: "100%",
                    dropdownParent: $(e).parent()
                });
            });
        }

        function calculate_total_row () {
            let tr = $(this).parents('tr');
            let total = bss_number(tr.find('[name="qty[]"]').val()) * bss_number(tr.find('[name="price[]"]').val());
            tr.find('[name="total[]"]').val(bss_number(total));
        }

        $(document).on('keyup', 'select[name="service_id[]"] + span + span input.select2-search__field', function(e) {
            if(e.keyCode === 13) {
                let current_select = $(this);
                if (current_select.val()) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: window.route_service,
                        type: 'POST',
                        data: {
                            _token : CSRF_TOKEN,
                            name : current_select.val(),
                            price : '-1', usage_id : '1'
                        },
                        dataType: 'JSON',
                        success: function (data) { 
                            if (data.id) {
                                let newOption = new Option(current_select.val(), data.id, false, false);
                                $('select[name="service_id[]"').append(newOption);
                                current_select.closest('tr').find('select[name="service_id[]"]').val(data.id).trigger('change');
                            }
                        }
                    }); 
                }
            }
        });
    });
</script>