<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Application Debug Mode
	|--------------------------------------------------------------------------
	|
	| When your application is in debug mode, detailed error messages with
	| stack traces will be shown on every error that occurs within your
	| application. If disabled, a simple generic error page is shown.
	|
	*/

	'debug' => false,

    'providers' => append_config(array(
        'Barryvdh\Debugbar\ServiceProvider',
        'Rtablada\PackageInstaller\PackageInstallerServiceProvider',
        'LucaDegasperi\OAuth2Server\OAuth2ServerServiceProvider'
    )),

    'aliases' => append_config(array(
        'AuthorizationServer' => 'LucaDegasperi\OAuth2Server\Facades\AuthorizationServerFacade',
        'ResourceServer' => 'LucaDegasperi\OAuth2Server\Facades\ResourceServerFacade'
    ))

);
