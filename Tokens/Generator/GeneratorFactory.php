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
use Symfony\Component\HttpFoundation\RedirectResponse;

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
     * GeneratorFactory constructor.
     *
     * @param PageModel        $pageModel
     * @param GeneratorChannel $generatorChannel
     * @param GeneratorSegment $generatorSegment
     */
    public function __construct(PageModel $pageModel, GeneratorChannel $generatorChannel, GeneratorSegment $generatorSegment)
    {
        $this->pageModel = $pageModel;
        $this->generatorChannel = $generatorChannel;
        $this->generatorSegment = $generatorSegment;
    }

    public function getOutput(UnsubscribeDTO $unsubscribeDTO)
    {
        $generator = $this->getGenerator($unsubscribeDTO);
        return '<a href="'.$this->getActionUrl($unsubscribeDTO).'">'.$this->getActionText($generator).'</a>';
    }

    public function getActionText(InterfaceGenerator $generator)
    {
        if ($generator->isSubscribed()) {
            return 'unsubscribe';
        }else{
            return 'subscribe';
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

        $url = $this->pageModel->generateUrl($unsubscribeDTO->getPage(), true,$unsubscribeDTO->generateRedirectClickthrought() );

    }

    /**
     * @param UnsubscribeDTO $unsubscribeDTO
     *
     * @return InterfaceGenerator
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
        }


    }
}
