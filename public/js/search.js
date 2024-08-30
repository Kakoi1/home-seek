$(document).ready(function() {
    const searchForm = $('#search-form');
    const dormsList = $('#dorms-list');
    const paginationLinks = $('#pagination-links');

    function fetchDorms(page = 1) {
        const formData = searchForm.serialize();
        $.ajax({
            url: `${window.location.pathname}?page=${page}&${formData}`,
            type: 'GET',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            },
            success: function(response) {
                dormsList.html(response.dorms);
                paginationLinks.html(response.pagination);
            }
        });
    }
 
    const debounce = (func, delay) => {
        let debounceTimer;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => func.apply(context, args), delay);
        };
    };

    searchForm.find('input').on('input', debounce(() => fetchDorms(), 500));

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const page = $(this).attr('href').split('page=')[1];
        fetchDorms(page);
    });
});

 