@extends("defaultLayout")
@section("beschreibung", " Ambulantes betreutes Wohnen | Würselen")
@section("titel","BeWo-Paiva | Ambulantes betreutes Wohnen | Würselen")
@section("main-content")



    <div class="defaultContainer">
        Unsere Adresse lautet: <br>
        Bahnhofstr. 33 <br>
        52146 Würselen
    </div>

    <div class="zitate" >
        <h2 style="color: #5c2d91">Teilhabe am Leben</h2 >
        <p>
            Die Hilfe wird so individuell gestaltet, wie das Leben unserer Kunden ist!
        </p>
        <hr>
    </div>
    <div class="defaultContainer">

        <div class="logoIntro">
            <img src="{{ asset('images/IMG-20250513-WA0015.jpg') }}" alt="Fenster Logo BeWo">
        </div>
        <p>Mit unseren Angeboten bieten wir Menschen mit einer <span class="highlight">Teilhabeeinschränkung</span> Unterstützung, um sie möglichst zu einer „<span class="highlight">unabhängigen Lebensführung und Eingliederung in die Gemeinschaft</span>“ zu befähigen (Artikel 19 der UN-Behindertenrechtskonvention).</p>

        <p>In der Präambel der Behindertenrechtskonvention ist beschrieben, dass Behinderung aus Wechselwirkung zwischen Menschen mit Beeinträchtigungen sowie einstellungs- und umweltbedingten Barrieren entsteht und verstanden wird.</p>


        <p>Wir wollen <span class="highlight">Hilfe zur Selbsthilfe</span> leisten, in dem wir in unserer Arbeit von dem individuellen Bedarf ausgehen und vorhandene Ressourcen und Kompetenzen stärken. Wir unterstützen und fördern die Einbindung in das soziale Umfeld.</p>


        <p>Uns ist es ein Anliegen, dass niemand aufgrund der Teilhabeeinschränkung aus der Gesellschaft ausgeschlossen wird. <span class="highlight">Vertrauen, Wertschätzung und Empathie</span> sind Teil der Beziehungsgestaltung und bilden das Fundament unserer täglichen Arbeit. In dieser Haltung bauen wir tragfähige und kontinuierliche Beziehungen
            auf.</p>
    </div>
  <p class="defaultContainer">Unser Büro und unsere Praxis — zum Wohlfühlen!</p>
    <div class="gallery" >
            <img  class="mySlides" src="{{asset("bur0.jpg")}}" alt="Bild 1">
            <img class="mySlides"  src="{{asset("bur1.jpg")}}" alt="Bild 2">
            <img  class="mySlides" src="{{asset("bur2.jpg")}}" alt="Bild 3">
        <button class="w3-button w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
        <button class="w3-button w3-display-right" onclick="plusDivs(+1)">&#10095;</button>
    </div>

    <script>

    var slideIndex = 1;
    showDivs(slideIndex);

    function plusDivs(n) {
    showDivs(slideIndex += n);
    }

    function showDivs(n) {
    var i;
    //Holte alle Bilder
    var x = document.getElementsByClassName("mySlides");
    if (n > x.length) {slideIndex = 1}
    if (n < 1) {slideIndex = x.length} ;
    for (i = 0; i < x.length; i++) {
    //Bild ausblenden
    x[i].style.display = "none";
    }
    //Bild einbleden
    x[slideIndex-1].style.display = "block";
    }
    </script>



@endsection
