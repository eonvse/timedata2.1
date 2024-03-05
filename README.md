# Система учета событий v2.x

<img src='README.img/screen 1.png' />

## Развертывание:
```cmd
git clone https://github.com/eonvse/timedata2.1.git
cd timedata2.1
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
sail up
sail shell
npm run build
php artisan migrate
php artisan db:seed
#php artisan db:seed --class...
```   	
* [Laravel 10](https://laravel.com/docs/10.x)
    * [Laravel Sail (Docker)](https://laravel.com/docs/10.x/sail#main-content)
    * [Laravel Jetstream](https://jetstream.laravel.com/introduction.html)
    * [Laravel Jetstream: Add CRUD with Spatie Permission](https://laravel-news.com/jetstream-spatie-permission)

## Сопровождение

* Re-authenticate with GitHub. 
```
gh auth login
```

## Авторские права:
* Фреймворки
	* [Laravel 10](https://laravel.com/docs/10.x)
	* [Tailwindcss 3](https://tailwindcss.com/docs/installation)
	* [Livewire 3](https://livewire.laravel.com/docs)
* SVG иконки
	* [Tailwind Toolbox](https://tailwindtoolbox.com/icons)
	* [SVG Repo - Search, explore, edit and share open-licensed SVG vectors](https://www.svgrepo.com/)
