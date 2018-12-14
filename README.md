FTDSaasBundle
=============

The FTDSaasBundles adds support for a database-backed user system based on an REST-API in Symfony4+.
For usage you need to use some extra bundles ([LexikJWTAuthenticationBundle](https://github.com/lexik/LexikJWTAuthenticationBundle), 
[FriendsOfSymfony/FOSRestBundle](https://github.com/FriendsOfSymfony/FOSRestBundle), [JMSSerializerBundle](https://github.com/schmittjoh/JMSSerializerBundle)); 

Features include:

- Users can be stored via Doctrine ORM
- Registration support, with an optional confirmation per email
- Password reset support
- Unit tested

**Note:** This bundle does *not* provide an authentication system but can
provide the user provider for the core [SecurityBundle](https://symfony.com/doc/current/book/security.html).

Documentation
-------------

The source of the documentation is stored in the `Resources/doc/` folder
in this bundle.

Installation
------------

All the installation instructions are located in the documentation.

License
-------

This bundle is under the MIT license. See the complete license [in the bundle](LICENSE)

About
-----

Maintenance by [Felix Niedballa](https://felixniedballa.de), founder of [ELEVATOR Webentwicklung](https://www.elevator-webentwicklung.de).
