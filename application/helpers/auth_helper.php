<?php 
    class Auth
        {
            public static function UserLogin()
                {
                    $CI =& get_instance();

                    if($CI->session->userdata('login') != true)
                        {
                            redirect(base_url());
                        }

                    // if($CI->session->userdata('id_level') != '1' || $CI->session->userdata('id_level') != '2')
                    //     {
                    //         redirect(base_url());
                    //     }
                    
                }
        }