<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<!-- <div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="card-link">Card link</a>
    <a href="#" class="card-link">Another link</a>
  </div>
</div> -->
</head>
<body>
    <h1>The XMLHttpRequest Object</h1>
    <button type="button" onclick="loadDoc()">Get my Songs collection</button>
    <br>
    <br>
    <div class="container" >
        <div class="row" id="content">


        </div>
    </div>
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
            var card ="";
            var x = xmlDoc.getElementsByTagName("song");
            for (i = 0; i < x.length; i++) {
                card += "<div class='card col-4' style='width: 18rem;'><div class='card-body'>"+
                "<h5 class='card-title'>"+x[i].getElementsByTagName("artist")[0].childNodes[0].nodeValue+
                "</h5><h6 class='card-subtitle mb-2 text-muted'>"+
                    x[i].getElementsByTagName("title")[0].childNodes[0].nodeValue +
                    "</h6><h6>" +
                    x[i].getElementsByTagName("country")[0].childNodes[0].nodeValue +
                    "</h6><h6>" +
                    x[i].getElementsByTagName("genre")[0].childNodes[0].nodeValue +
                    "</h6><h6>" +
                    x[i].getElementsByTagName("year")[0].childNodes[0].nodeValue +
                    "</h6></div></div>";
            }
            document.getElementById("content").innerHTML = card;
        }
    </script>
</body>

</html>