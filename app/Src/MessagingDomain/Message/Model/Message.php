<?php
namespace App\Src\MessagingDomain\Message\Model;

use App\Src\MessagingDomain\File\Model\MessageFile;
use App\Src\MessagingDomain\Thread\Model\Thread;
use App\Src\Shared\Model\HashIdable;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class Message extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable, HashIdable;

    protected $table = 'thread_message';

    protected $dates = ['write_at', 'created_at', 'updated_at', 'deleted_at'];

    public function file()
    {
        return $this->hasMany(MessageFile::class, 'message_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isOwner(User $user): bool
    {
        return $this->user->isSame($user);
    }

    public function isSame(Message $message): bool
    {
        return $this->id == $message->id;
    }
}
