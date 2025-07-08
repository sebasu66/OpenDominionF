<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        {{ strtoupper(app()->getLocale()) }} <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li><a href="{{ route('lang.switch', ['locale' => 'en']) }}">English</a></li>
        <li><a href="{{ route('lang.switch', ['locale' => 'es']) }}">Español</a></li>
    </ul>
</li>
