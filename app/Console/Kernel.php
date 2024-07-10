<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\BotUserController;
use App\Models\BotUser;
use App\Models\Company;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {

            $botUsers = BotUser::all();

            foreach ($botUsers as $botUser) {
                $chat_id = $botUser->telegram_id;
                $modme_company_id = $botUser->modme_company_id;

                $company = Company::query()->where('modme_company_id', $modme_company_id)->first();
                $token = $company->modme_token;
                $company_name = $company->name;
                $lang = 'en';

                $controller = app()->make(BotUserController::class);
                $controller->plan_execution($chat_id, $token, $company_name, $lang);
            }
        })->dailyAt('22:33');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
