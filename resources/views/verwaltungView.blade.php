@extends('defaultLayout')



@section("main-content")


    <h2>Hinweise:</h2>
    <div class="defaultContainer">
        <p>Hier können Sie verschiedene Inhalt einfügen. Bitte, wenn es geht, keine Bilder über 800x900 Pixel einfügen.
            <br>
            Name und Postion müssen eingegeben werden!

        </p>
    </div>


    <h2>Mitglieder einfügen</h2>
    <div class="formContainer">

        <form action={{ route('insertVerwaltung')}} method="POST" id="form1" name="form1" enctype="multipart/form-data" >
            @csrf
            <label id="nameLabel">Name</label>
            <input type="text" name="name" placeholder="Namen eingeben" required>

            <label id="posLabel">Position</label>
            <input type="text" name="position" placeholder="Stelle angeben" required>

            <label id="emailLabel">E-Mail</label>
            <input type="email" name="email" placeholder="E-Mail eingeben" >

            <label id="telLabel">Telefon</label>
            <input type="tel" name="telefon" placeholder="Telefonnummer eingeben" >

            <label id="bildLabel">Bild einfügen</label>
            <input type="file" name="bild">

            <label id="textLabel">Text:</label>
            <textarea name="text" placeholder="Beschreibung hinzufügen"></textarea>

            <input type="hidden" name="form_name" value="form1">

            <input type="submit" value="Einpflegen">
        </form>
    </div>
    @if(\Illuminate\Support\Facades\Session::has('error'))
        <label class="errorMsg" >{{\Illuminate\Support\Facades\Session::get("error")}}</label>
    @endif
    @if(\Illuminate\Support\Facades\Session::has("msg"))
        <label class="erfolgreichMsg" >{{\Illuminate\Support\Facades\Session::get("msg")}}</label>
    @endif

  <hr>






    <h2>Aktuelles einfügen</h2>
    <div class="formContainer">

        <form action= {{route('insertVerwaltung')}} id="form2" method="POST"  name="form2" enctype="multipart/form-data" >
            @csrf
            <label id="datumLabel">Datum</label>
            <input type="date" name="datum" placeholder="Datum eingeben" required>

            <label id="veranstaltungLabel">Position</label>
            <input type="text" name="veranstaltung" placeholder="Veranstaltung eingeben" required>

            <label id="bildLabel">Bild einfügen</label>
            <input type="file" name="bild">

            <input type="hidden" name="form_name_2" value="form2">

            <label id="textLabel">Text:</label>
            <textarea name="text" placeholder="Beschreibung hinzufügen"></textarea>
            <input type="submit" value="Einpflegen">
        </form>
    </div>
    @if(\Illuminate\Support\Facades\Session::has('error_2'))
        <label class="errorMsg" >{{\Illuminate\Support\Facades\Session::get("error_2")}}</label>
    @endif
    @if(\Illuminate\Support\Facades\Session::has("msg_2"))
        <label class="erfolgreichMsg" >{{\Illuminate\Support\Facades\Session::get("msg_2")}}</label>
    @endif
    <button class="buttonLogin"  onclick="actionAdminsVerwalten()" >Admins verwalten</button>

    <script>
        function actionAdminsVerwalten(){
            window.location.href="/Übersicht"
        }

    </script>


@endsection
