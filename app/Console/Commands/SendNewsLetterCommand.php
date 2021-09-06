<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\NewsLetterNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendNewsLetterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:newsletter
        {emails?*}: Correos electronicos a los cuales enviar directamente
        {--s|schedule: Si debe ser ejecutado directamente o no}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía un correo electrónico';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $emails = $this->argument('emails');
        $schedule = $this->option('schedule');

        $builder = User::query();
        if ($emails)
        {
            $builder->whereIn('email', $emails);
        }
        $builder->whereNotNull('email_verified_at');
        $count = $builder->count();

        if ($count)
        {
            $this->info("Se enviaran {$count} correos");
            if ($this->confirm('¿Estas de acuerdo?') || $schedule)
            {
                $this->output->progressStart($count);
                $builder->each(function (User $user)
                {
                    $user->notify(new NewsLetterNotification());
                    $this->output->progressAdvance();
                });
                $this->output->progressFinish();
                $this->info("Correos enviados");
                return;
            }
        }
        $this->info("no se envió ningún correo");
    }
}
