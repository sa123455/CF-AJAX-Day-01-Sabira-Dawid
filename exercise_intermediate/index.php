<!DOCTYPE html>
<html>
<style>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    
    th,
    td {
        padding: 5px;
    }
</style>

<body>
    <h1>The XMLHttpRequest Object</h1>
    <button type="button" onclick="loadDoc()">Get my Songs collection</button>
    <br>
    <br>
    <table id="content"></table>
    <script>
        function loadDoc() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    myFunction(this);
                }
            };
            xhttp.open("GET", "songs.xml", true);
            xhttp.send();
        }

        function myFunction(xml) {
            var i;
            var xmlDoc = xml.responseXML;
            var table = "<tr><th>Artist</th><th>Title</th><th>Country</th><th>Genre</th><th>Year</th></tr>";
            var x = xmlDoc.getElementsByTagName("song");
            for (i = 0; i < x.length; i++) {
                table += "<tr><td>" +
                    x[i].getElementsByTagName("artist")[0].childNodes[0].nodeValue +
                    "</td><td>" +
                    x[i].getElementsByTagName("title")[0].childNodes[0].nodeValue +
                    "</td><td>" +
                    x[i].getElementsByTagName("country")[0].childNodes[0].nodeValue +
                    "</td><td>" +
                    x[i].getElementsByTagName("genre")[0].childNodes[0].nodeValue +
                    "</td><td>" +
                    x[i].getElementsByTagName("year")[0].childNodes[0].nodeValue +
                    "</td></tr>";
            }
            document.getElementById("content").innerHTML = table;
        }
    </script>
</body>

</html>