<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Login extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        parent::__construct();
    }

        // Check for user login process
        public function login()
        {
			// Esto va a fallar siempre. La cosa es que password_verify acepta dos argumentos, la
			// pass y un hash. La idea es que te conectes a la base de datos, leas el hash y lo
			// compares con una contrasenya. Eso iria mejor dentro de una clase de modelo. No se si lo
			// sabrias ya, pero si no, ya te lo digo yo xD
			
            if (password_verify('admin', 'olakase')) {
                echo '¡La contraseña es válida!';
            } else {
                echo 'La contraseña no es válida.';
            }
        }
}