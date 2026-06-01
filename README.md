# https://sites.google.com/. vechio sito fotomoderna

# Fotomoderna - Gestionale Studio Fotografico

Web App completa per la gestione del flusso di lavoro tra fotografi sul campo, amministrazione e clienti finali.

## 🚀 Caratteristiche Principali

### Per i Fotografi

- **Dashboard mobile-friendly** ottimizzata per eventi live
- **Form di acquisizione lead** veloce durante gli eventi
- **Upload rapido foto** con associazione automatica al cliente
- **Gestione eventi** con stato real-time

### Per l'Amministrazione

- **Panoramica completa** di tutti i lead e foto
- **Workflow di pagamento** integrato
- **Generazione automatica** di link temporanei post-pagamento
- **Gestione ordini** con stati personalizzati

### Per i Clienti

- **Accesso esclusivo** alle gallery private
- **Download sicuro** con link temporanei (30 giorni)
- **Esperienza utente** ottimizzata per il download

## 🛠️ Stack Tecnologico

- **Backend**: Laravel 11 (PHP 8.2+)
- **Frontend**: Tailwind CSS, Blade Templates + Laravel Livewire
- **Database**: MySQL/PostgreSQL/SQLite
- **Autenticazione**: Laravel Breeze + Spatie Laravel-Permission
- **Storage**: Local Storage / Amazon S3
- **Email**: Laravel Mail con Temporary Signed URLs

## 📋 Requisiti di Sistema

- PHP 8.2 o superiore
- Composer
- Node.js & npm
- Database (MySQL, PostgreSQL, o SQLite)

## ⚡ Installazione Rapida

1. **Clona il repository**

    ```bash
    git clone <url-repository>
    cd Fotomoderna
    ```

2. **Installa le dipendenze**

    ```bash
    composer install
    npm install
    ```

3. **Configura l'ambiente**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Configura database** (modifica `.env`)

    ```env
    DB_CONNECTION=sqlite
    # oppure per MySQL/PostgreSQL:
    # DB_CONNECTION=mysql
    # DB_HOST=127.0.0.1
    # DB_PORT=3306
    # DB_DATABASE=fotomoderna
    # DB_USERNAME=root
    # DB_PASSWORD=
    ```

5. **Crea database SQLite** (se necessario)

    ```bash
    touch database/database.sqlite
    ```

6. **Esegui migration e seeder**

    ```bash
    php artisan migrate
    php artisan db:seed --class=RolesAndUsersSeeder
    ```

7. **Compila gli asset**

    ```bash
    npm run build
    ```

8. **Avvia il server**

    ```bash
    php artisan serve
    ```

9. **Accedi al sistema**
    - URL: http://127.0.0.1:8000
    - Admin: `admin@fotomoderna.com` / `password123`
    - Fotografo: `andrea@fotomoderna.com` / `password123`

## 🏗️ Architettura del Sistema

### Modelli Principali

- **User**: Utenti con ruoli (admin, fotografo)
- **Event**: Eventi fotografici
- **Lead**: Clienti prospect con anagrafica
- **Photo**: Foto caricate con metadata
- **Order**: Ordini con workflow di pagamento

### Routing Strategy

- `/admin/*` - Sezione amministratori
- `/fotografo/*` - Sezione fotografi
- `/download/{token}` - Accesso clienti con signed URLs

### Flusso di Lavoro

1. **Fotografo** crea lead durante evento
2. **Fotografo** carica foto associate al lead
3. **Admin** visualizza lead e crea ordine
4. **Admin** segna ordine come pagato
5. **Sistema** genera link temporaneo (30 giorni)
6. **Cliente** riceve email e accede alla gallery
7. **Cliente** scarica foto entro scadenza

## 🔒 Sistema di Sicurezza

- **Ruoli e Permessi**: Spatie Laravel-Permission
- **Middleware personalizzati**: AdminMiddleware, PhotographerMiddleware
- **Signed URLs**: Link temporanei con scadenza automatica
- **Validation**: Convalida lato server per tutti i form

## 📁 Struttura Directory

```
app/
├── Http/Controllers/
│   ├── Admin/              # Controller amministratori
│   ├── Photographer/       # Controller fotografi
│   └── DownloadController.php
├── Http/Middleware/        # Middleware personalizzati
├── Models/                 # Modelli Eloquent
database/migrations/        # Migration database
resources/views/
├── admin/                  # Viste amministratori
├── photographer/           # Viste fotografi
├── auth/                   # Autenticazione
└── layouts/                # Layout principali
routes/
├── web.php                 # Rotte web
└── auth.php               # Rotte autenticazione
```

## 🚦 Sviluppo e Testing

### Comandi Utili

```bash
# Avvia server di sviluppo
php artisan serve

# Compila asset in watch mode
npm run dev

# Crea nuova migration
php artisan make:migration create_table_name

# Crea nuovo controller
php artisan make:controller ExampleController

# Pulisci cache
php artisan optimize:clear
```

### Testing Database

```bash
# Reset database e re-seeding
php artisan migrate:fresh --seed
```

## 🚀 Deploy in Produzione

1. **Configura server web** (Apache/Nginx)
2. **Installa dipendenze senza dev**
    ```bash
    composer install --optimize-autoloader --no-dev
    ```
3. **Compila asset per produzione**
    ```bash
    npm run build
    ```
4. **Configura `.env`** per produzione
5. **Esegui ottimizzazioni**
    ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```

## 🤝 Contributi

Per contribuire al progetto:

1. Fork il repository
2. Crea un branch feature (`git checkout -b feature/AmazingFeature`)
3. Commit le modifiche (`git commit -m 'Add AmazingFeature'`)
4. Push al branch (`git push origin feature/AmazingFeature`)
5. Apri una Pull Request

## 📞 Supporto

Per domande o supporto:

- Documentazione Laravel 11: https://laravel.com/docs/11.x
- Issue tracker: [GitHub Issues]
- Email: support@fotomoderna.com

## 📄 Licenza

Questo progetto è rilasciato sotto licenza MIT. Vedi il file `LICENSE` per dettagli.

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
