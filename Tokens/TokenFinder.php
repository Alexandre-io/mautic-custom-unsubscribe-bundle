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


use Mautic\PageBundle\Model\PageModel;
use MauticPlugin\MauticCustomUnsubscribeBundle\Integration\CustomUnsubscribeSettings;
use MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\DTO\TokenDTO;
use MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\Tokens;


class TokenFinder
{

    /**
     * @var array
     */
    private $tokens = [];

    /**
     * @param $content
     * @param $clickthrough
     *
     * @return array
     */
    public function findTokens($regexp, $content)
    {
        preg_match_all('/'.$regexp.'/i', $content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $key => $value) {
                $token = $matches[0][$key];
                if (!empty($this->tokens[$token])) {
                    continue;
                }
                $tokenArray =  explode('=', str_replace('{', '', $token));
                $this->tokens[$token] = new TokenDTO($token, $value, $tokenArray[0]);
            }
            unset($matches);
        } elseif (!empty($matches[0]) && empty($matches[1])) {
            foreach ($matches[0] as $key => $value) {
                $token = $value;
                if (!empty($this->tokens[$token])) {
                    continue;
                }
                $tokenType =  str_replace(['{', '}'], '', $token);
                $this->tokens[$token] = new TokenDTO($token, '', $tokenType);
            }
        }
    }

    /**
     * @return array|TokenDTO[]
     */
    public function getTokens()
    {
        return $this->tokens;
    }
}
