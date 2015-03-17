<?php namespace App\Providers;

class HtmlServiceProvider extends \Illuminate\Html\HtmlServiceProvider
{
/**
* Register the form builder instance.
*
* @return void
*/
    protected function registerFormBuilder()
    {
        $this->app->bindShared('form', function($app) {
            $form = new \App\Html\FormBuilder($app['html'], $app['url'], $app['session.store']->getToken());

            return $form->setSessionStore($app['session.store']);
        });
    }
}
