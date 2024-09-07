$(document).ready(function() {
    fetchAllItems();
});

function fetchAllItems() {
    $.ajax({
        url: 'fetch_items.php',
        type: 'GET',
        success: function(response) {
            $('#storeItems').html(response);
        }
    });
}

function filterItems() {
    var category = $('#categoryFilter').val();

    $.ajax({
        url: 'fetch_items.php',
        type: 'GET',
        data: { category: category },
        success: function(response) {
            $('#storeItems').html(response);
        }
    });
}

function searchItems() {
    var searchQuery = $('#searchInput').val();

    $.ajax({
        url: 'search_items.php',
        type: 'GET',
        data: { search: searchQuery },
        success: function(response) {
            $('#storeItems').html(response);
        }
    });
}