# Getting Started

1. [Installation](#installation)
    1. [JWT](#jwt)
    2. [Security](#security)
    3. [Doctrine](#doctrine)
    4. [Routing](#routing)
    5. [FOSRest](#fos-rest)
2. [Usage](#usage)

## Installation

Run `composer req ftd/saas-bundle` to install the bundle. After that you have configure some vendor package settings.


### JWT

First of all you have to create ssh keys and configure the lexik/jwt-authentication-bundle (https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md).
You have to add the jwt-authentication-bundle routing-config to your routes.yaml.

```` yaml
api_login_check:
    path: /api/token
````


### Security

After that you have to configure the security settings in file `app/config/packages/security.yaml`.
You have to define an encoder, provider, firewall and access_controll.

```yaml
security:
    encoders:
        FTD\SaasBundle\Entity\Account:
            algorithm: bcrypt

    providers:
        entity_provider:
            entity:
                class: FTD\SaasBundle\Entity\Account
                property: email

    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false
        tokenApi:
            pattern:  ^/api/token
            stateless: true
            anonymous: true
            form_login:
                check_path:               /api/token
                success_handler:          lexik_jwt_authentication.handler.authentication_success
                failure_handler:          lexik_jwt_authentication.handler.authentication_failure
                require_previous_session: false
        accountApi:
            pattern:  ^/api/account
            stateless: true
            anonymous: true
            provider: entity_provider
            guard:
                authenticators:
                - lexik_jwt_authentication.jwt_token_authenticator
        generalApi:
            pattern:  ^/api
            stateless: true
            anonymous: false
            provider: entity_provider
            guard:
                authenticators:
                - lexik_jwt_authentication.jwt_token_authenticator

    access_control:
        - { path: ^/api/token/create, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/api/account, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/api, roles: IS_AUTHENTICATED_FULLY }
```

### Doctrine

Configure your database and run `php bin/console doctrine:schema:create` or `php bin/console doctrine:schema:create --force`.

### Routing

Import the routes for the bundle.

````yaml
ftd_saas:
  resource: '@FTDSaasBundle/Resources/config/routing.xml'
````

### FOSRest

The controllers of the FTD\SaasBundle returns only View-objects. So you have to configure a format listener to transform to json.
In file `config/packages/fos_rest.yaml` you can configure the following settings:

````yaml
fos_rest:
  format_listener:
    rules:
      - { path: '^/api', priorities: ['json'], fallback_format: json, prefer_extension: false }

  view:
    view_response_listener: 'force'
    formats:
      json: true
````

## Usage

