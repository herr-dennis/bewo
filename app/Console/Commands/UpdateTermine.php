<?php

namespace App\Console\Commands;

use App\Models\Termine;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class UpdateTermine extends Command
{

    protected $signature = 'update:termine';
    protected $description = 'Aktualisiert alte Termine: löscht oder verschiebt sie bei Wiederholung';

    public function handle()
    {
        $termine = Termine::query()->orderBy('datum')->get();
        $currentDate = Carbon::now('Europe/Berlin');

        foreach ($termine as $termineDatum) {
            $termin = Carbon::parse($termineDatum->datum);

            if ($termin->lt($currentDate->startOfDay())) {
                if ($termineDatum->wiederkehrend) {
                    $termineDatum->datum = $termin->addDays(7);
                    $termineDatum->save();
                    $this->info("Termin {$termineDatum->id} verschoben.");
                } else {
                    $termineDatum->delete();
                    $this->info("Termin {$termineDatum->id} gelöscht.");
                }
            }
        }

        $this->info('Alle Termine überprüft.');
    }
}
