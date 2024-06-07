// + jquery


$(() => {
    forms();
});


function forms() {
    $(document).on('submit', '[data-form]', function (e) {
        e.preventDefault();
        const form = $(this),
            method = form.attr('method'),
            action = form.attr('action'),
            data = {};
        
        // в форме производим поиск по data-get-field и формируем data обьект с ключами и значениями
        $(this).find('[data-get-field]').each(function () {
            let name = this.name,
                value = this.value;
            if (name && value) {
                data[this.name] = data.value();
            }
        })

        $.ajax({
            type: 'POST',
            url: window.location.href,
            dataType : 'html',
            data: data,
            success: function (r) {
                replace(r);
            },
        });        
    });
}

// функция заменяет участки страницы при ajax,
// на вход передаем html ответа сервера и селектор замены
// на блоки замены добавляем data-replace=""
function replace(r, selector = 'replace') {
    $(`[data-${selector}]`).each((i, item) => {
        const jqObj = $(item),
            link = jqObj.data(selector)
        let linkElem = $(r).filter(`[data-${selector}=${link}]`)

        if (!linkElem.length) {
            linkElem = $(r).find(`[data-${selector}=${link}]`)
        }

        jqObj.empty()
        jqObj.append(linkElem.html())
    })
}


