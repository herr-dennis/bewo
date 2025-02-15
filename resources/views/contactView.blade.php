@extends('defaultLayout')


@section("titel", "Bewo-Paiva Kontakt und Über uns")

@section("main-content")


    <h1 class="headline">Kontakt</h1>

    <div class="defaultContainer">
    <p>Schön, dass Sie da sind!
        Wir freuen uns über Ihr Interesse. Wenn Sie Fragen, Anregungen oder Wünsche haben, können Sie uns über das untenstehende Kontaktformular ganz unkompliziert erreichen.
        Teilen Sie uns einfach Ihren Namen, Ihre E-Mail-Adresse und Ihre Nachricht mit – wir melden uns so schnell wie möglich bei Ihnen.
        Vielen Dank für Ihr Vertrauen!</p>
</div>

    <div>

        <form class="formContainer" id="formKontakt" method="post" action="{{route("sendKontakt")}}" >
            @csrf
            <label id="überschriftForm" >Kontaktformular</label>
            <label>Ihr Name</label>
            <input type="text" name="name" placeholder="Ihr Name" required>
            <label>Ihre E-Mail</label>
            <input type="email" name="email" required  placeholder="Ihr E-Mail" >
            <label>Ihr Anliegen</label>
            <textarea name="text" required placeholder="Ihr Nachricht an uns!" >
            </textarea>
            <input  type="submit" placeholder="Abschicken" >
            <input type="text" name="website" style="display:none;">

        </form>
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

            <input type="submit" value="Ich möchte den Newsletter!">
        </form>
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
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2511.643331196265!2d6.132528915935562!3d50.81865857952807!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c0970c38b9f993%3A0x6d3d2cfcd82e40da!2sBahnhofstra%C3%9Fe%2033%2C%2052146%20W%C3%BCrselen!5e0!3m2!1sen!2sde!4v1234567890123!5m2!1sen!2sde"
        width="100%"
        height="400"
        style="border: 3px solid #5c2d91; margin-top: 20px"
        allowfullscreen=""
        loading="lazy">
    </iframe>



@endsection
