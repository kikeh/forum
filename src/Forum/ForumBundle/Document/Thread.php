<?php

namespace Forum\ForumBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * An instance of a Thread
 *
 * @MongoDB\Document
 * @MongoDB\Document(repositoryClass="Forum\ForumBundle\Repository\ThreadRepository")
 * @MongoDB\Index(keys={"createdAt" = "desc"})
 */
class Thread
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     * @var string
     */
    protected $title;

    /**
     * @MongoDB\Date
     * @Gedmo\Timestampable
     * @var date
     */
    protected $createdAt;

    /**
     * @MongoDB\Date
     * @Gedmo\Timestampable
     * @var date
     */
    protected $updatedAt;

    /**
     *
     * @MongoDB\ReferenceMany(targetDocument="Forum\ForumBundle\Document\Post", mappedBy="thread", cascade={"remove"})
     */
    protected $posts;

    /**
     * Thread constructor.
     *
     * @param $title
     */
    public function __construct($title)
    {
        $this->title = $title;
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set createdAt
     *
     * @param date $createdAt
     * @return self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return date $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param date $updatedAt
     * @return self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return date $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * Add post
     *
     * @param \Forum\ForumBundle\Document\Post $post
     */
    public function addPost(Post $post)
    {
        $this->posts[] = $post;
    }

    /**
     * Remove post
     *
     * @param \Forum\ForumBundle\Document\Post $post
     */
    public function removePost(Post $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection $posts
     */
    public function getPosts()
    {
        return $this->posts;
    }
}
