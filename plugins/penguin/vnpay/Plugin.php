<?php namespace Penguin\Vnpay;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'VNPAY Integration',
            'description' => 'Provides payment integration with VNPAY',
            'author'      => 'Penguin',
            'icon'        => 'icon-credit-card'
        ];
    }

    public function register()
    {
        $this->app->bind('vnpay', function () {
            return new \Penguin\Vnpay\Classes\VnpayService();
        });
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label' => 'VNPAY Configuration',
                'description' => 'Manage VNPAY API credentials and settings.',
                'category' => 'Payment',
                'icon' => 'icon-credit-card',
                'order' => 500,
            ],
        ];
    }
}
