@extends("defaultLayout")

@section("main-content")

    <div style="position: fixed; bottom: 0; left: 0;">
        <button class="buttonLogin" onclick="onClickAbmelden()">Abmelden</button>
    </div>
    <script>
        function onClickAbmelden(){
            window.location.href ="/Abmelden"
        }
    </script>



    <h1 class="headline">Übersicht</h1>

    <div class="übersicht">
        <table class="mitarbeiter-tabelle">
            <thead>
            <tr>
                <th>Name</th>
                <th>ID</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item["name"] }}</td>
                    <td>{{ $item["id"] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

     <form class="formContainer" action="{{route("Delete")}}" id="formDelete"  name="formDelete" method="post" >
         @csrf
         <p>Geben Sie zum Löschen die ID ein:</p>
         <input type="text" name="id"  placeholder="ID eingeben" required >
         <input type="submit" value="Löschen">
         <input type="hidden" name="form1" value="1">
     </form>

    @if(\Illuminate\Support\Facades\Session::has("error_1"))
        <label class="errorMsg">{{ \Illuminate\Support\Facades\Session::get('error_1') }}</label>
    @endif
    @if(\Illuminate\Support\Facades\Session::has("msg_1"))
        <label class="erfolgreichMsg">{{ \Illuminate\Support\Facades\Session::get('msg_1') }}</label>
    @endif


    <h1 class="headline">Abonnierte Newsletter</h1>

    <div class="übersicht">
        <table class="mitarbeiter-tabelle">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Zustimmung</th>

            </tr>
            </thead>
            <tbody>
            @foreach($data_2 as $item)
                <tr>
                    <td>{{ $item["name"] }}</td>
                    <td>{{$item["email"]}}</td>
                    <td>{{$item["consent_given_at"]}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <form name="formDelete2"  class="formContainer" action="{{route("Delete")}}" id="formDelete2"  method="post" >
        @csrf
        <p>Geben Sie zum Löschen den Namen des Abonnenten ein:</p>
        <input type="text" name="name"  placeholder="Name eingeben" required >
        <input type="hidden" name="form2" value="2">
        <input type="submit" value="Löschen">
    </form>

    @if(\Illuminate\Support\Facades\Session::has("error_2"))
        <label class="errorMsg">{{ \Illuminate\Support\Facades\Session::get('error_2') }}</label>
    @endif
    @if(\Illuminate\Support\Facades\Session::has("msg_2"))
        <label class="erfolgreichMsg">{{ \Illuminate\Support\Facades\Session::get('msg_2') }}</label>
    @endif



    <div class="übersicht">
        <table class="mitarbeiter-tabelle">
            <thead>
            <tr>
                <th>Veranstaltung</th>
                <th>Datum</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data_3 as $item)
                <tr>
                    <td>{{ $item["veranstaltung"] }}</td>
                    <td>{{$item["datum"]}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <form name="formDelete3"  class="formContainer" action="{{route("Delete")}}" id="formDelete3"  method="post" >
        @csrf
        <p>Geben Sie zum Löschen die Veranstaltung ein:</p>
        <input type="text" name="veranstaltung"  placeholder="Veranstaltung" required >
        <input type="hidden" name="form3" value="3">
        <input type="submit" value="Löschen">
    </form>
    @if(\Illuminate\Support\Facades\Session::has("error_3"))
        <label class="errorMsg">{{ \Illuminate\Support\Facades\Session::get('error_3') }}</label>
    @endif
    @if(\Illuminate\Support\Facades\Session::has("msg_3"))
        <label class="erfolgreichMsg">{{ \Illuminate\Support\Facades\Session::get('msg_3') }}</label>
    @endif


@endsection
