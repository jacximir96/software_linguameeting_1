<?php

namespace App\Src\MessagingDomain\Thread\Model;

use App\Src\MessagingDomain\Message\Model\Message;
use App\Src\MessagingDomain\Participant\Model\Participant;
use App\Src\MessagingDomain\ThreadRead\Model\ThreadRead;
use App\Src\Shared\Model\HashIdable;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Thread extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    protected $table = 'thread';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function message()
    {
        return $this->hasMany(Message::class, 'thread_id')->orderBy('id', 'asc');
    }

    public function participant()
    {
        return $this->hasMany(Participant::class);
    }

    public function read()
    {
        return $this->hasMany(ThreadRead::class);
    }

    public function writer()
    {
        return $this->belongsTo(User::class, 'writer_id');
    }

    public function isOwner(User $user): bool
    {
        return $this->writer_id == $user->id;
    }

    public function readForUser(User $user): bool
    {

        return $this->read()
            ->where('thread_id', $this->id)
            ->where('user_id', $user->id)
            ->exists();
    }

    public function infoReadForUser(User $user)
    {
        return $this->read()
            ->where('thread_id', $this->id)
            ->where('user_id', $user->id)
            ->first();
    }
}
