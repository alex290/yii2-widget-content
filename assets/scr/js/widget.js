var el = document.getElementById('itemsSort');
var sortable = Sortable.create(el, {
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