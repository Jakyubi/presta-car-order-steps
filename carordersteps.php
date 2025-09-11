<?php
if(!defined('_PS_VERSION_')){
    exit;
}

class CarOrderSteps extends Module
{
    public function __construct()
    {
        $this->name = 'carordersteps';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'abc';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.7.0.0',
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->trans('Car order steps', [], 'Modules.Carordersteps.Admin');
        $this->description = $this->trans('Show steps to order', [], 'Modules.Carordersteps.Admin');
        $this->confirmUninstall = $this->trans('Are you sure to uninstall?', [], 'Modules.Carordersteps.Admin');

        if(!Configuration::get('CARORDERSTEPS_MODULE_NAME')){
            $this->warning = $this->trans('No name provided', [], 'Modules.Carordersteps.Admin');
        }
    }

    public function install()
    {
        return (
            parent::install()
            && $this->registerHook('displayHome')
            && $this->registerHook('actionFrontControllerSetMedia')
            && Configuration::updateValue('CARORDERSTEPS_MODULE_NAME', 'Car order steps')
        );
    }

    public function uninstall()
    {
        return (
            parent::uninstall()
            && Configuration::deleteByName('CARORDERSTEPS_MODULE_NAME')
        );
    }

    public function hookActionFrontControllerSetMedia()
    {
        $this->context->controller->registerStylesheet(
            'style-car-order-steps',
            'modules/'.$this->name.'/dist/css/style.css',
            ['media'=>'all', 'priority' => 150]
        );
    }

    public function hookDisplayHome($params)
    {
        return $this->display(__FILE__, 'views/templates/hook/stepsFront.tpl');
    }
}