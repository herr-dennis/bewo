@php use Illuminate\Support\Facades\Session; @endphp
@extends("defaultLayout")



@section("main-content")

    <h1>Logs</h1>
    <p class="defaultContainer">
        Hier werden alle Login-Versuche aufgelistet.
        Das ist nur für die recaptcha v3 von Google.
        Von Newsletter und Kontaktformular
    </p>
    <blockquote>
        @foreach($data as $value )
            <br>
            {{$value}}
        @endforeach
    </blockquote>

    <button class="buttonLogin" onclick="actionButtonLog()">
        Logs löschen
    </button>

    @if(Session::has("error"))
        <label class="errorMsg" >{{Session::get("error")}}</label>
    @endif
    @if(Session::has("msg"))
        <label class="erfolgreichMsg">{{Session::get("msg")}}</label>
    @endif

    <script>
        function actionButtonLog() {
            window.location.href = "/LogLöschen"
        }
    </script>

@endsection
