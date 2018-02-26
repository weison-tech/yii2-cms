function updateItems(r) {
    _opts.items.available = r.available;
    _opts.items.assigned = r.assigned;
    search('available');
    search('assigned');
}

$('.btn-assign').click(function () {
    var $this = $(this);
    var target = $this.data('target');
    var routes = $('select.list[data-target="' + target + '"]').val();

    if (routes && routes.length) {
        $.post($this.attr('href'), {routes: routes}, function (r) {
            updateItems(r);
        });
    }
    return false;
});

$('#btn-refresh').click(function () {
    var $btn = $(this);
    $btn.attr("disabled", "disabled");

    $.post($(this).attr('href'), function (r) {
        updateItems(r);
    }).always(function () {
        $btn.removeAttr("disabled");
    });

    return false;
});

$('.search[data-target]').keyup(function () {
    search($(this).data('target'));
});

function search(target) {
    var $list = $('select.list[data-target="' + target + '"]');
    $list.html('');
    var q = $('.search[data-target="' + target + '"]').val();
    $.each(_opts.items[target], function () {
        var r = this;
        if (r.indexOf(q) >= 0) {
            $('<option>').text(r).val(r).appendTo($list);
        }
    });
}

// initial
search('available');
search('assigned');