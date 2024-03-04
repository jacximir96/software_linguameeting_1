@if ($user->isLocked())
    <div class="row">
        <div class="col-12 alert alert-warning">
            This user is blocked. It has {{$user->minutesToEndLock()}} minutes left to auto unlock. To
            <a href="{{route('get.user.lock.remove', $user->id)}}"
               onclick="return confirm('Are you sure to remove user lock?');">remove the block manually click here</a>.
        </div>
    </div>
@endif
