@extends("defaultLayout")



@section("main-content")


<h1>Mitarbeiter Login</h1>



<div class="formContainer">
    <form  method="POST">
        @csrf
        <label id="nameLabel">Name</label>
        <input type="text" name="name" placeholder="Benutzernamen eingeben" required>

        <label id="pwLabel">Passwort</label>
        <input type="password" name="password" placeholder="Passwort eingeben" required>

        <input type="submit" value="Einloggen">
    </form>
</div>

@if(\Illuminate\Support\Facades\Session::has('msg'))
    <label class="errorMsg" >{{\Illuminate\Support\Facades\Session::get("msg")}}</label>

@endif
@endsection
