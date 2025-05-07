<!-- layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Télésanté Bénin')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('additional_css')
</head>
<body>
    @include('components.header')
    
    <main>
        @yield('content')
    </main>
    
    @include('components.footer')
    
    <script src="{{ asset('js/script.js') }}"></script>
    @yield('additional_js')
</body>
</html>

<!-- components/header.blade.php -->
<header>
    <div class="logo">TÉLÉSANTÉ BÉNIN</div>
    <nav>
        <a href="{{ route('accueil') }}"><span>Accueil</span></a>
        <a href="{{ route('accueil') }}#services"><span>Services</span></a>
        <a href="{{ route('accueil') }}#medecins"><span>Médecins</span></a>
        <a href="{{ route('contact') }}"><span>Contact</span></a>
    </nav>
    <div>
        <span class="lang">Français ▼</span>
        <a href="{{ route('connexion') }}"><span class="login">Connexion</span></a>
    </div>
</header>

<!-- components/footer.blade.php -->
<footer>
    <div class="footer-content">
        <p><strong>Télésanté Bénin</strong> &copy; {{ date('Y') }}. Tous droits réservés.</p>
        <p>
            <a href="{{ route('accueil') }}">Accueil</a> |
            <a href="{{ route('a-propos') }}">À propos</a> |
            <a href="{{ route('contact') }}">Contact</a>
        </p>
    </div>
</footer>

<!-- components/service-card.blade.php -->
<div class="card">
    <div class="card-icon">{{ $service['icon'] }}</div>
    <div class="card-title">{{ $service['titre'] }}</div>
    <div class="card-text">{{ $service['description'] }}</div>
</div>

<!-- components/doctor-card.blade.php -->
<div class="doctor-card">
    <div class="doctor-photo">
        <img src="{{ asset($medecin['photo']) }}" alt="{{ $medecin['nom'] }}">
    </div>
    <div class="doctor-name">{{ $medecin['nom'] }}</div>
    <div>{{ $medecin['specialite'] }}</div>
    <div>
        @for ($i = 1; $i <= 5; $i++)
            @if ($i <= floor($medecin['note']))
                ★
            @elseif ($i - $medecin['note'] < 1 && $i - $medecin['note'] > 0)
                ★
            @else
                ☆
            @endif
        @endfor
        ({{ $medecin['note'] }})
    </div>
    <button class="consult-btn">Consulter</button>
</div>

<!-- pages/accueil.blade.php -->
@extends('layouts.app')

@section('title', 'Accueil - Télésanté Bénin')

@section('content')
    <section class="hero">
        <div class="hero-text">
            <h1>Des soins médicaux de qualité,<br>où que vous soyez au Bénin</h1>
            <p>Consultez des médecins qualifiés par vidéo ou chat,</p>
            <p>gérez votre dossier médical et recevez vos médicaments,</p>
            <p>le tout depuis votre domicile.</p>
            <div class="buttons">
                <a href="{{ route('inscription') }}"><button class="btn-primary">Créer un compte</button></a>
                <a href="{{ route('connexion') }}"><button class="btn-secondary">Se connecter</button></a>
            </div>
        </div>
        <div class="hero-image">
            <div>Image d'un médecin avec un patient</div>
            <div>en consultation vidéo</div>
        </div>
    </section>

    <section class="section" id="services">
        <h2>Nos Services</h2>
        <div class="cards-container">
            <div class="cards" id="services-cards">
                @foreach($services as $service)
                    @include('components.service-card', ['service' => $service])
                @endforeach
            </div>
        </div>
        <div class="scroll-buttons">
            <button class="scroll-btn scroll-left-services" id="scroll-left-services">&#8592;</button>
            <button class="scroll-btn scroll-right-services" id="scroll-right-services">&#8594;</button>
        </div>
    </section>

    <section class="section" id="medecins">
        <h2>Médecins disponibles</h2>
        <div class="cards-container">
            <div class="cards" id="doctors-cards">
                @foreach($medecins as $medecin)
                    @include('components.doctor-card', ['medecin' => $medecin])
                @endforeach
            </div>
        </div>
        <div class="scroll-buttons">
            <button class="scroll-btn scroll-left-doctors" id="scroll-left-doctors">&#8592;</button>
            <button class="scroll-btn scroll-right-doctors" id="scroll-right-doctors">&#8594;</button>
        </div>
    </section>
@endsection

<!-- pages/contact.blade.php -->
@extends('layouts.app')

@section('title', 'Contact - Télésanté Bénin')

@section('content')
    <section class="contact-section">
        <h1>Contactez-nous</h1>
        <div class="contact-container">
            <div class="contact-form">
                <form>
                    <div class="form-group">
                        <label for="name">Nom complet</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="tel" id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="6" required></textarea>
                    </div>
                    <button type="submit" class="btn-primary">Envoyer</button>
                </form>
            </div>
            <div class="contact-info">
                <h3>Nos coordonnées</h3>
                <p><strong>Adresse :</strong> Cotonou, Bénin</p>
                <p><strong>Email :</strong> contact@telesante-benin.com</p>
                <p><strong>Téléphone :</strong> +229 XX XX XX XX</p>
                <div class="social-media">
                    <a href="#" class="social-icon">Facebook</a>
                    <a href="#" class="social-icon">Twitter</a>
                    <a href="#" class="social-icon">Instagram</a>
                </div>
            </div>
        </div>
    </section>
@endsection

<!-- pages/connexion.blade.php -->
@extends('layouts.app')

@section('title', 'Connexion - Télésanté Bénin')

@section('content')
    <section class="auth-section">
        <div class="auth-container">
            <h1>Connexion</h1>
            <form class="auth-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-options">
                    <div>
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Se souvenir de moi</label>
                    </div>
                    <a href="#" class="forgot-password">Mot de passe oublié?</a>
                </div>
                <button type="submit" class="btn-primary full-width">Se connecter</button>
            </form>
            <div class="auth-footer">
                <p>Vous n'avez pas de compte? <a href="{{ route('inscription') }}">Inscrivez-vous</a></p>
            </div>
        </div>
    </section>
@endsection

<!-- pages/inscription.blade.php -->
@extends('layouts.app')

@section('title', 'Inscription - Télésanté Bénin')

@section('content')
    <section class="auth-section">
        <div class="auth-container">
            <h1>Créer un compte</h1>
            <form class="auth-form">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="telephone">Téléphone</label>
                    <input type="tel" id="telephone" name="telephone" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>
                <div class="form-options">
                    <div>
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">J'accepte les <a href="#">conditions d'utilisation</a></label>
                    </div>
                </div>
                <button type="submit" class="btn-primary full-width">S'inscrire</button>
            </form>
            <div class="auth-footer">
                <p>Vous avez déjà un compte? <a href="{{ route('connexion') }}">Connectez-vous</a></p>
            </div>
        </div>
    </section>
@endsection