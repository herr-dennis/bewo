@extends('layouts.app')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titel')</title>
    <link href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('FaviconLogo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta name="description" content="@yield("beschreibung")">
    <meta name="robots" content="index, follow"> <!-- Suchmaschinen dürfen die Seite indexieren und Links folgen -->

    <meta property="og:title" content="@yield('titelOg')" />
    <meta property="og:description" content="@yield('beschreibungOg')" />
    <meta property="og:image" content="{{ asset('MediumSquareLogo.jpg') }}" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="{{ config('app.name') }}" />


</head>
<body>
<header>
    @section("header")


        <div class="infoBar">
            <div class="infoItem">
                <a href="tel:024054067133">
                    <i class="fa fa-phone"></i> <!-- Telefon-Symbol -->
                </a>
                <span onclick="makeCall()" >02405 4067133</span>
            </div>
            <div class="infoItem">
                <a href="/Termine">
                    <i class="fa fa-calendar"></i> <!-- Kalender-Symbol -->
                </a>
                <span onclick="  moveToAktuell()">Aktuelles</span>
            </div>
            <div class="infoItem">
                <a href="/Kontakt">
                    <i class="fa fa-comment"></i> <!-- Kontakt-Symbol -->
                </a>
                <span onclick="moveToKontakt()" >Kontakt</span>
            </div>
        </div>

          <script>
              function moveToKontakt(){
                  window.location.href="/Kontakt";
              }
              function  moveToAktuell(){
                  window.location.href="/Termine"
              }

              function makeCall(){
                  const telLink = document.createElement('a');
                  telLink.href='tel:024054067133';
                  telLink.style.display='none';
                  document.body.appendChild(telLink);

                  telLink.click();


              }
          </script>


       @if(\Illuminate\Support\Facades\Session::has("error_db"))
           <label>{{\Illuminate\Support\Facades\Session::get("error_db")}}</label>
       @endif

    <script>


    </script>


        <nav>
            <ul>
                <li><a href="/BetreutesWohnen">Betreutes Wohnen</a></li>
                <li><a href="/HilfeJungeErwachsene">Weitere Leistungen</a></li>
                <li><a href="/Soziotherapie">Soziotherapie</a></li>
                <li >
                    <!-- Dropdown-Menü -->
                    <div class="dropdown">
                        <button class="dropbtn">Über uns</button>
                        <div class="dropdown-content">
                            <a href="/Kontakt">Kontakt</a>
                            <a href="/Team">Team</a>
                            <a href="/Jobs">Jobs</a>
                            <a href="/Kooperationen">Kooperationen</a>
                        </div>
                    </div>

                </li>

            </ul>
        </nav>

        <div class="imageContainer">
            <img src="{{asset('MediumSquareLogo.jpg')}}" class="imgHeader"  id="logo"  alt="Logo">
        </div>

        <script>
            // Logo-Element abrufen
            let logos = document.querySelectorAll('.imgHeader');
            logos.forEach(function (logo) {
                logo.addEventListener('click', function () {
                    window.location.href = '/';
                });
            });
        </script>


    @show
</header>
<main>
    <div style="position: fixed; bottom: 0; left: 0; margin: 3px ">
        <button class="buttonLogin" onclick="scrollToLogo()">
            <i class="fas fa-arrow-up"></i>
        </button>
    </div>


    <script>
        function scrollToLogo() {
            const logoElement = document.getElementById("logo");
            if (logoElement) {
                logoElement.scrollIntoView({
                    behavior: 'smooth', // Weiches Scrollen
                    block: 'start'      // Beginnt am oberen Rand des Elements
                });
            }
        }

    </script>


@section("main-content")
    @show
</main>

<footer>

    <div class="container" id="mitglieder">
        <h2>Wir sind <span class="labelMitglied" >Mitglied</span> in folgenden Verbänden</h2>
        <div class="logos">
            <div class="logo-item">
                <a href="https://www.igbewo-aachen.de/"target="_blank" >
                    <img src="{{asset('bewo.png')}}" alt="Platzhalter Logo 1">
                </a>
            </div>
            <div class="logo-item">
                <a href="https://www.bpa.de/" target="_blank" >
                    <img src="{{asset('bpa.png')}}" alt="Platzhalter Logo 2">
                </a>
            </div>
            <div class="logo-item">
                <a href="https://www.agpr-rheinland.de/" target="_blank" >
                    <img src="{{asset('AgpR.png')}}" alt="Platzhalter Logo 2">
                </a>
            </div>
            <div class="logo-item">
                <a href="https://soziotherapie.eu/" target="_blank" >
                    <img src="{{asset('sozioBund.png')}}" alt="Platzhalter Logo 2">
                </a>
            </div>
            <div class="logo-item">
                <a href="https://www.ivpnetworks.de/" target="_blank" >
                    <img src="{{asset('ivp.png')}}" alt="Platzhalter Logo 2">
                </a>
            </div>


        </div>
    </div>

    <a id="imp" href="/Impressum">Impressum</a>
    <a  id="daten" href="/Datenschutz">Datenschutz</a>
    <p class="copy" >&copy; 2025 Unternehmen Bewo-Paiva. Entwickelt von Schwarz@Web</p>
    @section("footer")
    @show
</footer>
</body>
</html>
