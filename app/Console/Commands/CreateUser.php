<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateUser extends Command
{
   protected $signature = 'user:create 
                            {nickname : Il nickname dell\'utente} 
                            {password : La password dell\'utente} 
                            {--admin : Se impostato, l\'utente sarà admin}';

    protected $description = 'Crea un nuovo utente nel database';

    public function handle()
    {
        $user = User::create([
            'nickname' => $this->argument('nickname'),
            'password' => bcrypt($this->argument('password')),
            'is_admin' => $this->option('admin') ? true : false,
        ]);

        $this->info("✅ Utente creato con successo: {$user->nickname}");
    }
}
