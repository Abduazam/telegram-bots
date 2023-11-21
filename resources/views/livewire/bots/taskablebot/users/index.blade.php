<div>
    @foreach($users as $user)
        <p>{{ $user->getFirstName() }}</p>
    @endforeach
</div>
