<?php
// company: PulseStream
// Developed by: Ngwang Shalom
// Location: Cameroon/Bamenda
// Languages: php/hack/javascript/node(library)
// position: Senior dev
//
//
// Please add your own description if you are a contributor
//
//
//

namespace Endpoints\Endpoint;

class EndpointPages
{
    public static function Failed()
    {
        // Handle login logic
        return '<h1 style="color:red; font-size:24;">failed respons</h1>';
    }

    public static function Success()
    {
        // Handle register logic
        return '<h1 style="color:green; font-size:24;">Succes respons</h1>';
    }

    public static function Warning()
    {
        // Handle logout logic
        return '<h1 style="color:yellow; font-size:24;">warning respons</h1>';
    }
}

