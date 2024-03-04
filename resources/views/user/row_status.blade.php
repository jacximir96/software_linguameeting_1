@if ($user->status()->isBlocked())
    <div class="card border-0 py-0 mt-0">
        <div class="card-body my-0 py-0">
            @include('user.row_locked', ['user' => $user])
        </div>
    </div>
@elseif ($user->status()->isDeleted())
    <div class="card border-0 py-0 mt-0">
        <div class="card-body my-0 py-0">
            @include('user.row_deleted', ['user' => $user])
        </div>
    </div>
@elseif ($user->status()->isDisabled())
    <div class="card border-0 py-0 mt-0">
        <div class="card-body my-0 py-0">
            @include('user.row_disabled', ['user' => $user])
        </div>
    </div>
@endif
