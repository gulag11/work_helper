// + jquery

$(() => {
    forms();
});

function forms() {
    $(document).on('submit', 'forms', function (e) {
        e.preventDefault();
        const form = $(this),
            method = form.attr('method'),
            action = form.attr('action'),
            data = {};
        //todo добавить


        $.ajax({
            type: method ? method : 'GET',
            url: action ? action : window.location.href,
            data: data,
            success: function (r) {
                //todo добавить
            },
        });        
    });
}