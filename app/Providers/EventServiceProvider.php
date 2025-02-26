<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            // Add some items to the menu...
           // $event->menu->add('MAIN NAVIGATION');
           $event->menu->add(
           [
            'text'        => 'Reservas',
            'url'         => 'admin/reservas',
            'icon'        => 'fa fa-calendar-check',

        ],

        [
            'text'        => 'Clientes',
            'url'         => 'admin/clientes',
            'icon'        => 'fa fa-user-plus',

        ],
      
        [
            'text'        => 'Cabañas',
            'url'         => 'admin/cabanias',
            'icon'        => 'fa fa-home',

        ],

        [
            'text'        => 'Movimientos',
            'url'         => 'admin/movimientos',
            'icon'        => 'fa fa-archive',

        ],

        [
            'text'        => 'Tareas',
            'url'         => 'admin/tareas',
            'icon'        => 'fa fa-server',

        ],

        [
            'text'        => 'Precio',
            'url'         => 'admin/precios',
            'icon'        => 'fa fa-envelope',

        ],

        [
            'text'        => 'Caracteristicas',
            'url'         => 'admin/caracteristicas',
            'icon'        => 'fa fa-list',

        ],

        [
            'text'        => 'Categorias',
            'url'         => 'admin/categorias',
            'icon'        => 'fa fa-bars',

        ],

        [
            'text'        => 'Usuarios',
            'url'         => 'admin/users',
            'icon'        => 'fa fa-users',

        ]

    );
           
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
