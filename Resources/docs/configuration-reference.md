# Configuration Reference

The bundle configuration (`config/packages/ftd_saas.yml`) has the following configurations.

```` yaml
ftd_saas:
    settings:
        passwordResetTime: 3600
        softwareAsAService: true
        createUserAutomatically: true
        createSubscriptionAutomatically: false
    mailer:
        address: 'test@local.de'
        sender_name: 'Admin-Team'
    template:
        passwordForget: '@FTDSaasBundle/mails/passwordForget.html.twig'
        accountCreate: '@FTDSaasBundle/mails/passwordForget.html.twig'
````

## settings

### softwareAsAService
The value defines if the application is a software as a service.
If true for example subscription and plans are available.

### passwordResetTime
Time between two password reset requests.

### createUserAutomatically
If a new account will be registered, any user with the same email already exists and this value is true, an user entity will be created automatically.

### createUserAutomatically
If a new account will be registered and there is no connected subscription to and connected user entity, a subscription entity will be created automatically.
The name of the subscription can be overwritten through the translation reference 'factory.subscription.name' in 'ftd_saas'-namespace.
The mechanism will only work if the setting `createUserAutomatically` is true.

## mailer

### address

The e-mail-address of the mail sender.

### sender_name

The name of the mail sender.

## templates

### passwordForget

Template for the password forget mail.

### accountCreate

Template for the account create mail