$(document).ready(function() {
    $('#formulario').submit(function(event) {
        event.preventDefault();
        var archivos = $('#formulario input[type=file]')[0].files;
        var formData = new FormData();
        for (var i = 0; i < archivos.length; i++) {
            formData.append('archivo[]', archivos[i]);
        }
        $.ajax({
            url: 'respaldo.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#mensaje').html('Realizando respaldo, por favor espera...');
            },
            success: function(data) {
                $('#mensaje').html(data);
                $.ajax({
                    url: 'descarga.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            $('#descarga').html('Descarga el respaldo <a href="' + data.url + '">aquí</a>.');
                        }
                    }
                });
            }
        });
    });
});

