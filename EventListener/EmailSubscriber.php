<?php

/*
 * @copyright   2019 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticCustomUnsubscribeBundle\EventListener;

use Mautic\CoreBundle\EventListener\CommonSubscriber;
use Mautic\CoreBundle\Helper\BuilderTokenHelper;
use Mautic\EmailBundle\EmailEvents;
use Mautic\EmailBundle\Event\EmailBuilderEvent;
use Mautic\EmailBundle\Event\EmailSendEvent;
use Mautic\LeadBundle\LeadEvent;
use MauticPlugin\MauticCustomUnsubscribeBundle\Helper\TokenHelper;
use MauticPlugin\MauticCustomUnsubscribeBundle\Integration\CustomUnsubscribeSettings;

class EmailSubscriber extends CommonSubscriber
{
    /**
     * @var CustomUnsubscribeSettings
     */
    private $customUnsubscribeSettings;

    /**
     * @var TokenReplacer
     */
    private $tokenHelper;

    /**
     * EmailSubscriber constructor.
     *
     * @param CustomUnsubscribeSettings $customUnsubscribeSettings
     * @param TokenHelper               $tokenHelper
     */
    public function __construct(CustomUnsubscribeSettings $customUnsubscribeSettings, TokenHelper $tokenHelper)
    {
        $this->customUnsubscribeSettings = $customUnsubscribeSettings;
        $this->tokenHelper = $tokenHelper;
    }
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            EmailEvents::EMAIL_ON_BUILD   => ['onEmailBuild', 0],
            EmailEvents::EMAIL_ON_SEND    => ['onEmailGenerate', 0],
            EmailEvents::EMAIL_ON_DISPLAY => ['onEmailDisplay', 0],
        ];
    }

    /**
     * Add email to available page tokens.
     *
     * @param EmailBuilderEvent $event
     */
    public function onEmailBuild(EmailBuilderEvent $event)
    {
        if (!$this->customUnsubscribeSettings->isEnabled()) {
            return;
        }

        if ($event->tokensRequested(CustomUnsubscribeSettings::customUnsubscribePageRegex)) {
            $tokenHelper = new BuilderTokenHelper($this->factory, 'page');
            $event->addTokensFromHelper($tokenHelper, CustomUnsubscribeSettings::customUnsubscribePageRegex, 'alias', 'alias', false, true);
        }
    }

    /**
     * @param EmailSendEvent $event
     */
    public function onEmailDisplay(EmailSendEvent $event)
    {

        $this->onEmailGenerate($event);
    }

    /**
     * @param EmailSendEvent $event
     */
    public function onEmailGenerate(EmailSendEvent $event)
    {

        if (!$this->customUnsubscribeSettings->isEnabled()) {
            return;
        }

        $content = $event->getContent();
        $tokens = $this->tokenHelper->findPageTokens($content,['hash'=>$event->getIdHash()]);
        foreach ($tokens as $token=>$url) {
            $content = str_ireplace('href="'.$token, 'mautic:disable-tracking href="'.$url, $content);
            $content = str_ireplace($token, $url, $content);
        }
        $event->setContent($content);



        if ($event->getEmail() && $event->getEmail()->getId() && !empty($event->getLead()['id'])) {

        }
    }
}
