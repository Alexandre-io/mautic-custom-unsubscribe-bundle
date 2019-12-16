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

class GeneratorBroadcast extends GeneratorSegment implements InterfaceGenerator
{

    public function setUnsubscribeDTO(UnsubscribeDTO $unsubscribeDTO) {
        $this->unsubscribeDTO = $unsubscribeDTO;
        $this->segment = $this->listModel->getRepository()->findOneBy(['alias' => $unsubscribeDTO->getChannelDTO()->getSegmentAlias()]);
        if (!$this->segment) {
            throw new TokenNotFoundException();
        }
    }

}
