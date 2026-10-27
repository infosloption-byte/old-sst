<?php

namespace App\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class WarBoardChangeNotify implements ShouldBroadcastNow
{
    use SerializesModels;

    public $department;

    function __construct($department)
    {
        $this->department = $department;
    }

    public function broadcastWith()
    {
        return ['message' => 'key'];
    }

    public function broadcastOn()
    {
        return ['warboard-change-'.$this->department->id];
    }
}

