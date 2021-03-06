window.removeProductToCart = (id,placeData) => {
    let action = 'deleteProduct';
    if (placeData === 'cartsession'){
        action = 'deleteProductFromSession';
    }
    let formData = new FormData();
    formData.append('id', id);
    formData.append('_method', 'delete');
    $.ajax({
        type: 'POST',
        url: `http://${getUrl()}/api/${action}`,
        data: formData,
        processData: false,
        contentType: false,
        response: 'json',
        beforeSend: function () {
            $(`.spinnerdel_${id}`).show();
        },
        complete: function () {
            $(`.spinnerdel_${id}`).hide();
        },
        success: function (res) {
            $('.trsPlace').html(res['trsTableHtml']);

        },
        error: function (error) {   
            if(error.status === 401){
                window.location.href =(`http://${getUrl()}login`);
            }
            console.log('Произошла ошибка', error.responseJSON);
        }
    });
}