<?php
namespace {

    // This allow us to configure the behavior of the "global mock"
    $mockSocket = false;
}

namespace Dteruel\Clients {

    // And this here, does the trick: it will override the socket_create()
    // function in your code *just for the namespace* where you are defining it.
    // This relies on the code above calling the socket_create function without
    // the leading backslash, so we trick SomeClass into calling our own function
    // inside that namespace instead of the global socket_create function.
    function socket_create()
    {
        global $mockSocket;
        if (isset($mockSocket) && $mockSocket === true) {
            return false;
        } else {
            return call_user_func_array('\socket_create', func_get_args());
        }
    }

    function socket_connect()
    {
        global $mockSocket;
        if (isset($mockSocket) && $mockSocket === true) {
            return false;
        } else {
            return call_user_func_array('\socket_connect', func_get_args());
        }
    }

    function socket_close()
    {
        global $mockSocket;
        if (isset($mockSocket) && $mockSocket === true) {
            return false;
        } else {
            return call_user_func_array('\socket_close', func_get_args());
        }
    }

    function socket_read()
    {
        global $mockSocket;
        if (isset($mockSocket) && $mockSocket === true) {
            return "";
        } else {
            return call_user_func_array('\socket_read', func_get_args());
        }
    }
}
