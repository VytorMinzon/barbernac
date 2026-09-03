<div class="site-shell">
    <header class="site-header">
        <nav class="site-navbar" aria-label="Navegação principal">
            <a class="site-brand" href="<?= BASE_URL ?>home" aria-label="BarberNac, início">
                <img src="<?= BASE_URL ?>assets/img/logo1.png" alt="BarberNac">
            </a>

            <div class="site-nav-links" id="site-navigation">
                <a href="<?= BASE_URL ?>home">Início</a>
                <a href="<?= BASE_URL ?>servico">Serviços</a>
                <a href="<?= BASE_URL ?>barbeiros">Barbeiros</a>
                <a href="<?= BASE_URL ?>contato">Contato</a>
            </div>

            <div class="site-nav-actions">
                <a class="site-login" href="#" data-bs-toggle="modal" data-bs-target="#modalLogin">Entrar</a>
                <button class="site-menu-toggle" id="site-menu-toggle" type="button" aria-controls="site-navigation" aria-expanded="false" aria-label="Abrir menu">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </nav>
    </header>
</div>

<div class="site-nav-overlay" id="site-nav-overlay"></div>

<script>
    (function() {
        const toggle = document.getElementById('site-menu-toggle');
        const navigation = document.getElementById('site-navigation');
        const overlay = document.getElementById('site-nav-overlay');

        if (!toggle || !navigation || !overlay) return;

        const closeMenu = function() {
            navigation.classList.remove('is-open');
            overlay.classList.remove('is-visible');
            toggle.setAttribute('aria-expanded', 'false');
            toggle.setAttribute('aria-label', 'Abrir menu');
        };

        toggle.addEventListener('click', function() {
            const isOpen = navigation.classList.toggle('is-open');
            overlay.classList.toggle('is-visible', isOpen);
            toggle.setAttribute('aria-expanded', String(isOpen));
            toggle.setAttribute('aria-label', isOpen ? 'Fechar menu' : 'Abrir menu');
        });

        overlay.addEventListener('click', closeMenu);
        navigation.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', closeMenu);
        });
    }());
</script>
