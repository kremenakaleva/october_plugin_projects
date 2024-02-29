$(document).ready(function() {
    $('#searchInput').selectize({
        plugins: ["clear_button", "remove_button", "restore_on_backspace"],
        create: true,
        valueField: 'value',
        labelField: 'text',
        searchField: 'text',
        load: function(query, callback) {
            if (query.length < 1) {
                callback([]);
                return;
            }
            $.request('onGetKeywords', {
                data: { query: query },
                success: function(response) {
                    callback(response);
                }
            });
        },
        render: {
            option_create: function(data, escape) {
                return '<div class="create">Search for: <strong>' + escape(data.input) + '</strong>&hellip;</div>';
            }
        },
        highlight: true,
        sortField: 'text',
        placeholder: 'Search by keywords...',
        loadThrottle: 300,
        noResultsText: 'No results found',
        onChange: function(value) { 
            updateProjectList();
        }
    });

    $('#sortField, #sortDirection').selectize({
        onChange: function(value) {
            updateProjectList();
        }
    });
    
    const startDatePicker = flatpickr("#startDate", {
        dateFormat: "j F, Y",
        onChange: function(selectedDates, dateStr, instance) {
            updateProjectList();
        }
    });
    
    const endDatePicker = flatpickr("#endDate", {
        dateFormat: "j F, Y",
        onChange: function(selectedDates, dateStr, instance) {
            updateProjectList();
        }
    });

    $('#clearDates').click(function() {
        startDatePicker.clear();
        endDatePicker.clear();
        updateProjectList();
    });

    function updateProjectList() {
        var sortField = $('#sortField').val();
        var sortDirection = $('#sortDirection').val();
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
    

        $.request('onSearchRecords', {
            data: { 
                searchTerms: $('#searchInput').val(),
                sortField: sortField, 
                sortDirection: sortDirection ,
                startDate: startDate,
                endDate: endDate,
            },
            update: { '@records': '#recordsContainer' }
        });
    }

    
});
