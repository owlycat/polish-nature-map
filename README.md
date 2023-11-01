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
The project is being developed by using [Laravel Sail](https://laravel.com/docs/10.x/sail) using WSL2 Docker environment.

### Setting Up the Development Environment
1. Run setup script for Sail: `sh setup.sh`
2. Create Docker containers: `./vendor/bin/sail up -d`
3. Install dependencies: `./vendor/bin/sail composer install`
4. Generate application key: `./vendor/bin/sail artisan key:generate`
5. Run migrations: `./vendor/bin/sail artisan migrate`

### Configuring Sail alias
To make it easier to run Sail commands, you can add an alias to your shell configuration file:
```bash
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

To make sure this is always available, you may add this to your shell configuration file in your home directory. For example, in `~/.bashrc` or `~/.zshrc`.