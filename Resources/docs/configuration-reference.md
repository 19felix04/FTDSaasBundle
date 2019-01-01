# Configuration Reference

The bundle configuration (`config/packages/ftd_saas.yml`) has the following configurations.

```` yaml
ftd_saas:
    settings:
        passwordResetTime: 3600
        softwareAsAService: true
    mailer:
        address: 'test@local.de'
        sender_name: 'Admin-Team'
    template:
        #passwordForget: false
        passwordForget: '@AppBundle/mails/passwordForget.html.twig'
        #accountCreate: false
        accountCreate: '@AppBundle/mails/accountCreate.html.twig'
    form:
        accountType: 'FTD\SaasBundle\Form\AccountType'
        subscriptionType: 'FTD\SaasBundle\Form\SubscriptionType'
        userType: 'FTD\SaasBundle\Form\UserType'
    manager:
        accountManager: 'FTD\SaasBundle\Manager\AccountManager'
        subscriptionManager: 'FTD\SaasBundle\Manager\SubscriptionManager'
        userManager: 'FTD\SaasBundle\Manager\UserManager'
    creationHandler:
        accountCreationHandler: 'FTD\SaasBundle\Service\Account\AccountCreationHandler'
        subscriptionCreationHandler: 'FTD\SaasBundle\Service\Subscription\SubscriptionCreationHandler'
````

## Global settings (settings)
### softwareAsAService
The value defines if the application is a software as a service.
If true for example subscription and plans are available.

### passwordResetTime
Time between two password reset requests.

## Mailer attributes (mailer)
### address
The e-mail-address of the mail sender.

### sender_name
The name of the mail sender.

## Different templates (templates)
### passwordForget
Template for the password forget mail. If value is `false` no mail will be send.

### accountCreate
Template for the account create mail. If value is `false` no mail will be send.

### Overwritting forms (form)
### accountType
The class which represents the account-creation-form.
Maybe you want to change the validation or add extra fields.

### subscriptionType
The class which represents the subscription-creation/ or -updating form.

#### userType
The class of the class which represents the user-creation or -updating form.

## Overwritting manager (manager)
You can overwrite standard manager to handle accounts, subscriptions or users.
The services has to implement different interfaces for usage.

### accountManager
The manager handles interacting with accounts. The service has to implement FTD\SaasBundle\Manager\AccountManagerInterface

### subscriptionManager
The manager handles interacting with subscriptions. The service has to implement FTD\SaasBundle\Manager\SubscriptionManagerInterface

### userManager
The manager handles interacting with users. The service has to implement FTD\SaasBundle\Manager\UserManagerInterface

## creationHandler
### accountCreationHandler
A service (implements `FTD\SaasBundle\Service\Account\AccountCreationHandlerInterface`) can be placed here. When a account is created, the function `process` is called.

### subscriptionCreationHandler
A service (implements `FTD\SaasBundle\Service\Subscription\SubscriptionCreationHandlerInterface`) can be placed here. When a subscription is created, the function `process` is called.
