<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationsLevel extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_notifications_level';

    protected $primaryKey = 'id_level_notification';

    public function color(): string
    {
        return match ($this->color_level_not) {

            'GREY' => '#DEDEDE',
            'BLUE' => '#17a2b8',
            'YELLOW' => '#f0ad4e',
            'RED' => '#FF4040',
        };
    }
}
