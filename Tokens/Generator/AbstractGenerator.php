<?php

/*
 * @copyright   2016 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\Generator;


use Mautic\LeadBundle\Entity\Lead;
use Mautic\LeadBundle\Entity\LeadList;
use Mautic\LeadBundle\Entity\ListLead;
use Mautic\LeadBundle\Model\DoNotContact;
use Mautic\LeadBundle\Model\LeadModel;
use Mautic\LeadBundle\Model\ListModel;
use MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\DTO\UnsubscribeDTO;
use Symfony\Component\Translation\TranslatorInterface;

class AbstractGenerator implements InterfaceGenerator
{
    public function unsubscribe()
    {
    }

    public function subscribe()
    {

    }

    public function isSubscribed()
    {

    }

    /**
     * @return string
     */
    public function getUnsubscribeText()
    {
        return 'mautic.customunsubscribe.unsubscribe';
    }

    /**
     * @return string
     */
    public function getSubscribeText()
    {
        return 'mautic.customunsubscribe.subscribe';
    }

    /**
     * @param GeneratorFactory $generatorFactory
     * @param UnsubscribeDTO   $unsubscribeDTO
     *
     * @return string
     */
    public function getOutput(GeneratorFactory $generatorFactory,UnsubscribeDTO $unsubscribeDTO)
    {
        return '<a href="'.$generatorFactory->getActionUrl($unsubscribeDTO).'">'.$generatorFactory->getActionText($this).'</a>';
    }
}
