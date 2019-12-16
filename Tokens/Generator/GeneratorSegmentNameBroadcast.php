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
use MauticPlugin\MauticCustomUnsubscribeBundle\Exception\TokenNotFoundException;
use MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\DTO\UnsubscribeDTO;
use Symfony\Component\Translation\TranslatorInterface;

class GeneratorSegmentNameBroadcast extends GeneratorBroadcast implements InterfaceGenerator
{

    /**
     * @param GeneratorFactory $generatorFactory
     * @param UnsubscribeDTO   $unsubscribeDTO
     *
     * @return int|string
     */
    public function getOutput(GeneratorFactory $generatorFactory,UnsubscribeDTO $unsubscribeDTO)
    {
        return $this->segment->getName();
    }
}
