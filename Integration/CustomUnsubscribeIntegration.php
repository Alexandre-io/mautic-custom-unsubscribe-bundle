<?php

/*
 * @copyright   2019 MTCExtendee. All rights reserved
 * @author      MTCExtendee
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticCustomUnsubscribeBundle\Integration;

use Mautic\PluginBundle\Integration\AbstractIntegration;


class CustomUnsubscribeIntegration extends AbstractIntegration
{
    const INTEGRATION_NAME = 'CustomUnsubscribe';

    public function getName()
    {
        return self::INTEGRATION_NAME;
    }

    public function getDisplayName()
    {
        return 'Custom Unsubscribe';
    }

    public function getAuthenticationType()
    {
        return 'none';
    }

    public function getRequiredKeyFields()
    {
        return [
        ];
    }

    public function getIcon()
    {
        return 'plugins/MauticCustomUnsubscribeBundle/Assets/img/icon.png';
    }
}
