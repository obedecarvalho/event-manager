# Event Manager

## Requirements

- PHP 8.2+
- Laravel 12+
- Filament 3.3+

## Instalation

### Dev

Install dependencies:
```
composer install
```

Configure .env:
```
cp .env.example .env
```

Create Docker Containers
```
sail up -d
```

Generate Application Key:
```
sail artisan key:generate
```

Database Migrate seeding Initial data
```
sail artisan migrate --seed
```

Seed Dev data
```
sail artisan db:seed --class=DevUserSeeder
sail artisan db:seed --class=DevUniqueSeeder
sail artisan db:seed --class=DevSeeder
```

Link Storage
```
sail artisan storage:link
```

Start queue
```
sail artisan queue:work
```

Application endpoint:
> http://localhost:8888/

Mailpit endpoint:
> http://localhost:8025/
