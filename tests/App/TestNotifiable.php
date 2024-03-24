<?php

namespace Lotous\Elibom\Notifications\Tests\App;

use Illuminate\Notifications\Notifiable;

class TestNotifiable
{
    use Notifiable;

    public function getKey()
    {
        return 1;
    }
}