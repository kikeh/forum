<?php

namespace Forum\ForumBundle\Manager;

use Forum\ForumBundle\Document\Thread;

class ThreadManager
{
    private $container;

    /**
     * ThreadManager constructor.
     * @param $container
     */
    function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Returns a thread given an id
     *
     * @param $id
     */
    public function getThreadById($id)
    {
        $documentManager = $this->getDocumentManager();
        return $documentManager
            ->getRepository("ForumForumBundle:Thread")
            ->findOneById($id);
    }

    /**
     * Returns a thread given a title
     *
     * @param $title
     */
    public function getThreadByTitle($title)
    {
        $documentManager = $this->getDocumentManager();
        return $documentManager
            ->getRepository("ForumForumBundle:Thread")
            ->findOneByTitle($title);
    }

    public function getThreadTotalViews(Thread $thread)
    {
        $totalViews = 0;

        $documentManager = $this->getDocumentManager();
        $posts = $documentManager
            ->getRepository("ForumForumBundle:Post")
            ->findAllByThread($thread);

        foreach ($posts as $post) {
            $totalViews += $post['views'];
        }

        return $totalViews;
    }

    /**
     * @return mixed
     */
    protected function getDocumentManager()
    {
        return $this->container->get('doctrine_mongodb')->getManager();
    }
}