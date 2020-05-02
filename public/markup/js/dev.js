$( document ).ready(function() {
    $('body').on('submit', '.js-form-search-vacancy', function(e){
        e.preventDefault();
        var form = $(this);
        var path = $('.js-region').val() != '' ? $('.js-region').val() : form.data('url');
        var url = path + '?q=' + $('.js-q').val();
        window.location = url;
        
    })
})