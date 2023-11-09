# polish-nature-map
## Overview
This web application allows users to track visited national parks and other protected areas in Poland, using data sourced from the Web Feature Service from the General Directorate for Environmental Protection.

### Features
- Browse parks and other protected areas
- Track visited places
- Interact with a map and view information about places
- Share a link with your visited places
- Run importing jobs as administrator
- View statistical data

### Tech stack
- [Laravel 10.x](https://laravel.com/docs/10.x/)
- [Vue.js 3](https://vuejs.org/guide/introduction.html)
- [Inertia.js](https://inertiajs.com/)

## Development
The project is being developed with [Laravel Sail](https://laravel.com/docs/10.x/sail) in the WSL2 Docker environment.

### Setting Up the Development Environment
1. Run setup script for Sail: `sh setup.sh`
2. Create Docker containers: `./vendor/bin/sail up -d`
3. Generate application key: `./vendor/bin/sail artisan key:generate`
4. Create storage link: `./vendor/bin/sail artisan storage:link`
5. Run migrations: `./vendor/bin/sail artisan migrate:fresh`
6. Install frontend dependencies: `./vendor/bin/sail npm install`
7. Run application: `./vendor/bin/sail npm run dev`

### Configuring Sail alias
To make it easier to run Sail commands, you can add an alias to your shell configuration file:
```bash
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

To make sure this is always available, you may add this to your shell configuration file in your home directory. For example, in `~/.bashrc` or `~/.zshrc`.

### Laravel Telescope
[Laravel Telescope](https://laravel.com/docs/10.x/telescope)'s vendor styles aren't included in the repository.

If you want to use Telescope for development, enable it in the environment and publish assets:
```bash
./vendor/bin/sail php artisan vendor:publish --tag=telescope-assets
```
