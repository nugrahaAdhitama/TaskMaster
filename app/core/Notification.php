<?php

namespace App\Core;

class Notification {

    public static function alert(string $message, string $uri) {
        return exit($message.header("Refresh: 2; URL=".BASE_URI.$uri));
    }

}
