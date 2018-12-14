# Configuration Reference

The bundle configuration (`config/packages/ftd_saas.yml`) has the following configurations.

```` yaml
ftd_saas:
    passwordResetTime: 3600
    mailer:
        address: 'test@local.de'
        sender_name: 'Admin-Team'
    template:
        passwordForget: '@FTDSaasBundle/mails/passwordForget.html.twig'
        accountCreate: '@FTDSaasBundle/mails/passwordForget.html.twig'
````

## passwordResetTime

Time between two password reset requests.

## templates

### passwordForget

Template for the password forget mail.

### accountCreate

Template for the account create mail