<?php

namespace App\EventSubscriber;

use App\Entity\Article;
use JMS\Serializer\EventDispatcher\Events;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\Metadata\StaticPropertyMetadata;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;

class ArticleSubscriber implements EventSubscriberInterface
{
    public function onPostSerialize(ObjectEvent $event)
    {
        // Possibilité de récupérer l'objet qui a été sérialisé
        //$object = $event->getObject();

        $date = new \Datetime();
        $event->getVisitor()->visitProperty(new StaticPropertyMetadata ('', 'delivered_at', null), $date->format('l jS \of F Y h:i:s A'));
    }

    public static function getSubscribedEvents()
    {
        return [
            [
                'event' => Events::POST_SERIALIZE,
                'format' => 'json',
                'class' => Article::class,
                'method' => 'onPostSerialize',
            ]
        ];
    }
}
