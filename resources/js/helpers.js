$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

window.getUrl = function getUrl() {
    var url = document.location.host;
    var arrayPathname = document.location.pathname.split('/');
    for (let i = 1; i < arrayPathname.length; i++) {
        if (arrayPathname[i] !== 'module') {
            url += '/' + arrayPathname[i];
        } else {
            break;
        }
    }
    url = url.replace('index.php', '');
    return url.replace('cart', '');
}