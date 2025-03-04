Picniq Tickets API
=================

# Getting started

This application leverages Laravel's Sail (Docker) to provision the development environment: <https://laravel.com/docs/11.x/sail>

!!! IMPORTANT !!!

1) Copy the .env.example file to create your .env file and update with relevant database access information or ask another developer for a copy of their env file for this project to save you having to configure it all.

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

At present the DatabaseSeeder.php will create a user and some basic shops.  If wanted to have a few post codes to get going uncomment the seeder in this file.
If you have already ran the above command you can refresh the database using the following:

```
sail php artisan migrate:fresh --seed
```

Check the example user token in the PersonalAccessTokenSeeder.ph for the api bearer token required to use the API routes.

# API End Points
All API end points to do with shops are post requests:

## http://localhost/api/shops

This will create a new shop and requires the following data:

'name', 'latitude', 'longitude', 'status', 'type', 'max_delivery_distance' (all required)

## http://localhost/api/shops/near-to-postcode
This end point returns a list of shops within a certain distance of a post code.

The distance is defaulted to a maximum of 1000 metres, but the end point provides an optional distance attribute which can be used to shorten or extend the distance required.

It requires the following data:

'post_code' (required) 'distance' (optional in metres) 

## http://localhost/api/shops/near-to-postcode
This end point returns a list of shops who will deliver to the provided post code.

It requires the following data:

'post_code' (required)

# Import the post codes
The import downloads the file and extracts the data and batches this data into a series of jobs for processing.  

Before starting the download and import you will need to make sure your job queue is running.
```
php artisan queue:work
```

To import the post codes from the data source run the following command:
```
sail php artisan app:import-postcodes-from-csv
```
Now sit back and wait as the whole process will take a while to complete.

# Tests
I have not fully fledge out the test, but rather scaffolded the tests as an indication of the type of tests I would expect to see.

Should you still wish to run them, then use the following command:
```
sail php artisan test
```

I have not written tests for the download command, as I would not want to download the zip file everytime I ran the tests.  Plus the way the command is written we would only be able to test that no jobs had been queued.  **We could write tests to run manually should we so choose to do so.**


# Thoughts
Having completed this test I have some thoughts, ideas, points I wanted to make.....so here you go:

## MySQL
1) Haversine Algorithmn

This was fun to learn.

However, MySQL has spatial commands that can be included in later versions of MySQL to help improve these kind of searches. The MySQL version used here has the ability to uitlise use spatial fields, but not the commands required to query the data.  Being part of sail / docker rebuilding the Dockerfile to include these commands felt a bit beyong the scope, but it would be interesting
to see how these improve the data retrieval - especially should the shop data records become very large.

## API 
1) Finding Shops - I was unsure about the field "status" -  did this mean the shops where premenantly closed or simply closed at this time of day.  I have included all shops in the response, but this could be improved.
2) Finding Shops - Should there have been a filter on the type of shop returned?
3) Finding Shops - Without knowing exactly how the data will be used by the end user, I have limited the response to the first 100 records.  However, this could be adapted to fit the eact requirements should it be necessary.
4) Creating Shop - I have assumed all fields would be required and must be set by the supplier of the data.

## Import
1) I have assumed all post codes should fit the standard format - a length of either 7 or 8 characters of leeters and numbers separated by space.  Any post codes not fitting this format are rejected.  

I noted that a large number of the post codes in the data supplied do not fit this format.  This would mean we either need to adapt the way the data in is included (perhaps a new post code column without the space - which in turn would mean changes to api queries) or worse a manipulation of the data before it was imported - which could be problematic to ensure they are correct and / or in the correct format.

2) How often is this import expected to be run? The file is from November 22, so this suggests it is not updated regularly - so is an import required?
3) When a new update is available, presumably the file name and link would change, which would require a code update - or if moved to .env file and update here instead.
4) What is expected to happen if the file structure of the download changed?  Again code changes would be required which doesn't seem the best approach.
5) How trusted is the source?
6) With the approach I have taken - adding or updating records in the exitsing post code table - and the lenght of time these changes take to make (about an hour) - I do not know what kind of demand level their is for this table, but would this import have any impact upon our operational requirements?
6) Given the large amount of data, the rarity of change and the risks outlined above - would it be better to import the data directly in the DB.  We could create a temporayy table import the data
and then test the imported information.  Once happy would simply need to delete the existing table and rename the temporary table.  This approach would significantly reduce the operational impact caused by the download and import.
7) With a data import, we could also spend some time cleaning the data before it was imported too!  Or perhaps this the better approach for the import code, if we chose to continue with this method.
8) The download says it has current and old unused post codes included.  How many of these are no longer used?  There are 1.8Mish records, do we need them all.  Problem was I couldn't see an obvious flag to signify which were current and which were old.  I did check a hand full of the post codes that had no space - in chase this was the point of difference, but this appeared to be valid on Google maps.
9) Would a third party service be more appropriate to use? 


