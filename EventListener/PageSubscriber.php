<?php

/*
 * @copyright   2015 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticCustomUnsubscribeBundle\EventListener;

use Mautic\CoreBundle\EventListener\CommonSubscriber;
use Mautic\CoreBundle\Helper\ClickthroughHelper;
use Mautic\PageBundle\Event as Events;
use Mautic\PageBundle\PageEvents;
use Mautic\LeadBundle\LeadEvent;
use MauticPlugin\MauticCustomUnsubscribeBundle\Exception\CustomUnsubscribeNotFoundException;
use MauticPlugin\MauticCustomUnsubscribeBundle\Exception\TokenNotFoundException;
use MauticPlugin\MauticCustomUnsubscribeBundle\Helper\TokenHelper;
use MauticPlugin\MauticCustomUnsubscribeBundle\Integration\CustomUnsubscribeSettings;
use MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\DTO\RequestDTO;
use MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\DTO\TokenDTO;
use MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\DTO\ChannelDTO;
use MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\DTO\UnsubscribeDTO;
use MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\Generator\GeneratorFactory;
use MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\TokenFactory;
use Monolog\Logger;

/**
 * Class PageSubscriber.
 */
class PageSubscriber extends CommonSubscriber
{
    /**
     * @var CustomUnsubscribeSettings
     */
    private $customUnsubscribeSettings;

    /**
     * @var TokenFactory
     */
    private $tokenFactory;

    /**
     * @var GeneratorFactory
     */
    private $generatorFactory;

    /**
     * PageSubscriber constructor.
     *
     * @param CustomUnsubscribeSettings $customUnsubscribeSettings
     * @param TokenFactory              $tokenFactory
     * @param GeneratorFactory          $generatorFactory
     */
    public function __construct(CustomUnsubscribeSettings $customUnsubscribeSettings, TokenFactory $tokenFactory, GeneratorFactory $generatorFactory, Logger $logger)
    {
        $this->customUnsubscribeSettings = $customUnsubscribeSettings;
        $this->tokenFactory = $tokenFactory;
        $this->generatorFactory = $generatorFactory;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            PageEvents::PAGE_ON_BUILD   => ['onPageBuild', 0],
            PageEvents::PAGE_ON_DISPLAY => ['onPageDisplay', 200],
        ];
    }

    /**
     * Add forms to available page tokens.
     *
     * @param PageBuilderEvent $event
     */
    public function onPageBuild(Events\PageBuilderEvent $event)
    {
    }

    /**
     * @param PageDisplayEvent $event
     */
    public function onPageDisplay(Events\PageDisplayEvent $event)
    {
        $content = $event->getContent();
        try {
            $requestDTO = new RequestDTO($this->request);
            $channelDTO = $this->tokenFactory->getChannelDTO($requestDTO->getHash());
            $tokens     = $this->tokenFactory->getTokens($event->getContent());
        } catch (CustomUnsubscribeNotFoundException $customUnsubscribeNotFoundException) {
            return;
        }
        foreach ($tokens as $token) {
            try {
                $unsubscribeDTO = new UnsubscribeDTO($event, $requestDTO, $token, $channelDTO);
                if ($requestDTO->isActionRequest()
                    && $requestDTO->getAction() == $token->getTokenType()
                    && $requestDTO->getValue() == $token->getValue()) {
                    $this->generatorFactory->action($unsubscribeDTO);
                    $content = str_replace(
                        '</body>',
                        $this->generatorFactory->redirection($unsubscribeDTO).'</body>',
                        $content
                    );
                    $event->setContent($content);
                }
                $content = str_replace(
                    $token->getToken(),
                    $this->generatorFactory->getOutput($unsubscribeDTO),
                    $content
                );
            } catch (TokenNotFoundException $tokenNotFoundException) {
                $content = str_replace(
                    $token->getToken(),
                    '',
                    $content
                );
                $this->logger->debug($tokenNotFoundException->getMessage());
            }
        }

        $event->setContent($content);

    }
}
