@extends('defaultLayout')


@section("titel", "BeWo-Paiva Kontakt")
@section("beschreibung", "BeWo-Paiva Kontaktseite")

@section("main-content")
    <h1 class="headline">Kontakt</h1>
    <div class="defaultContainer">
    <p>Schön, dass Sie da sind!
        Wir freuen uns über Ihr Interesse. Wenn Sie Fragen, Anregungen oder Wünsche haben, können Sie uns über das untenstehende Kontaktformular ganz unkompliziert erreichen.
        Teilen Sie uns einfach Ihren Namen, Ihre E-Mail-Adresse und Ihre Nachricht mit – wir melden uns so schnell wie möglich bei Ihnen.
        Vielen Dank für Ihr Vertrauen!</p>
</div>

    <div>

        <form class="formContainer" id="formKontakt" method="post" action="{{ route('sendKontakt') }}">
            @csrf
            <label id="überschriftForm">Kontaktformular</label>
            <label>Ihr Name</label>
            <input type="text" name="name" placeholder="Ihr Name" required>
            <label>Ihre E-Mail</label>
            <input type="email" name="email" required placeholder="Ihre E-Mail">
            <label>Ihr Anliegen</label>
            <textarea name="text" required placeholder="Ihre Nachricht an uns!"></textarea>

            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
            <button class="buttonLogin" type="button" onclick="executeReCaptchaKontakt()">Absenden</button>

        </form>
        <script src="https://www.google.com/recaptcha/api.js?render=6Ldz2vQqAAAAAMAYAJ9W4msLDowqxzh9qkWS0gv7"></script>

        <script>
            function executeReCaptchaKontakt() {
                grecaptcha.ready(function () {
                    grecaptcha.execute('6Ldz2vQqAAAAAMAYAJ9W4msLDowqxzh9qkWS0gv7', { action: 'submit' }).then(function (token) {
                        document.getElementById('g-recaptcha-response').value = token;
                        document.getElementById("formKontakt").submit();
                    });
                });
            }
        </script>

    </div>
    @if(\Illuminate\Support\Facades\Session::has('error_kontakt'))
        <label class="errorMsg">{{ \Illuminate\Support\Facades\Session::get('error_kontakt') }}</label>
    @endif
    @if(\Illuminate\Support\Facades\Session::has('msg_kontakt'))
        <label class="erfolgreichMsg">{{ \Illuminate\Support\Facades\Session::get('msg_kontakt') }}</label>
    @endif





    <h1 class="headline">Newsletter</h1>

    <div class="defaultContainer">
        <p>Wenn Sie immer über die neusten Veranstaltungen informiert werden möchten,
            dann ist der Bewo-Paiva Newsletter genau richtig!
        </p>
    </div>

    <div class="formContainer">
        <form action="{{ route('insertNewsletter') }}" id="formNews" method="POST" name="form">
            @csrf

            <label id="nameLabel">Name</label>
            <input type="text" name="name" placeholder="Name eingeben" required>

            <label id="emailLabel">E-mail</label>
            <input type="email" name="email" placeholder="Email eingeben" required>

            <label id="checkLabel" class="checkbox-container">
                <input type="checkbox" name="datenschutz" value="akzeptiert" required>
                <span>Ich habe die <a href="/Datenschutz" target="_blank">Datenschutzbestimmungen</a> gelesen und akzeptiere sie.</span>
            </label>
            <input type="hidden" name="form_name" value="form">

            <input type="hidden" id="g-recaptcha-response_news" name="g-recaptcha-response">
            <button class="buttonLogin" type="button" onclick="executeReCaptchaNews()">Absenden</button>

        </form>
        <script src="https://www.google.com/recaptcha/api.js?render=6Ldz2vQqAAAAAMAYAJ9W4msLDowqxzh9qkWS0gv7"></script>

        <script>
            function executeReCaptchaNews() {
                grecaptcha.ready(function () {
                    grecaptcha.execute('6Ldz2vQqAAAAAMAYAJ9W4msLDowqxzh9qkWS0gv7', { action: 'submit' }).then(function (token) {
                        document.getElementById('g-recaptcha-response_news').value = token;
                        document.getElementById("formNews").submit();
                    });
                });
            }
        </script>
    </div>

    @if(\Illuminate\Support\Facades\Session::has('error'))
        <label class="errorMsg">{{ \Illuminate\Support\Facades\Session::get('error') }}</label>
    @endif
    @if(\Illuminate\Support\Facades\Session::has('msg'))
        <label class="erfolgreichMsg">{{ \Illuminate\Support\Facades\Session::get('msg') }}</label>
    @endif



    <h1 class="headline">So finden Sie uns</h1>
    <div class="defaultContainer">
        <p>Bahnhofstraße 33, 52146 Würselen</p>
        <p>Besuchen Sie uns vor Ort oder planen Sie Ihre Anfahrt direkt über Google Maps:</p>
    </div>


    <iframe
        class="map-container"
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2511.643331196265!2d6.132528915935562!3d50.81865857952807!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c0970c38b9f993%3A0x6d3d2cfcd82e40da!2sBahnhofstra%C3%9Fe%2033%2C%2052146%20W%C3%BCrselen!5e0!3m2!1sen!2sde!4v1234567890123!5m2!1sen!2sde"
        allowfullscreen=""
        loading="lazy">
    </iframe>



@endsection
