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
use Mautic\LeadBundle\Model\DoNotContact;
use Symfony\Component\Translation\TranslatorInterface;

class GeneratorChannel extends AbstractGenerator implements InterfaceGenerator
{
    /**
     * @var DoNotContact
     */
    private $doNotContact;

    /**
     * @var Lead
     */
    private $contact;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var string
     */
    private $channel;

    /**
     * TokenGeneratorChannel constructor.
     *
     * @param DoNotContact        $doNotContact
     * @param TranslatorInterface $translator
     */
    public function __construct(DoNotContact $doNotContact, TranslatorInterface $translator)
    {
        $this->doNotContact = $doNotContact;
        $this->translator = $translator;
    }


    public function unsubscribe()
    {
        $this->doNotContact->addDncForContact($this->contact->getId(), $this->getChannel(), \Mautic\LeadBundle\Entity\DoNotContact::UNSUBSCRIBED, $this->translator->trans('mautic.lead.event.donotcontact_unsubscribed'));
    }

    public function subscribe()
    {
        $this->doNotContact->removeDncForContact($this->contact->getId(), $this->getChannel());
    }

    /**
     * @return int
     */
    public function isSubscribed()
    {
        return $this->doNotContact->isContactable($this->contact, $this->getChannel()) === 0;
    }

    /**
     * @param Lead $contact
     */
    public function setContact(Lead $contact){

        $this->contact = $contact;
    }

    /**
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param string $channel
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
    }


}
