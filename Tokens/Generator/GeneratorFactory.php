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



use Mautic\PageBundle\Model\PageModel;
use MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\DTO\UnsubscribeDTO;
use Symfony\Component\Translation\TranslatorInterface;

class GeneratorFactory
{
    /**
     * @var PageModel
     */
    private $pageModel;

    /**
     * @var GeneratorChannel
     */
    private $generatorChannel;

    /**
     * @var GeneratorSegment
     */
    private $generatorSegment;

    /**
     * @var GeneratorBroadcast
     */
    private $generatorBroadcast;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var GeneratorSegmentNameBroadcast
     */
    private $segmentNameBroadcast;

    /**
     * GeneratorFactory constructor.
     *
     * @param PageModel                     $pageModel
     * @param GeneratorChannel              $generatorChannel
     * @param GeneratorSegment              $generatorSegment
     * @param GeneratorBroadcast            $generatorSegmentName
     * @param GeneratorSegmentNameBroadcast $segmentNameBroadcast
     * @param TranslatorInterface           $translator
     */
    public function __construct(PageModel $pageModel, GeneratorChannel $generatorChannel, GeneratorSegment $generatorSegment, GeneratorBroadcast $generatorSegmentName, GeneratorSegmentNameBroadcast $segmentNameBroadcast, TranslatorInterface $translator)
    {
        $this->pageModel          = $pageModel;
        $this->generatorChannel   = $generatorChannel;
        $this->generatorSegment   = $generatorSegment;
        $this->generatorBroadcast = $generatorSegmentName;
        $this->segmentNameBroadcast = $segmentNameBroadcast;
        $this->translator = $translator;
    }

    public function getOutput(UnsubscribeDTO $unsubscribeDTO)
    {
        $generator = $this->getGenerator($unsubscribeDTO);
        return $generator->getOutput($this, $unsubscribeDTO);
    }

    /**
     * @param InterfaceGenerator $generator
     *
     * @return string
     */
    public function getActionText(InterfaceGenerator $generator)
    {
        if ($generator->isSubscribed()) {
            return $this->translator->trans($generator->getUnsubscribeText());
        }else{
            return $this->translator->trans($generator->getSubscribeText());
        }
    }

    public function getActionUrl(UnsubscribeDTO $unsubscribeDTO)
    {
        return $this->pageModel->generateUrl($unsubscribeDTO->getPage(), true, $unsubscribeDTO->generateClickthrought());
    }

    /**
     * @param UnsubscribeDTO $unsubscribeDTO
     */
    public function action(UnsubscribeDTO $unsubscribeDTO)
    {
        $generator = $this->getGenerator($unsubscribeDTO);
        if ($generator->isSubscribed()) {
            $generator->unsubscribe();
        }else{
            $generator->subscribe();
        }
    }

    /**
     * @param UnsubscribeDTO $unsubscribeDTO
     *
     * @return string
     */
    public function redirection(UnsubscribeDTO $unsubscribeDTO)
    {
        return '<script>
location.href = \''.$this->pageModel->generateUrl($unsubscribeDTO->getPage(), true,$unsubscribeDTO->generateRedirectClickthrought()).'\';
</script>';
    }


    /**
     * @param UnsubscribeDTO $unsubscribeDTO
     *
     * @return GeneratorBroadcast|GeneratorChannel|GeneratorSegment
     * @throws \MauticPlugin\MauticCustomUnsubscribeBundle\Exception\TokenNotFoundException
     */
    private function getGenerator(UnsubscribeDTO $unsubscribeDTO)
    {
        switch ($unsubscribeDTO->getTokenDTO()->getTokenType()) {
            case 'custom_unsubscribe_channel':
                $this->generatorChannel->setContact($unsubscribeDTO->getChannelDTO()->getContact());
                $this->generatorChannel->setChannel($unsubscribeDTO->getChannelDTO()->getChannel());
                return $this->generatorChannel;
                break;
            case 'custom_unsubscribe_segment':
                $this->generatorSegment->setUnsubscribeDTO($unsubscribeDTO);
                return $this->generatorSegment;
                break;
           case 'custom_unsubscribe':
                $this->generatorBroadcast->setUnsubscribeDTO($unsubscribeDTO);
                return $this->generatorBroadcast;
                break;
                case 'custom_unsubscribe_segment_name':
                $this->segmentNameBroadcast->setUnsubscribeDTO($unsubscribeDTO);
                return $this->segmentNameBroadcast;
                break;
        }


    }
}
