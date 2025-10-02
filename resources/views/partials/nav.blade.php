<nav style="background-color: #f0f0f0; padding: 10px; border-radius: 6px; font-family: Arial, sans-serif;">
    <ul style="list-style: none; margin: 0; padding: 0; display: flex; justify-content: space-between; align-items: center;">
        <div style="display: flex; gap: 15px;">

            <li>
                <a href="{{ route('home') }}" style="text-decoration: none; color: #007bff; font-weight: bold; padding: 8px 12px; border-radius: 4px; transition: background-color 0.3s;">
                    Home
                </a>
            </li>

            @guest
            <li>
                <a href="{{ route('register') }}" style="text-decoration: none; color: #007bff; font-weight: bold; padding: 8px 12px; border-radius: 4px; transition: background-color 0.3s;">
                    Registreren
                </a>
            </li>
            @endguest

            @auth
            <li>
                <a href="{{ route('dashboard') }}" style="text-decoration: none; color: #007bff; font-weight: bold; padding: 8px 12px; border-radius: 4px; transition: background-color 0.3s;">
                    Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('messages') }}" style="text-decoration: none; color: #007bff; font-weight: bold; padding: 8px 12px; border-radius: 4px; transition: background-color 0.3s;">
                    Mijn berichten
                </a>
            </li>

            <li>
                <a href="{{ route('ad.create') }}" style="text-decoration: none; color: #007bff; font-weight: bold; padding: 8px 12px; border-radius: 4px; transition: background-color 0.3s;">
                    Nieuwe advertentie
                </a>
            </li>
            @endauth
        </div>

        @guest
        <div>
            <li>
                <form method="GET" action="{{ route('login') }}" style="margin: 0;">
                    <button type="submit" style="background-color: #007bff; color: white; border: none; padding: 8px 12px; border-radius: 4px; font-weight: bold; cursor: pointer;">
                        Inloggen
                    </button>
                </form>
            </li>
        </div>
        @endguest

        @auth
        <div>
            <li>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" style="background-color: #dc3545; color: white; border: none; padding: 8px 12px; border-radius: 4px; font-weight: bold; cursor: pointer;">
                        Uitloggen
                    </button>
                </form>
            </li>
        </div>
        @endauth
    </ul>
</nav>