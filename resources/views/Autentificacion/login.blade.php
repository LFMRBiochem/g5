<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<form action="logincontroller" method="POST">
    {{ csrf_field() }}
    
    <label>Cve usuario</label>
    <input type="text" name="Cve_usuario" value="{{ old('Cve_usuario') }}">
    <strong>{{ $errors->first('Cve_usuario') }}</strong>
    <br>
    <label>Password</label>
    <input type="password" name="Password">
    <strong>{{ $errors->first('Password') }}</strong>
    <input type="submit" value="Iniciar">
</form>