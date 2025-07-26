<?php



use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Http;
use App\Models\Talibe;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            Talibe::where('simulation_active', true)
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->each(function ($talibe) {
                    $offsetLat = mt_rand(-5, 5) / 10000;
                    $offsetLng = mt_rand(-5, 5) / 10000;

                    $newLat = $talibe->latitude + $offsetLat;
                    $newLng = $talibe->longitude + $offsetLng;

                    Http::post(config('app.url') . '/api/talibes/position', [
                        'talibe_id' => $talibe->id,
                        'latitude' => $newLat,
                        'longitude' => $newLng,

                    ]);
                });
        })->everyMinute(); // ⏱️ Laravel ≥ 10.22 requis !
    }
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
