function login_validar(){
    var msg = new String();

    if( $('password').value ==""){
        msg = "El password no puede estar vacío";
        new Effect.Shake($('login-form'));
        $('password').focus();
    }
    if( $('usuario').value == "" ){
        msg = "El usuario no puede estar vacío";
        new Effect.Shake($('login-form'));
        $('usuario').focus();
    }
    if( msg.length > 0 ){
        alert( 'Error: ' + msg );
    }else{
        new Effect.Fade($('login-form'));
        $("form-login").submit();
    }
}