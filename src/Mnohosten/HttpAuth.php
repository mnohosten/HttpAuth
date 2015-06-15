<?php
/**
 * Created by PhpStorm.
 * User: martinkrizan
 * Date: 15.06.15
 * Time: 17:22
 */

namespace Mnohosten;


class HttpAuth {

    private $username;
    private $password;
    private $realm = 'Basic Http Auth';
    private $message;

    function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function protect(){
        if(!$this->checkLogin()) {
            $this->authenticate();
        }
    }

    /**
     * @param string $realm
     */
    public function setRealm($realm)
    {
        $this->realm = (string)$realm;
    }

    /**
     * @param $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }



    protected function authenticate() {
        header("WWW-Authenticate: Basic realm=\"{$this->realm}\"");
        header('HTTP/1.0 401 Unauthorized');
        echo $this->message;
        exit;
    }

    protected function checkLogin() {
        if(isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
            list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) =
                explode(':', base64_decode(substr($_SERVER['REDIRECT_HTTP_AUTHORIZATION'], 6)));
        }
        if(!isset($_SERVER["PHP_AUTH_USER"])) {
            return FALSE;
        }
        return ($this->username == $_SERVER["PHP_AUTH_USER"])
        && ($this->password == $_SERVER["PHP_AUTH_PW"]);
    }

}
