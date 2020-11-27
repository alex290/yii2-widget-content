$(document).ready(function() {
    $(function() {
        $(".sortableWidgetContent").sortable({
            stop: function(event, ui) {
                let id = [];
                $('.sortableWidgetContentItem').each(function(index, element) {
                    id[index] = $(element).data('id');
                });

                $.ajax({
                    type: "GET",
                    url: "/widget-content/data/sortable",
                    data: { 'data': JSON.stringify(id) },
                    success: function(response) {

                    }
                });
                console.log(id);

            }
        });
        $(".sortableWidgetContent").disableSelection();
    });
});

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
                CKEDITOR.replace(textName);
            });
            $('#collapseWidgetContent').collapse('hide');

        }
    });

}

function updateWidgetText(data) {
    $.ajax({
        type: "GET",
        url: "/widget-content/admin/update-text",
        data: { 'id': data['id'], 'url': data['url'] },
        success: function(response) {
            $('.bodyWidgetUpr' + data['id']).html(response);
            $('.haderWidgetUpr' + data['id']).html('');
            $('.wdgetAddBtn').remove();

            $('.ckedit').each(function(index, el) {
                var textName = $(this).attr('name');
                CKEDITOR.replace(textName);
            });
        }
    });

}

function addWidgetImage(data) {
    $.ajax({
        type: "GET",
        url: "/widget-content/admin/add-image",
        data: { 'patch': data['patch'], 'modelName': data['model'], 'id': data['id'], 'url': data['url'] },
        success: function(response) {
            $('.newContent').html(response);
            $('.wdgetAddBtn').remove();
            $('#collapseWidgetContent').collapse('hide');
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

function updateWidgetImage(data) {
    $.ajax({
        type: "GET",
        url: "/widget-content/admin/update-image",
        data: { 'id': data['id'], 'url': data['url'] },
        success: function(response) {
            $('.bodyWidgetUpr' + data['id']).html(response);
            $('.haderWidgetUpr' + data['id']).html('');
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

function addWidgetDoc(data) {
    $.ajax({
        type: "GET",
        url: "/widget-content/admin/add-doc",
        data: { 'patch': data['patch'], 'modelName': data['model'], 'id': data['id'], 'url': data['url'] },
        success: function(response) {
            $('.newContent').html(response);
            $('.wdgetAddBtn').remove();
            $('#collapseWidgetContent').collapse('hide');
        }
    });

}

function updateWidgetDoc(data) {
    $.ajax({
        type: "GET",
        url: "/widget-content/admin/update-doc",
        data: { 'id': data['id'], 'url': data['url'] },
        success: function(response) {
            $('.bodyWidgetUpr' + data['id']).html(response);
            $('.haderWidgetUpr' + data['id']).html('');
            $('.wdgetAddBtn').remove();
        }
    });

}


function removeWidget(url) {
    document.location.href = url;
}