## Bridge for legacy systems

### This aims to migrate your legacy system to any new system

### Installation

- Step1: Add this to your `composer.json` file

```json

	"require": {
	    "jsdecena/bridge": "1.0.*"
	}

```

- Step2: Add this to your `config/app.php` in `providers` array

```json

	'providers' => [
	    Jsdecena\Bridge\BridgeServiceProvider::class,
	]

```

- Set in your `.env` file the **LEGACY_AUTH_ENDPOINT**

- Run this in your terminal `php artisan vendor:publish --tag=migrations`

- Run this in your terminal `php artisan vendor:publish --tag=config`

- Check the login key if you are using `username` or `email`. Use it accordingly.

- Do not forget to set up your database credentials in `config/database.php` and run `php artisan migrate` to migrate your database schema.