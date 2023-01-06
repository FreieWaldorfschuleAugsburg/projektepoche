<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('/') ?>"><i class="fas fa-puzzle-piece"></i> <?= lang('app.name') ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMobileToggle"
                aria-controls="navbarMobileToggle" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMobileToggle">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown" <?= getCurrentUser() && getCurrentUser()->getGroup()->isAdmin() ? '' : 'hidden' ?>>
                    <a class="nav-link dropdown-toggle" href="#" id="Submenu-Dropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-tachometer-alt"></i> <?= lang('menu.admin') ?>
                    </a>
                    <ul class="dropdown-menu rounded-3" aria-labelledby="Submenu-Dropdown">
                        <li><a class="dropdown-item" href="<?= base_url('/users') ?>"><i class="fas fa-users"></i> <?= lang('user.headline') ?></a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/votes') ?>"><i class="fas fa-poll"></i> <?= lang('vote.headline') ?></a></li>
                    </ul>
                </li>
            </ul>
            <div class="btn-group float-end">
                <a href="<?= base_url(getCurrentUser() ? 'logout' : 'login') ?>"
                   class="text-decoration-none text-light">
                    <?= getCurrentUser() ? '<i class="fas fa-sign-out-alt"></i> ' . lang('menu.self.logout') : '<i class="fas fa-sign-in-alt"></i>' . lang('menu.self.login') ?>
                </a>
            </div>
        </div>
    </div>
</nav>

<div class="container px-4 mt-4">