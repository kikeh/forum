<?php

namespace Forum\ForumBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Forum\ForumBundle\Document\Thread;

class PostRepository extends DocumentRepository
{
    public function findAllByThread(Thread $thread, $hydrate = false)
    {
        return $this->createQueryBuilder()
            ->field('thread')->references($thread)
            ->sort('createdAt', 'desc')
            ->hydrate($hydrate)
            ->getQuery()
            ->execute();
    }
}
