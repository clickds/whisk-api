Whisk Api is a php library for interacting with the [whisk](https://whisk.com) api.

## Installation

Currently install directly via git

## Usage

```php
use ClickDs\WhiskApi\WhiskApi;
$config = [
  'api_token' => 'your-api-token',
  'token_type' => 'user_access',
];

$apiClient = WhiskApi::create($config);

$apiClient->getFeed();
$apiClient->getRecipe('9773cb7eca5d11e7ae7e42010a9a0035');
```

Passing a token type of user_access sets the authorization header to be a bearer token, anything else and it'll use the whisk server token configuration.

The create method is just a helper. If you'd like you can inject a guzzle client directly into the constuctor instead.

```php
use GuzzleHttp\Client;
use ClickDs\WhiskApi\WhiskApi;

$guzzleClient = new Client($args);
$apiClient = new WhiskApi($guzzleClient);
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](./LICENSE.md)

## Testing against the sandbox environment.

The default test invocation will ignore the tests against the sandbox environment. They are in the sandbox group and can be run with `vendor/bin/phpunit --group=sandbox`

### Whisk API Routes Covered

[API Spec](https://api.whisk.com/spec/)
