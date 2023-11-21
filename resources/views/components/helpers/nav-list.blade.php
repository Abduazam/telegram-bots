<li class="nav-main-item">
    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="">
        <span class="nav-main-link-name">Bot</span>
    </a>
    <ul class="nav-main-submenu">
        @foreach($bots as $bot)
        <li class="nav-main-item">
            <a class="nav-main-link" href="{{ route('dashboard.bots.' . $bot->username . '.index') }}">
                <span class="nav-main-link-name">{{ $bot->name }}</span>
            </a>
        </li>
        @endforeach
    </ul>
</li>
