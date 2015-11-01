# YamlConfigServiceProvider

Service provider for Silex ```v2.x``` using YAML configuration files.

## Installation

To use it add following line to your composer.json:

    "require": {
        ...
        "juuuuuu/yaml-config-service-provider": "1.0.x-dev"
        ...
    }

## Usage

Include following line of code somewhere in your initial Silex file (index.php or whatever):  

```php
    $app->register(new Juuuuuu\Silex\YamlConfigServiceProvider(__DIR__.'/../app/config/parameters.yml'));
```

Now you have access to all of your configuration variables through `$app['parameters']`.


## Example

parameters.yml:  

```yml
parameters:
    webservice:
        url: http://host.com
        username: user
        password: pass
```

index.php:

```php
    <?php
        require_once __DIR__.'/../vendor/autoload.php';

        $app = new Silex\Application();

        // Considering the parameters.yml files is in app/config directory
        $app->register(new Juuuuuu\Silex\YamlConfigServiceProvider(__DIR__.'/../app/config/parameters.yml'));

        $wsUrl = $app['parameters']['webservice']['url'];
```
