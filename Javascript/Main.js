
function delete_record(event)
{
    event.preventDefault();
    let a = confirm("Are you sure you want to delete");
    if (a) {
        window.location.href = event.target.href; //ok ->button
    } else {
        console.log("Cancelled deletion"); // cancel->button
    }
}

$(document).ready(function ()
{
    $("#search").on("keyup", function ()
    {
        let value = $(this).val().toLowerCase();
        $("#tt tr").filter(function ()
        {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});

    function get_districts(val)
    {
    $.ajax({
        type: "POST",
        url: "Districts_All.php",
        data:'state_id='+val,
        success: function(data){
            $("#districts").html(data);
        }
    });
}




$(document).ready(function()
{
    $("#form").submit(function ()
    {
        let userEmail = $("#userEmail").val();
        let password = $("#password").val();
        if(userEmail === "")
        {
            $("#userEmailErr").html("Email is Required")
            return false;
        }
        if (password === "")
        {

            $("#passwordErr").html("Password is Required");
            return false;
        }
        else
        if (!Password(password))
        {
            $("#passwordErr").html(" Invalid Password");
            return false;
        }
    });
});
function Password(password) {
    return /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^\w\d\s])\S{8,}$/.test(password);
}