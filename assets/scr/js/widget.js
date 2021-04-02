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
        slidesToScroll: 1
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