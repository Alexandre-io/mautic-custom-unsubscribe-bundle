<?php

/*
 * @copyright   2015 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\Generator;


interface InterfaceGenerator
{
    public function unsubscribe();

    public function subscribe();

    public function isSubscribed();

    public function getUnsubscribeText();

    public function getSubscribeText();
}
