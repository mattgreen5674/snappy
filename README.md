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

# Import the player and country data
To import the data you will need to run the following commands:

Before starting the download and import you will need to make sure your job queue is running.
```
php artisan queue:work
```

To import the countries from the data source run the following command:
```
sail php artisan app:countries-import
```

**! Important
Import the countries data first - the foreigh keys on the player table relating to the countries will create import errors if you import players first.**

When the countries have imported.  You can now import the players by running the following command:
```
sail php artisan app:players-import
```

You should now be able to log in and navigate to the playesrs list view.

**If anything goes wrong check you have added the sportsmonk api environament variables.**

# Tests
To run the test, then use the following command:
```
sail php artisan test
```

# Thoughts
Having completed this test I have some thoughts, ideas, points I wanted to make.....so here you go:

1) The Sportsmonk API access is on a free subscription, which means we have some limitations. The main one being that we are not given any indication of the total number of player records available.  Given the number of countries, the potential number of leagues for each country, the number of teams per league and differeing squad sizes - plus the fact that the data also includes current and retired players - the import could very well be sizeable.

As a consequence, I have limited my player data import to the first 1,000 records.  The API appears to be set up for providing smaller data request, rather than large data downloads - I believe the largest number of records retrievable at any one time is limited to 1,000 records.  As such, work would need to be carried out to understand how long a full import of players would take and also what impact / considerations would need to taken to comply with the API's rate limiting.

From this we would potential need to consider"
 - How often the import is undertaken?
 - Alternate strategies for importing the data - do we split up the runs, ie import different countries at different times or days!
 - Do we not import the data, but simply use the API as intended?
 - Countries shouldn't change too often, but we still need to ensure that any database integrity constraints are not compromised - should id's change or when new countries are added.
 - This is also true for positions.  These are taken from the Sportsmonk types data download - a excel file not a database table. I undertook this import by manually creating a seeder.  However, an approach would be required to monitor these - I would assume they have the potential to change far more often than the countries.  Again any changes or additions would effect the foreign keys on players for position_id and parent_position_id - which would cause an error.
 
 (If the imports failed however, we should be alerted to this via our error handling and fixes could be implemented relatively quickly.) 

2) I am assuming we would consider the data from Sportmonk as safe.  As such I have not added any validation to the data imports, but this is certainly something to be considered.
3) I have included sentry monitoring, but obvioulsy alternatives would work as well.  I have commented this out code out, the idea being you can see where I would utilise this resource, but I do not run the risk of it being called - yes I know I do not have it set up properly in my .env. 

# Improvements / Next Steps
1) List views - save search, filter, order and pagination data to cache.  This way when you return to the list view any selections are reinstated.
2) List views - add additional filter to alter the number of records displayed.  Currently set to 10, but we could allow for the list to be larger.
3) List views - could we create a base class, so the search, filter, sort and pagination is included by default and the functionality is hidden away?
4) I have named the position type 'parent position', but I wonder if I should have continued to call this position type!
5) Add countries and positions list views.


# Personal Note
Do not ever forget the:
**Haversine Algorythm** 
This is great for finding places by distance to another place!!!



