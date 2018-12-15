# Configuration Reference

The bundle configuration (`config/packages/ftd_saas.yml`) has the following configurations.

```` yaml
ftd_saas:
    settings:
        passwordResetTime: 3600
    mailer:
        address: 'test@local.de'
        sender_name: 'Admin-Team'
    template:
        passwordForget: '@FTDSaasBundle/mails/passwordForget.html.twig'
        accountCreate: '@FTDSaasBundle/mails/passwordForget.html.twig'
````

## settings

### passwordResetTime

Time between two password reset requests.

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