<?php

namespace Forum\ForumBundle\Manager;

use Forum\ForumBundle\Document\Thread;

class PostManager
{
    private $container;

    /**
     * PostManager constructor.
     * @param $container
     */
    function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Returns all posts of a given thread. By default,
     * posts are sorted by date of creation, decreasingly.
     *
     * @param Thread $thread
     */
    public function getPostsByThread(Thread $thread)
    {
        $documentManager = $this->getDocumentManager();
        return $documentManager
            ->getRepository("ForumForumBundle:Post")
            ->findAllByThread($thread);
    }

    /**
     * @return mixed
     */
    protected function getDocumentManager()
    {
        return $this->container->get('doctrine_mongodb')->getManager();
    }
}