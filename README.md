Snappy
=================

# Getting started

This application leverages Laravel's Sail (Docker) to provision the development environment: <https://laravel.com/docs/11.x/sail>

!!! IMPORTANT !!!

1) Copy the .env.example file to create your .env file and update with Sportsmonk API url and API Key information.

---

Open a terminal window and navigate to the project folder.

You must now install composer all of the dependencies including Laravel and Sail.

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

If you have not setup sail before, run the following in the terminal to setup an alias:

```
sudo alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

Close and re-open your terminal window to ensure the above has taken effect.

All Sail commands should be executed from the project root on the host machine.

To start the containers (this will build the containers for the first time):

```
sail up -d
```

To stop and remove the containers:

```
sail down
```

If you make changes to the containers and need to rebuild them:

```
sail build
```

# Getting the project ready
Install node dependencies:

```
sail npm install
```

Set up the data base:

```
sail php artisan migrate --seed
```

At present the DatabaseSeeder.php will create a user and player positions.

If you want to refresh the database using the following:

```
sail php artisan migrate:fresh --seed
```

Check the example user token in the PersonalAccessTokenSeeder.ph for user access.

# Files for review
App\Livewire\Emails\ContactEmailView;
App\Mail\ContactMessage;
Resources\Views\Components\Snappy\Emails\Contact-Email;
Resources\Views\Livewire\Emails\Contact-Email-View;
Tests\Feature\Views\Emails\ContqactEmailTest;

# Improvements / Next Steps
1) Build custom reuseable form input components to help us build up form across the project.
2) Build custom reuseable alert components to help with user feedback.
3) Separate the front end from the backend ?!?


# Personal Note
Do not ever forget the:
**Haversine Algorythm** 
This is great for finding places by distance to another place!!!



