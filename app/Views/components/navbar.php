<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('/') ?>">
            <img src="<?= base_url('/') ?>/assets/img/logo.png" width="30" height="30" class="d-inline-block align-top"
                 alt="">
            <?= lang('app.name.short') ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMobileToggle"
                aria-controls="navbarMobileToggle" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMobileToggle">
            <?php if ($user = getCurrentUser()): ?>
                <?php if ($user->getGroup()->isAdmin()): ?>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="Submenu-Dropdown" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-tachometer-alt"></i> <?= lang('menu.admin') ?>
                            </a>
                            <ul class="dropdown-menu rounded-3" aria-labelledby="Submenu-Dropdown">
                                <li><a class="dropdown-item" href="<?= base_url('/users') ?>"><i
                                                class="fas fa-users"></i> <?= lang('user.headline') ?></a></li>
                                <li><a class="dropdown-item" href="<?= base_url('/projects') ?>"><i
                                                class="fas fa-puzzle-piece"></i> <?= lang('project.headline') ?></a>
                                </li>
                                <li><a class="dropdown-item" href="<?= base_url('/voting') ?>"><i
                                                class="fas fa-poll"></i> <?= lang('vote.headline') ?></a></li>
                            </ul>
                        </li>
                    </ul>
                <?php else: ?>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
                <?php endif; ?>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i> <?= $user->getName() ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item disabled" href="#"><i
                                            class="fas fa-users"></i> <?= $user->getGroup()->getName() ?></a></li>
                            <?php if ($user->isLeader()): ?>
                                <li><a class="dropdown-item" href="<?= base_url('/leading') ?>"><i
                                                class="fas fa-address-book"></i> <?= lang('user.leader.headline') ?></a>
                                </li>
                            <?php endif; ?>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?= base_url('logout') ?>"><i
                                            class="fas fa-sign-out-alt"></i> <?= lang('menu.self.logout') ?></a></li>
                        </ul>
                    </li>
                </ul>
            <?php else: ?>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('login') ?>"><i
                                    class="fas fa-sign-in-alt"></i> <?= lang('menu.self.login') ?></a></li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container px-4 mt-4">