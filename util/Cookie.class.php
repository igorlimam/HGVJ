<?php

class Cookie {
    
    public static function mudou_banco(){
        $cookie = self::get_cookie("s");
        if($cookie == md5(Hash::$SALT.$_SESSION["banco"].$_SESSION['id_pessoa'].$_SESSION['id_usuario'].$_SESSION['permissao'].Hash::$SALT)){
            return false;
        }
        return true;
    }
    
    public static function set_cookie_banco($key, $banco) {
        setcookie($key, $banco, (time() + (60 * 60 * 2)));
    }
    
    public static function get_cookie($key){
        if(isset($_COOKIE[$key])){
            return $_COOKIE[$key];
        }
    }
    
    public static function destroy_cookie($key){
        if(isset($_COOKIE[$key])){
            setcookie($key);
        }
    }
}

?>
