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


use Mautic\CoreBundle\Helper\ClickthroughHelper;
use Symfony\Component\HttpFoundation\Request;

class RequestDTO
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $action;

    /**
     * @var string
     */
    private $hash;

    /**
     * @var array
     */
    private $ct;

    public function __construct(Request $request)
    {
        if ($ct = $request->get('ct')) {
            $this->ct = $ct = ClickthroughHelper::decodeArrayFromUrl($ct);
            if (isset($ct['hash'])) {
                $this->hash = $ct['hash'];
            }
            if (isset($ct['action'])) {
                $this->action = $ct['action'];
            }

            if (isset($ct['value'])) {
                $this->value = $ct['value'];
            }
        }

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
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @return array
     */
    public function getClickthrought()
    {
        return $this->ct;
    }

    /**
     * @return bool
     */
    public function isActionRequest()
    {
        if ($this->action) {
            return true;
        }

        return false;
    }
}
