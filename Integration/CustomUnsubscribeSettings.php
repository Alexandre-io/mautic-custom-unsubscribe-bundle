<?php

/*
 * @copyright   2019 MTCExtendee. All rights reserved
 * @author      MTCExtendee
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticCustomUnsubscribeBundle\Integration;

use Mautic\PluginBundle\Helper\IntegrationHelper;

class CustomUnsubscribeSettings
{
    CONST customUnsubscribePageRegex        = '{custom_unsubscribe_page=(.*?)}';
    CONST customUnsubscribeChannelRegex     = '{custom_unsubscribe_channel=(.*?)}';
    CONST customUnsubscribeSegmentRegex     = '{custom_unsubscribe_segment=(.*?)}';
    CONST customUnsubscribeRegex            = '{custom_unsubscribe}';
    CONST customUnsubscribeSegmentNameRegex = '{custom_unsubscribe_segment_name}';

    /**
     * @var bool|\Mautic\PluginBundle\Integration\AbstractIntegration
     */
    private $integration;

    private $enabled = false;

    /**
     * DolistSettings constructor.
     *
     * @param IntegrationHelper $integrationHelper
     */
    public function __construct(IntegrationHelper $integrationHelper)
    {
        $this->integration = $integrationHelper->getIntegrationObject('CustomUnsubscribe');
        if ($this->integration instanceof CustomUnsubscribeIntegration && $this->integration->getIntegrationSettings(
            )->getIsPublished()) {
            $this->enabled = true;
        }
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

}
