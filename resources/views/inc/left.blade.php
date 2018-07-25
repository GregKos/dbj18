<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link @if(Request::is('/')) active @endif" href="{{ route('siteindex') }}">
                    <span data-feather="home"></span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(Request::is('posts*')) active @endif" href="{{ route('posts.index') }}">
                    <span data-feather="file"></span>
                    Posts
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(Request::is('categories*')) active @endif" href="{{ route('categories.index') }}">
                    <span data-feather="folder"></span>
                    Categories
                </a>
            </li>
        </ul>
    </div>
</nav>