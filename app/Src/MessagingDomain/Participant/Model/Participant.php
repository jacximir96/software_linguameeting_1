<?php

namespace App\Src\MessagingDomain\Participant\Model;

use App\Src\MessagingDomain\Thread\Model\Thread;
use App\Src\Shared\Model\HashIdable;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Participant extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    protected $table = 'thread_participant';

    protected $dates = ['read_at', 'created_at', 'updated_at', 'deleted_at'];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isParticipant(User $user): bool
    {
        return $this->user_id == $user->id;
    }

    public function isRead(): bool
    {
        return ! is_null($this->read_at);
    }
}
