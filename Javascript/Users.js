function validateForm()
{
    let Name = document.getElementById("userName").value;
    let NameError = document.getElementById("NameError");

    let Type = document.getElementById("userType").value;
    let UserError = document.getElementById("TypeError");

    let password = document.getElementById("password").value;
    let passwordError = document.getElementById("passwordError");

    let Email = document.getElementById("userEmail").value;
    let EmailError = document.getElementById("EmailError");
    
    if (Name === "")
    {
        NameError.innerHTML = "Name is required";
        return false;
    }

    if (Type === "")
    {
        UserError.innerHTML = "Please Select Type";
        return false;
    }

    if (password === "") {
        passwordError.innerHTML = "Password is Required";
        return false;
    }
    else if (!Password(password)) {
        passwordError.innerHTML = "Invalid password format";
        return false;
    }

    if (Email === "") {
        EmailError.innerHTML = "Email is Required";
        return false;
    }
}

function Password(password)
{
    return /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^\w\d\s])\S{8,}$/.test(password);
}
