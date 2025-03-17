$(document).ready(function() {
    // Handle form submission for searching artisans
    $('#artisan-search-form').on('submit', function(e) {
        e.preventDefault();
        searchArtisans(1);
    });

    // Handle filter changes
    $('#category-filter, #location-filter, #skill-filter').on('change', function() {
        searchArtisans(1);
    });

    // Handle pagination clicks
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        searchArtisans(page);
    });

    // Function to perform AJAX search
    function searchArtisans(page) {
        let category = $('#category-filter').val();
        let location = $('#location-filter').val();
        let skill = $('#skill-filter').val();

        // Show loading indicator
        $('#results-container').html('<div class="text-center py-5"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        $.ajax({
            url: $('#artisan-search-form').attr('action') + '?page=' + page,
            type: 'GET',
            data: {
                category: category,
                location: location,
                skill: skill
            },
            success: function(response) {
                // Update the DOM with the returned HTML
                $('#results-container').html(response.html);
                $('#pagination-container').html(response.pagination);
                $('#artisans-count').text(response.count);

                // Scroll to results if not on first load
                if (page !== 1) {
                    $('html, body').animate({
                        scrollTop: $("#results-container").offset().top - 100
                    }, 200);
                }
            },
            error: function() {
                $('#results-container').html('<div class="alert alert-danger">An error occurred while trying to fetch artisans. Please try again.</div>');
            }
        });
    }
});
