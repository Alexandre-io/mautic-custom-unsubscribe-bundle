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

class GeneratorSegment extends AbstractGenerator implements InterfaceGenerator
{

    /**
     * @var LeadModel
     */
    protected $leadModel;

    /**
     * @var UnsubscribeDTO
     */
    protected $unsubscribeDTO;

    /**
     * @var ListModel
     */
    protected $listModel;

    /**
     * @var LeadList
     */
    protected $segment;

    public function __construct(LeadModel $leadModel, ListModel $listModel)
    {
        $this->leadModel = $leadModel;
        $this->listModel = $listModel;
    }

    public function unsubscribe()
    {
        $this->leadModel->removeFromLists($this->unsubscribeDTO->getChannelDTO()->getContact(), $this->segment, true);
    }

    public function subscribe()
    {
        $this->leadModel->addToLists($this->unsubscribeDTO->getChannelDTO()->getContact(), $this->segment, true);
    }

    /**
     * @return int
     */
    public function isSubscribed()
    {
        return $this->listModel->getRepository()->checkLeadSegmentsByIds($this->unsubscribeDTO->getChannelDTO()->getContact(), $this->segment->getId());
    }

    public function setUnsubscribeDTO(UnsubscribeDTO $unsubscribeDTO) {
        $this->unsubscribeDTO = $unsubscribeDTO;
        $this->segment = $this->listModel->getRepository()->findOneBy(['alias' => $unsubscribeDTO->getTokenDTO()->getValue()]);
        if (!$this->segment) {
            throw new TokenNotFoundException();
        }
    }


}
