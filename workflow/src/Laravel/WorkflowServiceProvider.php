<?php

namespace JunhaiServer\Workflow\Laravel;

use Illuminate\Support\ServiceProvider;
use JunhaiServer\Workflow\Workflow;

class WorkflowServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            realpath(__DIR__.'/../../config/workflow-config.php') => config_path('workflow-config.php'),
        ], 'config');

        $this->mergeConfigFrom(realpath(__DIR__.'/../../config/workflow-config.php'), 'workflow-config.php');
    }

    public function register()
    {
        $this->app->singleton('workflow', function($app){
           // dd($app->config->get('workflow-config'));
            $workflow = new Workflow($app->config->get('workflow-config.workflows.places'),
                $app->config->get('workflow-config.workflows.transitions'),
                $app->config->get('workflow-config.workflows.field')
            );
            return $workflow;
        });

    }

}