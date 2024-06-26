## Task Management App DEMO

## Requirements

| Tools   | Description     |
|---------|-----------------|
| PHP     | 8.0 >= 8.2      |
| Laravel | 10.*            |
| Node js | 20.*  or latest |

  <br>

## See Demo App here

#### <a href="https://v2-taskapp.digitechproject.com" target="_blank"> >>> Task Management App Demo <<< </a>

## Installation

Clone the repo locally:

```sh
git clone https://github.com/MoonRivers21/v2-taskapp.git
```

<br>
Navigate to the Project Directory:

```sh
cd v2-taskapp
```

Install PHP dependencies:

```sh
composer install 
```

Setup configuration:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```

<br>
Note: Please update your database(MySQL) configuration accordingly.

Run database migrations:

```sh
php artisan migrate
```

Create a symlink to the storage:

```sh
php artisan storage:link
```

<br><br>

Install node and build the manifest file:

```sh
npm install && npm run build
```

Run the dev server (the output will give the address):

```sh
php artisan serve
```

<br><br>
You're ready to go! Visit the url in your browser, and signup:

## Features to explore

- #### Dashboard (Basic analytics)
    - Todo, In-progress, Done, Published, Draft, Trash
    - Tables that lists only published tasks
    - Quick actions

<br>

- #### Manage Task (CRUD)
    - Many Quick Actions
    - CRUD Functions
    - Task records belongs to Authorize Owner
    - All action button are relying on LaravelPolicies

<br> 


- #### Auto Remove task
    - Created task will be removed if older than 30d (Scripts will be triggered only via online) or run the command  

```sh
php artisan tasks:delete-old
```
<br>

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
 
