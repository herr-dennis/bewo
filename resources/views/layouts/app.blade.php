<div id="cookie-banner" style="
    position: fixed;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80%;
    background: rgba(255,255,255,0.9);
    color: #000000;
    text-align: center;
    padding: 15px;
    border: 2px #5c2d91 solid;
    display: none;
    z-index: 9999;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.5);
">
    <p style="margin: 0; padding: 0 10px; display: inline-block;">
        Diese Website verwendet Cookies, um Ihnen das beste Erlebnis zu bieten.
        <a href="{{ url('/Datenschutz') }}" style="color: #5c2d91; text-decoration: underline;">Mehr erfahren</a>
    </p>
    <button onclick="acceptCookies()" class="buttonCookie">
        Alle Cookies erlauben
    </button>
    <button onclick="acceptTechnicalCookies()" class="buttonCookie" >
        Nur technische Cookies
    </button>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Banner nur anzeigen, wenn noch keine Entscheidung getroffen wurde
        if (!localStorage.getItem("cookiesAccepted")) {
            document.getElementById("cookie-banner").style.display = "block";
        }
    });

    // Alle Cookies akzeptieren
    function acceptCookies() {
        localStorage.setItem("cookiesAccepted", "all");
        document.cookie = "technicalCookiesAccepted=true; path=/;";
        document.getElementById("cookie-banner").style.display = "none";
    }

    // Nur technische Cookies akzeptieren
    function acceptTechnicalCookies() {
        localStorage.setItem("cookiesAccepted", "technical");
        document.cookie = "technicalCookiesAccepted=true; path=/;";
        document.getElementById("cookie-banner").style.display = "none";
    }


</script>

