<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/app.scss']); ?>
</head>

<body class="">
    <?php echo $__env->yieldPushContent('scripts'); ?>
    <div id="app">
        <?php if(auth()->guard()->check()): ?>
            <nav class="navbar navbar-expand-md navbar-dark bg-primary">
                
                <div class="container">
                    <a class="navbar-brand" href="#"> <i class="bi bi-hexagon-fill"></i> <b>Data Master</b></a>
                    

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="<?php echo e(__('Toggle navigation')); ?>">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav flex-row flex-wrap">
                            <li class="nav-item col-2 col-md-auto"><a href="<?php echo e(route('home')); ?>" class="nav-link">Home</a>
                            </li>
                            <li class="nav-item col-2 col-md-auto"><a href="<?php echo e(route('employees.index')); ?>"
                                    class="nav-link">Employee</a></li>
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            <!-- Authentication Links -->
                            
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown">
                                    <?php echo e(Auth::user()->name); ?>

                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                        onclick="event.preventDefault();
                                                  document.getElementById('logout-form').submit();">
                                        <i class="bi bi-person-fill"></i> <?php echo e(__('My Profile')); ?>

                                    </a>
                                    <a class="dropdown-item bg-white text-danger" href="<?php echo e(route('logout')); ?>"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ed1f1f"
                                            class="bi bi-lock-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" />
                                        </svg> <?php echo e(__('Logout')); ?>

                                    </a>

                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                </div>
                            </li>
                            
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            <?php echo $__env->yieldContent('content'); ?>
            <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>
        </main>
    </div>
</body>

</html>
<?php /**PATH C:\Users\ASUS\praktikum-laravel\praktikum-modul9\resources\views/layouts/app.blade.php ENDPATH**/ ?>