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
            'name' => 'Admin FotoModerna',
            'email' => 'admin@fotomoderna.com',
            'password' => bcrypt('password123'),
        ]);
        $admin->assignRole($adminRole);

        // Crea utente fotografo
        $photographer = User::create([
            'name' => 'Marco Rossi',
            'email' => 'marco@fotomoderna.com',
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
            'name' => 'Matrimonio Villa Parco',
            'event_date' => now()->addDays(10),
            'location' => 'Villa del Parco, Milano',
            'description' => 'Matrimonio elegante con cerimonia in giardino',
            'photographer_id' => $photographer->id,
            'status' => 'planned',
        ]);

        Event::create([
            'name' => 'Compleanno 18 anni',
            'event_date' => now()->subDays(2),
            'location' => 'Location Centrale, Roma',
            'description' => 'Festa di compleanno con tema dorato',
            'photographer_id' => $photographer->id,
            'status' => 'ongoing',
        ]);

        Event::create([
            'name' => 'Laurea Medicina',
            'event_date' => now()->subDays(7),
            'location' => 'Università Statale, Bologna',
            'description' => 'Servizio fotografico laurea',
            'photographer_id' => $photographer2->id,
            'status' => 'completed',
        ]);

        $this->command->info('Ruoli e utenti di test creati con successo!');
        $this->command->info('Admin: admin@fotomoderna.com / password123');
        $this->command->info('Fotografo Marco: marco@fotomoderna.com / password123');
        $this->command->info('Fotografa Laura: laura@fotomoderna.com / password123');
    }
}
