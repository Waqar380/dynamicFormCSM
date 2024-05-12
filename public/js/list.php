<script>
        $(document).ready(function(){
            $.ajax({
            type: 'GET',
            url: window.location.origin + '/dynamicFormCSM/api/get_form.php',
            dataType: 'json',
            success: function(response) {
                $.each(response.data, function(index, form) {
                    // console.log(form.id);
                    var row = '<tr>' +
                        '<td>' + form.id + '</td>' +
                        '<td>' + form.name + '</td>' +
                        '<td>' + form.created_at + '</td>' +
                        '<td><a href="./views/view_form.php?id=' + form.id + '" class="btn btn-success"><i class="fas fa-eye"></i> View</a></td>' +
                        '</tr>';

                    $('#formListTable tbody').append(row);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching forms:', error);
                $('#formListTable tbody').append('<tr><td colspan="4" style="text-align: center;">No Form Found.</td></tr>');
            }
        });
        });
    </script>