function addWidgetText(data) {

    // console.log(data);
    $.ajax({
        type: "GET",
        url: "/widget-content/admin/add-text",
        data: { 'patch': data['patch'], 'modelName': data['model'], 'id': data['id'], 'url': data['url'] },
        success: function(response) {
            $('.newContent').html(response);
            $('.wdgetAddBtn').remove();
            $('.ckedit').each(function(index, el) {
                var textName = $(this).attr('name');
                CKEDITOR.replace(textName, {
                    customConfig: '/web/lib/ckeditor/config-light.js'
                });
            });
            $('#addWidget').modal('hide');
        }
    });

}

function updateWidgetText(id) {
    $.ajax({
        type: "GET",
        url: "/widget-content/update-text",
        data: { 'id': id },
        success: function(response) {
            $('.bodyWidgetUpr' + id).html(response);
            $('.haderWidgetUpr' + id).html('');
            $('.wdgetAddBtn').remove();

            $('.ckedit').each(function(index, el) {
                var textName = $(this).attr('name');
                CKEDITOR.replace(textName, {
                    customConfig: '/web/lib/ckeditor/config-light.js'
                });
            });
        }
    });

}

function addWidgetImage(id) {
    $.ajax({
        type: "GET",
        url: "/widget-content/add-image",
        data: { 'id': id },
        success: function(response) {
            $('.newContent').html(response);
            $('.wdgetAddBtn').remove();
            $('#addWidget').modal('hide');
            $('.image-fileinput').each(function(index, element) {
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
    });
}

function updateWidgetImage(id) {
    $.ajax({
        type: "GET",
        url: "/widget-content/update-image",
        data: { 'id': id },
        success: function(response) {
            $('.bodyWidgetUpr' + id).html(response);
            $('.haderWidgetUpr' + id).html('');
            $('.wdgetAddBtn').remove();

            $('.image-fileinput-prew').each(function(index, element) {
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
    });
}

function addWidgetDoc(id) {
    $.ajax({
        type: "GET",
        url: "/widget-content/add-doc",
        data: { 'id': id },
        success: function(response) {
            $('.newContent').html(response);
            $('.wdgetAddBtn').remove();
            $('#addWidget').modal('hide');
        }
    });

}

function updateWidgetDoc(id) {
    $.ajax({
        type: "GET",
        url: "/widget-content/update-doc",
        data: { 'id': id },
        success: function(response) {
            $('.bodyWidgetUpr' + id).html(response);
            $('.haderWidgetUpr' + id).html('');
            $('.wdgetAddBtn').remove();
        }
    });

}


function removeWidget(url) {
    document.location.href = url;
}