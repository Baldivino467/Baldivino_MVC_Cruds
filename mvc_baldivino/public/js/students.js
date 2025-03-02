$(document).ready(function() {
    // Hide the default DataTables search
    $.extend($.fn.dataTable.defaults, {
        searching: true,
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
    });

    var table = $('#studentTable').DataTable({
        processing: true,
        serverSide: false,
        autoWidth: false,
        responsive: true,
        pageLength: 10,
        order: [[1, 'asc']], // Sort by Student ID by default
        
        // Hide the default search box
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

        language: {
            search: "",
            searchPlaceholder: "Search..."
        },

        // Initialize with the data from the controller
        data: @json($students),
        
        columns: [
            { 
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'student_id' },
            { 
                data: 'name',
                render: function(data) {
                    return `<div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary text-white p-2 mr-2" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                            ${data.charAt(0).toUpperCase()}
                        </div>
                        ${data}
                    </div>`;
                }
            },
            { data: 'email' },
            { 
                data: 'course',
                render: function(data) {
                    return `<span class="badge badge-info">${data}</span>`;
                }
            },
            { 
                data: 'year_level',
                render: function(data) {
                    return `<span class="badge badge-success">${data}</span>`;
                }
            },
            { 
                data: 'actions',
                orderable: false,
                searchable: false
            }
        ]
    });

    // Connect custom search box to DataTables
    $('#searchInput').on('keyup', function() {
        table.search(this.value).draw();
    });

    // Handle search button click
    $('#searchButton').on('click', function() {
        table.search($('#searchInput').val()).draw();
    });
}); 