

Necessita intalar as dependencias via:

npm i

Instalar a biblioteca:

composer require livewire/livewire

Habilitar a extensão do php:

;extension=zip // Remover o ";"

Se não estiver funcionando o livewire/livewire, você pode limpar caches com:

php artisan view:clear
php artisan config:clear
php artisan route:clear
php artisan cache:clear