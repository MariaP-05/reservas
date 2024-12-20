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
            'icon'        => 'fa fa-calendar',

        ],

        

        [
            'text'        => 'Clientes',
            'url'         => 'admin/clientes',
            'icon'        => 'fa fa-user-plus',

        ],
      
        [
            'text'        => 'Cabañas',
            'url'         => 'admin/cabanias',
            'icon'        => 'fa fa-hospital',

        ],
        [
            'text'        => 'Caracteristicas',
            'url'         => 'admin/caracteristicas',
            'icon'        => 'fa fa-address-card',

        ],
        [
            'text'        => 'Precio',
            'url'         => 'admin/precios',
            'icon'        => 'fa fa-address-card',

        ]
    );
         /*  if(!isset(Auth::user()->Profesional))
           {
            $event->menu->add(
                [
                    'text'        => 'Profesionales',
                    'url'         => 'admin/profesionales',
                    'icon'        => 'fa fa-user-md',
        
                ],
                [
                    'text'        => 'Especialidades',
                    'url'         => 'admin/especialidades',
                    'icon'        => 'fa fa-university',
        
                ],
                [
                'text' => 'Usuarios',
                'url' => 'admin/users',
                'icon'        => 'fa fa-user',

            ]);
           }*/
           
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
