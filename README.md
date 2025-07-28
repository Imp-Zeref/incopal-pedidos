Este projeto utiliza Laravel com Livewire e ferramentas frontend via npm. Siga os passos abaixo para configurar corretamente o ambiente.

✅ Requisitos
PHP 8.1 ou superior

Composer
Node.js e npm
Extensões do PHP habilitadas: zip
Banco de dados configurado no .env (se aplicável)

🚀 Passo a Passo para Instalação
1. Instalar dependências do Node.js
npm install

2. Instalar o Livewire via Composer
composer require livewire/livewire

3. Habilitar a extensão zip no PHP
No arquivo php.ini, remova o ponto e vírgula da linha:

;extension=zip

🔄 Caso o Livewire não funcione corretamente
Execute os comandos abaixo para limpar os caches do Laravel:

php artisan view:clear
php artisan config:clear
php artisan route:clear
php artisan cache:clear

▶️ Rodando o Projeto

Abra dois terminais e execute:

Terminal 1 – Build do Frontend:
npm run build

Terminal 1 2º passo – Servidor + Processamento de filas:
php artisan serve

Terminal 3 – Processamento das filas do Laravel:
php artisan queue:work