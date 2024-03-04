<?php

namespace App\Console\Commands;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceRegister\Mail\ReminderEmail;
use App\Src\ExperienceDomain\ExperienceRegister\Model\ExperienceRegister;
use App\Src\ExperienceDomain\ExperienceRegisterPublic\Mail\PublicReminderEmail;
use App\Src\ExperienceDomain\ExperienceRegisterPublic\Model\ExperienceRegisterPublic;
use App\Src\Localization\TimeZone\Repository\TimeZoneRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SenderReminderExperienceEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'linguameeting:send-experience-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar emails recordatorios de experiencias.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        try{

            DB::beginTransaction();;

            $timezone = TimeZoneRepository::findByName(config('linguameeting.timezone.by_default_in_experiences'));

            /** ESTO ES UNA PRUEBA SOLO PARA IMPLEMENTAR EL EMAIL */
            /** FALTA POR AÑADIR LA LÓGICA PARA OBTENER LAS EXPERIENCIAS A LAS QUE HAY QUE ENVIAR EL RECORDATORIO */

            //estudiante de linguameeting
            //$experience = ExperienceRegister::orderBy('id', 'desc')->first();
            //Mail::to('prueba@gmail.com')->queue((new ReminderEmail($experience, $timezone))->onQueue('emails'));

            //usuario público
            $experience = ExperienceRegisterPublic::orderBy('id', 'desc')->first();
            Mail::to('prueba@gmail.com')->queue((new PublicReminderEmail($experience, $timezone))->onQueue('emails'));

            DB::commit();


            return Command::SUCCESS;

        }
        catch (\Throwable $exception){

            dd($exception);
        }
    }
}
