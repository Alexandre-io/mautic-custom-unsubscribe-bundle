<?php

return [
    'name'        => 'MauticCustomUnsubscribeBundle',
    'description' => 'Custom unsubscribe for Mautic',
    'version'     => '1.0',
    'author'      => 'MTCExtendee',

    'routes' => [
    ],

    'services'   => [
        'events'       => [
            'mautic.customunsubscribe.email.subscriber' => [
                'class'     => \MauticPlugin\MauticCustomUnsubscribeBundle\EventListener\EmailSubscriber::class,
                'arguments' => [
                    'mautic.customunsubscribe.integration.settings',
                    'mautic.customunsubscribe.helper.token'
                ],
            ],
            'mautic.customunsubscribe.page.subscriber'  => [
                'class'     => \MauticPlugin\MauticCustomUnsubscribeBundle\EventListener\PageSubscriber::class,
                'arguments' => [
                    'mautic.customunsubscribe.integration.settings',
                    'mautic.customunsubscribe.token.factory',
                    'mautic.customunsubscribe.generator.factory',
                ],
            ],
        ],
        'forms'        => [
        ],
        'models'       => [

        ],
        'integrations' => [
            'mautic.integration.customunsubscribe' => [
                'class'     => \MauticPlugin\MauticCustomUnsubscribeBundle\Integration\CustomUnsubscribeIntegration::class,
                'arguments' => [
                ],
            ],
        ],
        'others'       => [
            'mautic.customunsubscribe.integration.settings' => [
                'class'     => \MauticPlugin\MauticCustomUnsubscribeBundle\Integration\CustomUnsubscribeSettings::class,
                'arguments' => [
                    'mautic.helper.integration',
                ],
            ],

            'mautic.customunsubscribe.helper.token' => [
                'class'     => \MauticPlugin\MauticCustomUnsubscribeBundle\Helper\TokenHelper::class,
                'arguments' => [
                    'mautic.page.model.page',
                ],
            ],

            'mautic.customunsubscribe.token.factory' => [
                'class'     => \MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\TokenFactory::class,
                'arguments' => [
                    'mautic.email.model.email',
                    'mautic.customunsubscribe.token.finder'
                ],
            ],

            'mautic.customunsubscribe.token.finder' => [
                'class'     => \MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\TokenFinder::class,
                'arguments' => [
                ],
            ],

            // generator
            'mautic.customunsubscribe.generator.factory' => [
                'class'     => \MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\Generator\GeneratorFactory::class,
                'arguments' => [
                    'mautic.page.model.page',
                    'mautic.customunsubscribe.generator.channel',
                    'mautic.customunsubscribe.generator.segment',
                    'mautic.customunsubscribe.generator.broadcast',
                    'mautic.customunsubscribe.generator.broadcast.segment_name',
                    'translator'
                ],
            ],

            'mautic.customunsubscribe.generator.channel' => [
                'class'     => \MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\Generator\GeneratorChannel::class,
                'arguments' => [
                    'mautic.lead.model.dnc',
                    'translator'
                ],
            ],

            'mautic.customunsubscribe.generator.segment' => [
                'class'     => \MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\Generator\GeneratorSegment::class,
                'arguments' => [
                    'mautic.lead.model.lead',
                    'mautic.lead.model.list',
                    'doctrine.orm.entity_manager'
                ],
            ],

            'mautic.customunsubscribe.generator.broadcast' => [
                'class'     => \MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\Generator\GeneratorBroadcast::class,
                'arguments' => [
                    'mautic.lead.model.lead',
                    'mautic.lead.model.list',
                    'doctrine.orm.entity_manager'
                ],
            ],

            'mautic.customunsubscribe.generator.broadcast.segment_name' => [
                'class'     => \MauticPlugin\MauticCustomUnsubscribeBundle\Tokens\Generator\GeneratorSegmentNameBroadcast::class,
                'arguments' => [
                    'mautic.lead.model.lead',
                    'mautic.lead.model.list',
                ],
            ],

        ],
        'controllers'  => [
        ],
        'commands'     => [

        ],
    ],
    'parameters' => [
    ],
];
