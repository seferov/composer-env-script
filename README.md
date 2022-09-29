# Composer Env File Script

The package allows creating or updating ignored env file (ex: `.env.local`) based on
a default env file (ex: `.env`) interactively. 

----

### Installation

```shell
composer require seferov/composer-env-script
```

Modify your `composer.json` file:
```json
{
  // ...
  "scripts": {
    "post-install-cmd": [
      "Seferov\\ComposerEnvScript\\ScriptHandler::buildEnv"
    ],
    "post-update-cmd": [
      "Seferov\\ComposerEnvScript\\ScriptHandler::buildEnv"
    ]
  }
  // ...
}
```

### Configuration

By default, the package generates/updates `.env.local` file based on `.env`. This can be
changed trough composer.json extra. The configuration also allows managing multiple .env files:

```json
{
  // ...
  "extra": {
    "seferov-env": [
      {
        "from-file": ".env",
        "to-file": ".env.local"
      },
      {
        "from-file": "somepath/.env.test",
        "to-file": "somepath/.env.test.local"
      }
    ]
  }
  // ...
}
```


### Credits

The package is highly inspired by https://github.com/Incenteev/ParameterHandler which is for
managing ignored parameters.
