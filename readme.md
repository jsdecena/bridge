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