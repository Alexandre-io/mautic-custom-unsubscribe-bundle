<?php

/*
 * @copyright   2016 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\DTO;


use Mautic\LeadBundle\Entity\Lead;

class ChannelDTO
{
    /**
     * @var int
     */
    private $contact;

    /**
     * @var string
     */
    private $channel;

    /**
     * @var int
     */
    private $channelId;

    /**
     * @var int|null
     */
    private $segmentAlias;

    /**
     * UnsubscribeChannelDTO constructor.
     *
     * @param Lead     $contact
     * @param string   $channel
     * @param int|null $channelId
     * @param string|null $segmentAlias
     */
    public function __construct(Lead $contact, $channel, $channelId= null, $segmentAlias = null)
   {
       $this->channel      = $channel;
       $this->contact      = $contact;
       $this->channelId    = $channelId;
       $this->segmentAlias = $segmentAlias;
   }

    /**
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @return int
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @return int
     */
    public function getChannelId()
    {
        return $this->channelId;
    }

    /**
     * @return int|null
     */
    public function getSegmentAlias()
    {
        return $this->segmentAlias;
    }
}
