$(document).ready(function () {
    function loadContent(url) {
        $.ajax({
            url: url,
            type: 'GET',
            success: function (data) {
                $('#dynamicContent').html(data);
            }
        });
    }

    // Click event for Employees link
    $("#employeeLink").click(function (event) {
        event.preventDefault();
        loadContent("employee.php");
    });

    // Click events for actions inside employee.php
    $("#a1").click(function (event) {
        event.preventDefault();
        loadContent("employee_insert.php");
    });

    $("#a2").click(function (event) {
        event.preventDefault();
        loadContent("employee_delete.php");
    });

    $("#bt3").click(function (event) {
        event.preventDefault();
        loadContent("employee_update.php");
    });
});



$(document).ready(function () {
    $("#form").submit(function (event) {
        event.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                $("#dynamicContent").html(data);
            }
        });
    });
});


