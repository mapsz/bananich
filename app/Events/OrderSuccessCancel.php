<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class OrderSuccessCancel
{
    use SerializesModels;

    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}
