<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'The Victorias Shool',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => true,
    'use_full_favicon' => true,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>TVS</b>',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Admin Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => false,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,
    'disable_darkmode_routes' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Asset Bundling
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Asset Bundling option for the admin panel.
    | Currently, the next modes are supported: 'mix', 'vite' and 'vite_js_only'.
    | When using 'vite_js_only', it's expected that your CSS is imported using
    | JavaScript. Typically, in your application's 'resources/js/app.js' file.
    | If you are not using any of these, leave it as 'false'.
    |
    | For detailed instructions you can look the asset bundling section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items y búsqueda (mantener existentes)
        [
            'type' => 'navbar-search',
            'text' => 'search',
            'topnav_right' => true,
        ],
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Menú reorganizado y renombrado
        [
            'text' => 'Dashboard',
            'url'  => '/home',  // Cambiado de '/dashboard' a '/home'
            'icon' => 'fas fa-fw fa-tachometer-alt',
            'can'  => 'view.dashboard',
        ],
        [
            'text' => 'Help-Desk Sistemas',
            'url'  => 'tickets',
            'icon' => 'fas fa-ticket-alt',
            'can'  => 'ticket.view',
            'active' => ['tickets*'],
            'classes' => 'menu-item'
        ],
        [
            'text' => 'Help-Desk RRHH',
            'icon' => 'fas fa-users',
            'classes' => 'menu-item',
            'submenu' => [
                [
                    'text' => 'Documentos',
                    'url'  => 'documents',
                    'icon' => 'fas fa-folder',
                    'can'  => 'documents',
                    'classes' => 'submenu-item'
                ],
                [
                    'text' => 'Solicitudes',
                    'url'  => 'document-requests',
                    'icon' => 'fas fa-paper-plane',
                    'can'  => 'document-requests',
                    'classes' => 'submenu-item'
                ],
            ],
        ],
        [
            'text' => 'Reserva de Equipos',
            'icon' => 'fas fa-laptop',
            'classes' => 'menu-item',
            'submenu' => [
                [
                    'text' => 'Inventario Inicial',
                    'url'  => 'equipment/inventory',
                    'icon' => 'fas fa-clipboard-list',
                    'can'  => 'equipment.manage',
                ],
                [
                    'text' => 'Gestionar Inventario',
                    'url'  => 'equipment',
                    'icon' => 'fas fa-boxes',
                    'can'  => 'equipment.inventory',
                ],
                [
                    'text' => 'Solicitar Préstamo',
                    'url'  => 'equipment/request',
                    'icon' => 'fas fa-hand-holding',
                    'can'  => 'equipment.reserva',
                ],
                [
                    'text' => 'Ver Préstamos',
                    'url'  => 'equipment/loans',
                    'icon' => 'fas fa-list',
                    'can'  => 'view.reservas',
                ],
            ],
        ],
        [
            'text' => 'Solicitudes de Mantenimiento',
            'url'  => 'maintenance',
            'icon' => 'fas fa-tools',
            'can'  => 'view.maintenance',
            'active' => ['maintenance*'],
            'classes' => 'menu-item'
        ],
        [
            'text' => 'Gestión Administrativa',
            'icon' => 'fas fa-building',
            'classes' => 'menu-item parent',
            'submenu' => [
                [
                    'text' => 'KPI´S Administrativos',
                    'icon' => 'fas fa-chart-line',
                    'can'  => 'view.kpis',
                    'classes' => 'submenu-item',
                    'submenu' => [
                        [
                            'text'    => 'Enfermería',
                            'icon'    => 'fas fa-heartbeat',
                            'submenu' => [
                                [
                                    'text' => 'Crear KPI',
                                    'url'  => 'enfermeria/kpis/create',
                                    'icon' => 'fas fa-plus-square',
                                    'can' => 'kpis.enfermeria.create',
                                ],
                                [
                                    'text' => 'Ver KPI',
                                    'url'  => 'enfermeria/kpis',
                                    'icon' => 'fas fa-chart-bar',
                                    'can' => 'kpis.enfermeria.index',
                                ],
                                [
                                    'text' => 'Crear Indicador',
                                    'url'  => 'enfermeria/umbral/create',
                                    'icon' => 'fas fa-sliders-h',
                                    'can' => 'umbral.enfermeria.create',
                                ],
                                [
                                    'text' => 'Indicadores',
                                    'url'  => 'enfermeria/umbral/show',
                                    'icon' => 'fas fa-list-alt',
                                    'can' => 'umbral.enfermeria.show',
                                ],
                            ],
                        ],
                        [
                            'text'    => 'Compras',
                            'icon'    => 'fas fa-shopping-cart',
                            'submenu' => [
                                [
                                    'text' => 'Crear KPI',
                                    'url'  => 'compras/kpis/create',
                                    'icon' => 'fas fa-plus-square',
                                    'can' => 'kpis.compras.create',
                                ],
                                [
                                    'text' => 'Ver KPI',
                                    'url'  => 'compras/kpis',
                                    'icon' => 'fas fa-chart-bar',
                                    'can' => 'kpis.compras.index',
                                ],
                                [
                                    'text' => 'Crear Indicador',
                                    'url'  => 'compras/umbral/create',
                                    'icon' => 'fas fa-sliders-h',
                                    'can' => 'umbral.compras.create',
                                ],
                                [
                                    'text' => 'Indicadores',
                                    'url'  => 'compras/umbral/show',
                                    'icon' => 'fas fa-list-alt',
                                    'can' => 'umbral.compras.show',
                                ],
                            ],
                        ],
                        [
                            'text'    => 'Recursos Humanos',
                            'icon'    => 'fas fa-users',
                            'submenu' => [
                                [
                                    'text' => 'Crear KPI',
                                    'url'  => 'rrhh/kpis/create',
                                    'icon' => 'fas fa-plus-square',
                                    'can' => 'kpis.recursoshumanos.create',
                                ],
                                [
                                    'text' => 'Ver KPI',
                                    'url'  => 'rrhh/kpis',
                                    'icon' => 'fas fa-chart-bar',
                                    'can' => 'kpis.recursoshumanos.index',
                                ],
                                [
                                    'text' => 'Crear Indicador',
                                    'url'  => 'rrhh/umbral/create',
                                    'icon' => 'fas fa-sliders-h',
                                    'can' => 'umbral.recursoshumanos.create',
                                ],
                                [
                                    'text' => 'Indicadores',
                                    'url'  => 'rrhh/umbral/show',
                                    'icon' => 'fas fa-list-alt',
                                    'can' => 'umbral.recursoshumanos.show',
                                ],
                            ],
                        ],
                        [
                            'text'    => 'Sistemas',
                            'icon'    => 'fas fa-laptop-code',
                            'submenu' => [
                                [
                                    'text' => 'Crear KPI',
                                    'url'  => 'sistemas/kpis/create',
                                    'icon' => 'fas fa-plus-square',
                                    'can' => 'kpis.sistemas.create',
                                ],
                                [
                                    'text' => 'Ver KPI',
                                    'url'  => 'sistemas/kpis',
                                    'icon' => 'fas fa-chart-bar',
                                    'can' => 'kpis.sistemas.index',
                                ],
                                [
                                    'text' => 'Crear Indicador',
                                    'url'  => 'sistemas/umbral/create',
                                    'icon' => 'fas fa-sliders-h',
                                    'can' => 'umbral.sistemas.create',
                                ],
                                [
                                    'text' => 'Indicadores',
                                    'url'  => 'sistemas/umbral/index',
                                    'icon' => 'fas fa-list-alt',
                                    'can' => 'umbral.sistemas.index',
                                ],

                            ],

                        ],
                        [
                            'text'    => 'Contabilidad',
                            'icon'    => 'fas fa-calculator',
                            'can'     => 'view.budget',
                            'submenu' => [
                                [
                                    'text' => 'Ejecución Presupuestal',
                                    'url'  => 'contabilidad/budget',
                                    'icon' => 'fas fa-money-bill',
                                    'can'  => 'Ejecución Presupuestal',
                                ],
                                [
                                    'text' => 'Registrar Presupuesto',
                                    'url'  => 'contabilidad/budget/create',
                                    'icon' => 'fas fa-plus-circle',
                                    'can'  => 'Registrar Presupuesto',
                                ],
                            ],
                        ],

                    ],
                ],
            ],
        ],

        // Mantener el resto de los items existentes
        [
            'text'    => 'Almacén',
            'icon'    => 'fas fa-warehouse',
            'can'     => 'ver almacen',
            'submenu' => [
                [
                    'text' => 'Proveedores',
                    'url'  => 'proveedores',
                    'icon' => 'fas fa-users',
                ],
                [
                    'text' => 'Evaluación de Proveedores',
                    'url'  => 'evaluaciones',
                    'icon' => 'fas fa-star',
                ],
            ],
        ],

        [
            'text' => 'Eventos',
            'url'  => 'events',
            'icon' => 'fas fa-calendar-plus',
            'can' => 'view.events',
        ],
        [
            'text' => 'Calendario de Eventos',
            'url'  => 'events/calendar',
            'icon' => 'fas fa-calendar',
            'can' => 'view.calendar',
        ],
        [
            'text'    => 'Informes',
            'icon'    => 'fas fa-chart-bar',
            'can'     => 'view.reports',
            'submenu' => [
                [
                    'text' => 'Informe Help-Desk',
                    'url'  => 'tickets/dashboard',
                    'icon' => 'fas fa-ticket-alt',
                ],
                [
                    'text' => 'Informe Mantenimiento',
                    'url'  => 'maintenance/dashboard',
                    'icon' => 'fas fa-tools',
                ],
                [
                    'text' => 'Informe Biométrico',
                    'url'  => 'attendance/dashboard/actual',
                    'icon' => 'fas fa-clock',
                ],
                [
                    'text' => 'Informe Ausentismos',
                    'url'  => 'ausentismos/dashboard',
                    'icon' => 'fas fa-chart-bar',
                ],
                [
                    'text' => 'Informe de Eventos',
                    'url'  => 'events/dashboard',
                    'icon' => 'fas fa-calendar-check',
                ],
                [
                    'text' => 'Informe de KPIs',
                    'url'  => 'admin/kpis/report',
                    'icon' => 'fa fa-chart-line',
                ],
                [
                    'text' => 'Informe Préstamo de Equipos',
                    'url'  => 'equipment/dashboard',
                    'icon' => 'fas fa-laptop',
                ],
            ],
           
        ],
        [
            'text' => 'profile',
            'url' => 'admin/settings',
            'icon' => 'fas fa-fw fa-user',
        ],
        [
            'text' => 'Usuarios',
            'url'  => 'admin/users',
            'icon' => 'fas fa-users',
            'can' => 'view.users',
        ],
        [
            'text' => 'Roles y Permisos',
            'url'  => 'admin/roles',
            'icon' => 'fas fa-user-shield',
            'can' => 'view.roles',
        ],

         [
            'text' => 'Subida de Información',
            'icon' => 'fas fa-upload',
            'can' => 'view.upload',
            'submenu' => [
                [
                    'text' => 'Subir Informe Biometrico',
                    'url'  => 'attendance/upload',
                    'icon' => 'fas fa-upload',
                ],
                 [
                    'text' => 'Subir Informe Ausentismos',
                    'url'  => 'ausentismos/upload',
                    'icon' => 'fas fa-upload',
                ],
            ],
         ],
        [
            'text' => 'Avisos Importantes',
            'icon' => 'fas fa-bullhorn',
            'can' => 'view.announcements',
            'submenu' => [
                [
                    'text' => 'Crear Aviso',
                    'url'  => 'announcements/create',
                    'icon' => 'fas fa-plus',
                ],
                [
                    'text' => 'Gestionar Avisos',
                    'url'  => 'announcements',
                    'icon' => 'fas fa-list',
                ],
            ],
        ],
        [
            'text' => 'Configuración',
            'icon' => 'fas fa-cogs',
            'can'  => 'manage.configuration',
            'submenu' => [
                [
                    'text' => 'Notificaciones',
                    'url'  => 'admin/configuration',
                    'icon' => 'fas fa-envelope',
                ],
            ],
        ],        
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@11',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        'Summernote' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,

    // Agregar estilos personalizados
    'custom_css' => '
        .menu-item {
            margin-bottom: 5px;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }
        .menu-item:hover, 
        .menu-item.active {
            border-left-color: #3498db;
            background: rgba(52, 152, 219, 0.1);
        }
        .submenu-item {
            padding-left: 15px;
            border-left: 2px solid transparent;
            transition: all 0.3s ease;
        }
        .submenu-item:hover,
        .submenu-item.active {
            border-left-color: #3498db;
            background: rgba(52, 152, 219, 0.05);
        }
        .nav-sidebar .nav-item > .nav-link {
            padding: 12px 15px;
        }
        .nav-sidebar .nav-link:focus {
            color: #fff;
            background-color: rgba(52, 152, 219, 0.2);
        }
        .nav-treeview {
            padding-left: 15px;
        }
        .nav-treeview > .nav-item > .nav-link {
            padding: 10px 15px;
        }
    ',
];