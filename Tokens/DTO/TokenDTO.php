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


class TokenDTO
{
    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $tokenType;

    /**
     * TokenDTO constructor.
     *
     * @param string $token
     * @param string $value
     * @param string $tokenType
     */
    public function __construct($token, $value, $tokenType = null)
  {
      $this->token = $token;
      $this->value = $value;
      $this->tokenType = $tokenType;
  }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getTokenType()
    {
        return $this->tokenType;
    }
}
