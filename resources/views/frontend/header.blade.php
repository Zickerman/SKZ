<nav class="navbar navbar-expand-md bg-success bg-gradient">
    <div class="container">
        <a class="navbar-brand d-md-none">Саракташский завод</a>
        <a class="navbar-brand d-none d-md-block">Саракташский консервный завод</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'text-white' : '' }}" aria-current="page" href="/">
                        Главная
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('catalog') ? 'text-white' : '' }}" href="/catalog">
                        Каталог
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('about') ? 'text-white' : '' }}" href="/about">
                        О нас
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('contacts') ? 'text-white' : '' }}" href="/contacts">
                        Контакты/Реквизиты
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('delivery') ? 'text-white' : '' }}" href="/delivery">
                        Доставка
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
