window.sortProducts = (field) => {

    let textBtn = $(`.sort${field} .textBtn`).text();
    let typeSort = 'desc';
    if (textBtn.indexOf("возрастанию") > 0) {
        typeSort = 'asc';
    }
    $.ajax({
        type: 'GET',
        url: `http://${getUrl()}actionSortProducts?field=${field}&typeSort=${typeSort}`,
        dataType: 'json',
        beforeSend: function () {
            $(`.spinner${field}`).show();
        },
        complete: function () {
            $(`.spinner${field}`).hide();
        },
        success: function (res) {
            $('.trsPlace').html(res['trsTableHtml']);
            changeTextBtn(textBtn, field);
        },
        error: function (error) {
            console.log('Произошла ошибка', error.responseJSON);
        }
    });
}


window.addProductToCart = (id,action) => {
    let formData = new FormData();
    formData.append('id_product', id);
    $.ajax({
        type: 'POST',
        url: `http://${getUrl()}${action}`,
        data: formData,
        processData: false,
        contentType: false,
        response: 'json',
        beforeSend: function () {
            $(`.spinneradd_${id}`).show();            
        },
        complete: function () {
            $(`.spinneradd_${id}`).hide();
        },
        success: function (res) {
            $('.alertMess').removeClass('alert-success alert-danger');
            $('.alertMess').addClass(res['style']);
            $('.alertMess').text(res['message']);
            $('.alertMess').show();
            setTimeout(() => {                
                $('.alertMess').hide();
            }, 3000);

        },
        error: function (error) {
            if(error.status === 401){
                window.location.href =(`http://${getUrl()}login`);
            }
            console.log('Произошла ошибка', error.status);
        }
    });
}

window.changeTextBtn = (textBtn, field) => {
    if (textBtn.indexOf("возрастанию") > 0) {
        $(`.sort${field} .textBtn`).text(textBtn.replace('возрастанию', 'убыванию'));
    } else {
        $(`.sort${field} .textBtn`).text(textBtn.replace('убыванию', 'возрастанию'));
    }
}
