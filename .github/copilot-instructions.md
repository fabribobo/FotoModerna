# Laravel 11 Studio Fotografico - Web App Gestionale

## Progetto
Web App per gestire il flusso di lavoro tra fotografi sul campo, amministrazione e clienti finali.

## Stack Tecnologico
- Backend: Laravel 11 (PHP 8.2+)
- Frontend: Tailwind CSS, Blade Templates, Laravel Livewire
- Database: MySQL/PostgreSQL
- Gestione Ruoli: Spatie Laravel-Permission
- Storage: Amazon S3 o Local Storage
- Media Management: Spatie Media Library 
- Email: Temporary Signed URLs per download

## Ruoli Applicazione
### Fotografo
- Dashboard mobile-friendly
- Form acquisizione lead (Nome, Email, Telefono)
- Upload rapido foto associate a cliente/evento

### Amministrazione  
- Visualizzazione lead e foto
- Gestione ordini e servizi
- Workflow pagamento
- Generazione link temporaneo post-pagamento (30 giorni scadenza)

### Cliente
- Accesso gallery protetta post-pagamento
- Download file digitali entro validità link

## Architettura Database
- Users (con ruoli Spatie)
- Leads (clienti prospect)
- Events (eventi fotografici)
- Photos (media con Spatie Media Library)
- Orders (con stato pagamento e scadenza link)

## Routing Strategy
- /admin/* - Amministrazione
- /fotografo/* - Fotografi
- /download/* - Accesso clienti con signed URLs