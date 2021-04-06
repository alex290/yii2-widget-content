var itemsSort = document.getElementById('itemsSort');
if (itemsSort) {
    var sortable = Sortable.create(itemsSort, {
        onEnd: function( /**Event*/ evt) {
            let arrId = [];
            $('#itemsSort .item-sort').each(function(index, element) {
                let idItem = $(this).data('id');
                arrId[index] = idItem;

            });
            $.ajax({
                type: "GET",
                url: "/widget-content/data/sort",
                data: { 'ids': JSON.stringify(arrId) },
                success: function(response) {}
            });
        },
    });

}


$(document).ready(function() {
    $('.carusel_widget').slick({
        infinite: true,
        slidesToShow: 5,
        slidesToScroll: 1,
        nextArrow: '<button type="button" class="slick-next"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" class="svg-inline--fa fa-angle-right fa-w-8" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg></button>',
        prevArrow: '<button type="button" class="slick-prev"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-left" class="svg-inline--fa fa-angle-left fa-w-8" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path fill="currentColor" d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z"></path></svg></button>',
    });
});

function showWodgetGrantPage() {
    let widgetAddCont = document.querySelector('.widget_add_cont');
    if (widgetAddCont.classList.contains('show')) {
        widgetAddCont.classList.remove("show");
    } else {
        widgetAddCont.classList.add("show");
    }
}

function pagesAddContWidget(data) {
    // console.log(data);
    // let datArr = JSON.parse(data);
    console.log(data[4]);
    $.ajax({
        type: "POST",
        url: "/widget-content/admin/add",
        data: { 'widget': JSON.stringify(data[3]), 'key': data[2], 'model': data[0], 'id': data[1], 'url': data[4] },
        success: function(response) {
            let htmlOb = document.querySelector('.get_cont_add_widget');
            htmlOb.innerHTML = response;
            ckeditSt();
            fileInpurAjax('image-fileinput');
        }
    });
}

function showEditWidget(data) {
    $.ajax({
        type: "GET",
        url: "/widget-content/admin/update",
        data: { 'id': data[0], 'url': data[2], 'widget': JSON.stringify(data[1]) },
        success: function(response) {
            showRemove();
            $('.get_cont_update_widget_' + data[0]).html(response);
            ckeditSt();
            fileInpurAjax('image-fileinput');
            disabSort();
        }
    });
}

function ckeditSt() {
    $('.ckStandart').each(function(index, element) {
        let ckpath = $(this).data('ckpath');
        if (ckpath) {
            let ckpathId = $(this).attr('id');
            let ckconf = $(this).data('ckconf');
            // console.log(ckconf);
            CKEDITOR.replace(ckpathId, {
                customConfig: ckconf,
            });
        }

    });

}

function fileInpurAjax(classItem) {
    $('.' + classItem).each(function(index, element) {
        $(this).fileinput({
            theme: 'fas',
            language: 'ru',
            allowedFileExtensions: ['jpg', 'png', 'jpeg', 'svg'],
            initialPreviewAsData: true,
            showUpload: false,
            showRemove: false,
            // maxFileSize: 2000,
        });

    });
}

function fileInpurAjaxPrew(classItem) {

    $('.' + classItem).each(function(index, element) {
        let previewImage = $(this).data('image');
        $(this).fileinput({
            theme: 'fas',
            language: 'ru',
            allowedFileExtensions: ['jpg', 'png', 'jpeg', 'svg'],
            initialPreviewAsData: true,
            initialPreview: [
                previewImage == '' ? null : '/web/' + previewImage,
            ],
            showUpload: false,
            showRemove: false,
            // maxFileSize: 2000,
        });

    });

}

function widgetClose() {
    document.location.reload();
}

function showRemove() {
    $('.showRemove').each(function(index, element) {
        element.remove();
    });

}