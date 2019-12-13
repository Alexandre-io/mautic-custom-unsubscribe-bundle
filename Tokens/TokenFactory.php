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


use Mautic\EmailBundle\Model\EmailModel;
use MauticPlugin\MauticCustomUnsubscribeBundle\Integration\CustomUnsubscribeSettings;
use MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\DTO\TokenDTO;
use MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\DTO\ChannelDTO;

class TokenFactory
{
    private $regexs = [
        CustomUnsubscribeSettings::customUnsubscribeChannelRegex, CustomUnsubscribeSettings::customUnsubscribeSegmentRegex];

    /**
     * @var EmailModel
     */
    private $emailModel;

    /**
     * @var TokenFinder
     */
    private $tokenFinder;

    /**
     * TokenFactory constructor.
     *
     * @param EmailModel            $emailModel
     * @param TokenFinder           $tokenFinder
     */
    public function __construct(EmailModel $emailModel, TokenFinder $tokenFinder)
    {
        $this->emailModel = $emailModel;
        $this->tokenFinder = $tokenFinder;
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
     * @param string $hash
     *
     * @return ChannelDTO
     */
    public function getChannelDTO($hash)
    {
        $stat = $this->emailModel->getEmailStatus($hash);
        if ($stat) {
            return new ChannelDTO($stat->getLead(), 'email', $stat->getEmail()->getId());
        }
    }

}
