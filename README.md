<p align="center"><a href="https://www.linguameeting.com/" target="_blank"><img src="https://www.linguameeting.com/images/web/logo.png" width="400" alt="Laravel Logo"></a></p>


## Información para desplegar la información en desarrollo.

To deploy the application on the development server we will use the Magallanes component. It is very easy to use. In the root directory of the application there is a file called .mage.yml that contains the deployment configuration. The 'udeploy' user is used, so it is necessary to know its password.
To deploy, it is enough to put the following command:

```vendor/bin/mage deploy develop```

The command will ask for the password of the 'udeploy' user. 
A log will be saved in the folder indicated by the ```log_dir``` parameter

-----------------------------

Comando para cargar timezones en mysql: 
```mysql_tzinfo_to_sql /usr/share/zoneinfo | mysql -u root -p mysql```

## Send emails

The emails are queued and it will be necessary to process the corresponding queue:

```php artisan queue:listen --queue=emails```


## Packages installed

This package are been installed into application:

- **[Laravel Auditing](https://laravel-auditing.com/)** Laravel Auditing allows you to keep a history of model changes by simply using a trait.
- **[Money for PHP](https://www.moneyphp.org/en/stable/index.html)** This library intends to provide tools for storing and using monetary values in an easy, yet powerful way.
- **[Lararel Collective](https://laravelcollective.com/docs/6.x/html)** Help for Forms and Html
- **[Laravel Dompdf](https://github.com/barryvdh/laravel-dompdf)** DOMPDF Wrapper for Laravel
- **[Laravel Excel](https://laravel-excel.com/)** Supercharged Excel exports and imports in Laravel
- **[Laravel Hashids](https://github.com/vinkla/laravel-hashids)** Hash for ids models
- **[Laravel UI](https://github.com/laravel/ui)**
- **[Laravel-Permission](https://spatie.be/docs/laravel-permission/v5/introduction)** This package allows you to manage user permissions and roles in a database.
- **[Laracast Flash](https://github.com/laracasts/flash)** Easy flash messages
- **[DebugBar](https://github.com/barryvdh/laravel-debugbar)** Integrate PHP Debug Bar with Laravel
- **[Icalendar-generator](https://github.com/spatie/icalendar-generator)** Create online calendars so that you can display them on an iPhone's calendar app or in Google Calendar.
- **[Braintree PHP library](https://developer.paypal.com/braintree/docs/start/hello-server/php)** The Braintree PHP library provides integration access to the Braintree Gateway.
- **[Mautic API Library](https://github.com/mautic/api-library)**
- **[Magallanes - The PHP Deployment Tool](https://www.magephp.com/)**
- **[FPDI - Free PDF Document Importer](https://github.com/Setasign/FPDI)** Generate long PDF. [https://www.fpdf.org/?lang=es](Doc)


To update or install new ones, you have to use composer.phar from the root directory of the application.

## Packages Jquery installed
- **[Notify.js](https://notifyjs.jpillora.com/)** Notify.js is a jQuery plugin to provide simple yet fully customisable notifications. .
- **[Expander](https://www.jqueryscript.net/text/read-more-less-expander.html)**
- **[Select2](https://select2.org/)**
- **[CkEditor4](https://ckeditor.com/ckeditor-4/)**
- **[Date Range Picker](https://www.daterangepicker.com/)**
- **[Selectize](https://selectize.dev/)**


## Template

[SB Admin Pro](https://sb-admin-pro.startbootstrap.com/index.html)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
