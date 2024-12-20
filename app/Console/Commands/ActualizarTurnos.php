<?php

namespace App\Console\Commands;

use App\Models\Turno;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ActualizarTurnos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'actualizar_turnos:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ayer = Carbon::yesterday();
           
        $turnos = Turno::where('id_estado_turnos', 1)
        ->where('fecha','<', $ayer->format('Y-m-d'))->get();

        foreach($turnos as $turno)
        {
            $turno->id_estado_turnos = 3;
            $turno->save();
        }
        
        return true;
    }
}
