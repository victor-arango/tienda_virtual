<?php
    class logout
    {

        
        public function __construct()
        {
            session_start();
            session_unset();

            //DESTRUCCION DE SESSION 
            session_destroy();
            header('location: '.base_url().'/login');
        }
    }







?>