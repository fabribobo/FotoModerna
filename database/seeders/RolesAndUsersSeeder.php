<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesAndUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crea i ruoli
        $adminRole = Role::create(['name' => 'admin']);
        $photographerRole = Role::create(['name' => 'fotografo']);

        // Crea utente amministratore
        $admin = User::create([
            'name' => 'Admin Fotomoderna',
            'email' => 'admin@fotomoderna.com',
            'password' => bcrypt('password123'),
        ]);
        $admin->assignRole($adminRole);

        // Crea utente fotografo
        $photographer = User::create([
            'name' => 'Marco Rossi',
            'email' => 'andrea@fotomoderna.com',
            'password' => bcrypt('password123'),
        ]);
        $photographer->assignRole($photographerRole);

        // Crea un secondo fotografo
        $photographer2 = User::create([
            'name' => 'Laura Bianchi',
            'email' => 'laura@fotomoderna.com',
            'password' => bcrypt('password123'),
        ]);
        $photographer2->assignRole($photographerRole);

        // Crea alcuni eventi di esempio
        Event::create([
            'name' => 'Laurea Ingegneria Informatica',
            'event_date' => now()->addDays(10),
            'location' => 'Università di Urbino, Urbino (PU)',
            'description' => 'Servizio fotografico laurea magistrale',
            'photographer_id' => $photographer->id,
            'status' => 'planned',
        ]);

        Event::create([
            'name' => 'Laurea Economia e Commercio',
            'event_date' => now()->subDays(2),
            'location' => 'Università di Urbino, Urbino (PU)',
            'description' => 'Servizio fotografico laurea triennale',
            'photographer_id' => $photographer->id,
            'status' => 'ongoing',
        ]);

        Event::create([
            'name' => 'Laurea Medicina e Chirurgia',
            'event_date' => now()->subDays(7),
            'location' => 'Università di Urbino, Urbino (PU)',
            'description' => 'Servizio fotografico laurea magistrale a ciclo unico',
            'photographer_id' => $photographer2->id,
            'status' => 'completed',
        ]);

        $this->command->info('Ruoli e utenti di test creati con successo!');
        $this->command->info('Admin: admin@fotomoderna.com / password123');
        $this->command->info('Fotografo Marco: andrea@fotomoderna.com / password123');
        $this->command->info('Fotografa Laura: laura@fotomoderna.com / password123');
    }
}
