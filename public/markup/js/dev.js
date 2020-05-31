$( document ).ready(function() {
    $('body').on('submit', '.js-form-search-vacancy', function(e){
        e.preventDefault();
        var form = $(this);
        var path = $('.js-region').val() != '' ? $('.js-region').val() : form.data('url');
        var url = path + '?q=' + $('.js-q').val();
        window.location = url;
    })
    
    $('body').on('submit', '#form-resume', function(e){
        e.preventDefault();
        var form = $(this);
        var btn = $('.js-submit', form);
       
        var formData = new FormData();
        formData.append('file', $('#resume-file')[0].files[0]);
        
        $('input, select, textarea', form).each(function () {
            if ($(this).attr('type') != 'radio') {
                formData.append($(this).attr('name'), $(this).val());
            }
        })
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            dataType: 'json',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
              'lang': $('html').attr('lang'),
              'WIDGET-ID': 'resume',
              'WIDGET-ACTION': 'send'
            },
            beforeSend: function () {
                btn.attr('disabled', true);
                $('.error', form).removeClass('error');
                $('.message-error', form).html('');
            },
            success: function (resp) {
                form.trigger('reset');
                form.html(resp.content);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                btn.attr('disabled', false);
                if (jqXHR.status === 422) {
                    $.each(jQuery.parseJSON(jqXHR.responseText).errors, function (k, v) {
                        var id = k.replace('.', '_')
                        var field = $('#resume-' + id, form);
                        var formGroup = field.parent();
                        field.addClass('error');
                        formGroup.find('.message-error').show().html(v[0]);
                    })
                }
            }
        })
    })
    
})