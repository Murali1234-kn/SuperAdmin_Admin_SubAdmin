<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>

    <script>
        function showHint(str) {
            if (str.length == 0) {
                document.getElementById("txtHint").innerHTML = "";
                return;
            }
            else {
                let xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200)
                    {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                }
                xmlhttp.open("GET", "Name_search.php?q="+str, true);
                xmlhttp.send();
            }
        }
    </script>
</head>
<body>

<p><b>Start typing a name in the input field below</b></p>
<form action="">
    <label for="fname">First name:</label>
    <input type="text" id="fname" name="fname" onkeyup="showHint(this.value)">
</form>
<p>Suggestions: <span id="txtHint"></span></p>

</body>
</html>