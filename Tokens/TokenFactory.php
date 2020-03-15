<?php

/*
 * @copyright   2016 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticCustomUnsubscribeBundle\Tokens;


use Mautic\CampaignBundle\Entity\Event;
use Mautic\CampaignBundle\Model\EventModel;
use Mautic\EmailBundle\Model\EmailModel;
use Mautic\LeadBundle\Entity\LeadList;
use MauticPlugin\MauticCustomUnsubscribeBundle\Exception\CustomUnsubscribeNotFoundException;
use MauticPlugin\MauticCustomUnsubscribeBundle\Integration\CustomUnsubscribeSettings;
use MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\DTO\TokenDTO;
use MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\DTO\ChannelDTO;

class TokenFactory
{
    private $regexs = [
        CustomUnsubscribeSettings::customUnsubscribeChannelRegex,
        CustomUnsubscribeSettings::customUnsubscribeSegmentRegex,
        CustomUnsubscribeSettings::customUnsubscribeRegex,
        CustomUnsubscribeSettings::customUnsubscribeSegmentNameRegex,
    ];

    /**
     * @var EmailModel
     */
    private $emailModel;

    /**
     * @var TokenFinder
     */
    private $tokenFinder;

    /**
     * @var EventModel
     */
    private $eventModel;

    /**
     * TokenFactory constructor.
     *
     * @param EmailModel  $emailModel
     * @param TokenFinder $tokenFinder
     * @param EventModel  $eventModel
     */
    public function __construct(EmailModel $emailModel, TokenFinder $tokenFinder, EventModel $eventModel)
    {
        $this->emailModel  = $emailModel;
        $this->tokenFinder = $tokenFinder;
        $this->eventModel = $eventModel;
    }

    /**
     * @param string $content
     *
     * @return array|TokenDTO[]
     */
    public function getTokens($content)
    {
        foreach ($this->regexs as $regex) {
            $this->tokenFinder->findTokens($regex, $content);
        }

        return $this->tokenFinder->getTokens();

    }

    /**
     * @param $hash
     *
     * @return ChannelDTO
     * @throws CustomUnsubscribeNotFoundException
     */
    public function getChannelDTO($hash)
    {
        $stat = $this->emailModel->getEmailStatus($hash);

        if (!$stat) {
            throw new CustomUnsubscribeNotFoundException();
        }

        $segmentAlias = $stat->getList() ? $stat->getList()->getAlias() : null;

        if ('campaign.event' == $stat->getSource()) {
            $sourceId = $stat->getSourceId();
            /** @var Event $campaignEvent */
            $campaignEvent = $this->eventModel->getEntity($sourceId);
            $segments = $campaignEvent->getCampaign()->getLists();

            /** @var LeadList $segment */
            $segment = $segments->first();
            if ($segment) {
                $segmentAlias = $segment->getAlias();
            }
        }
        return new ChannelDTO(
            $stat->getLead(),
            'email',
            $stat->getEmail() ? $stat->getEmail()->getId() : null,
            $segmentAlias
        );
    }

}
