$(document).ready(function () {

    $('#submit').click(importarDatos);

    function importarDatos() {

        var file_data = $('#file-1').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        let today = new Date();
        let now = today.toLocaleDateString('es-MX');

        //console.log(form_data);
        if (file_data != undefined) {

            fetch("../Controllers/Excel/leerExcel_controller.php",
                {
                    method: "POST",
                    body: form_data
                })
                .then(response => response.blob())
                .then(data => {
                    const url = window.URL.createObjectURL(new Blob([data]));
                    const link = document.createElement("a");
                    link.href = url;
                    link.setAttribute("download", "Acuse_Creados-" + now + ".xls");
                    document.body.appendChild(link);
                    link.click();
                })
        } else {
            $('#response').show();
            $('#response').html('<p style="color:red;  font-weight:bold;"> No se ha cargado ningun archivo.');
        }
    }

    function loaderF(statusLoader) {
        //console.log(statusLoader);
        if (statusLoader) {
            $("#mensajeL").show();
            $("#loaderFiltro").show();
            $("#loaderFiltro").html('<img class="img-fluid" src="../Public/Assets/img/cargando.svg" style="left:50%; right: 50%; width:50px;">');
        } else {
            $("#mensajeL").hide();
            $("#loaderFiltro").hide();
        }
    }
})