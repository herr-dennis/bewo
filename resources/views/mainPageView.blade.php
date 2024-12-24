@extends("defaultLayout")


@section("header")
    <nav>
        <a>Home</a>
        <a>Kontakt</a>
        <a>Was ist Bewo?</a>

    </nav>
@endsection

@section("main-content")


    <div>
        <img class="imgHeader" src={{asset("sozial.jpg")}} alt="Logo">
    </div>


    <div class="zitate" >

        <h2>Teilhabe am Leben</h2>
        <p>
            Die Hilfe wird so individuell gestaltet, wie das Leben unserer Kunden ist!
        </p>
        <hr>
    </div>


    <div class="defaultContainer">
        <p>Mit unseren Angeboten bieten wir Menschen mit einer <span class="highlight">Teilhabeeinschränkung</span> Unterstützung, um sie möglichst zu einer „<span class="highlight">unabhängigen Lebensführung und Eingliederung in die Gemeinschaft</span>“ zu befähigen (Artikel 19 der UN-Behindertenrechtskonvention).</p>

        <p>In der Präambel der Behindertenrechtskonvention ist beschrieben, dass Behinderung aus Wechselwirkung zwischen Menschen mit Beeinträchtigungen sowie einstellungs- und umweltbedingten Barrieren entsteht und verstanden wird.</p>


        <p>Wir wollen <span class="highlight">Hilfe zur Selbsthilfe</span> leisten, in dem wir in unserer Arbeit von dem individuellen Bedarf ausgehen und vorhandene Ressourcen und Kompetenzen stärken. Wir unterstützen und fördern die Einbindung in das soziale Umfeld.</p>


        <p>Uns ist es ein Anliegen, dass niemand aufgrund der Teilhabeeinschränkung aus der Gesellschaft ausgeschlossen wird. <span class="highlight">Vertrauen, Wertschätzung und Empathie</span> sind Teil der Beziehungsgestaltung und bilden das Fundament unserer täglichen Arbeit. In dieser Haltung bauen wir tragfähige und kontinuierliche Beziehungen
            auf.</p>
    </div>

@endsection
