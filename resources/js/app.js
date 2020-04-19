require('./bootstrap');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('.btn-like').click(function(){
    $.ajax({
        url: $(this).data('url'),
        method: 'POST',
        data: {
            like : +!$(this).hasClass('text-primary')
        }
    }).done(data => {
        if ($(this).hasClass('text-primary')) {
            $(this).removeClass('text-primary');
            $('.like-icon', $(this)).removeClass('text-primary');

            $('.liker-count', $(this)).text(data.data.count);
        } else {
            $(this).addClass('text-primary');

            $('.liker-count', $(this)).text(data.data.count);
        }
    });
});

$('#btn-comment').click(function(){
    $('html, body').animate({
        scrollTop: $('#comment-form').offset().top
    }, 800)
});