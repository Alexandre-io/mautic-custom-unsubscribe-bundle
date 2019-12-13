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


use Mautic\PageBundle\Event\PageDisplayEvent;

class UnsubscribeDTO
{
    /**
     * @var RequestDTO
     */
    private $requestDTO;

    /**
     * @var TokenDTO
     */
    private $tokenDTO;

    /**
     * @var ChannelDTO
     */
    private $channelDTO;

    /**
     * @var \Mautic\PageBundle\Entity\Page
     */
    private $page;

    public function __construct(PageDisplayEvent $event, RequestDTO $requestDTO, TokenDTO $tokenDTO, ChannelDTO $channelDTO)
   {
       $this->page = $event->getPage();
       $this->requestDTO = $requestDTO;
       $this->tokenDTO = $tokenDTO;
       $this->channelDTO = $channelDTO;
   }

    /**
     * @return RequestDTO
     */
    public function getRequestDTO()
    {
        return $this->requestDTO;
    }

    /**
     * @return TokenDTO
     */
    public function getTokenDTO()
    {
        return $this->tokenDTO;
    }

    /**
     * @return ChannelDTO
     */
    public function getChannelDTO()
    {
        return $this->channelDTO;
    }

    /**
     * @return \Mautic\PageBundle\Entity\Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return array
     */
    public function generateClickthrought()
    {
        $ct = $this->requestDTO->getClickthrought();
        $ct['action'] = $this->tokenDTO->getTokenType();
        $ct['value'] = $this->tokenDTO->getValue();

        return $ct;
    }

    /**
     * @return array
     */
    public function generateRedirectClickthrought()
    {
        $ct = ['hash'=>$this->getRequestDTO()->getHash()];

        return $ct;
    }
}
