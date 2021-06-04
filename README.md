# Foodest 

### To create a project from this repository:

```
git clone https://github.com/AndZeka/Foodest.git
cd Foodest
composer install
npm install
cp .env.example .env
php artisan key:generate
change database fields in .env
php artisan migrate
```