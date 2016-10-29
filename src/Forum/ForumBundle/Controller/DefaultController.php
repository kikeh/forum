<?php

namespace Forum\ForumBundle\Controller;

use Doctrine\ODM\MongoDB\DocumentManager;
use Forum\ForumBundle\Document\Post;
use Forum\ForumBundle\Document\Thread;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $mainThread = $this->getMainThread();
        $threadManager = $this->getThreadManager();
        $postManager = $this->getPostManager();
        $posts = $postManager->getPostsByThread($mainThread);
        $totalViews = $threadManager->getThreadTotalViews($mainThread);

        return $this->render(
            'ForumForumBundle:Default:layout.html.twig',
            [
                'thread' => $mainThread,
                'posts'  => $posts,
                'totalViews' => $totalViews
            ]
        );
    }

    /**
     * @return JsonResponse
     */
    public function createAction()
    {
        $documentManager = $this->getDocumentManager();
        $threadManager = $this->getThreadManager();
        $content = $this->get("request")->getContent();

        if (empty($content)) {
            return new JsonResponse(
                ['message' => 'No content'],
                400
            );
        } else {
            $parameters = json_decode($content, true);

            // Get post information
            $threadId = $parameters['threadId'];
            $title = $parameters['title'];
            $file = $parameters['file'];

            // Get thread
            $thread = $threadManager->getThreadById($threadId);

            // Create and persist post
            $post = new Post();
            $post->setTitle($title);
            $post->setThread($thread);
            $post->setFilename($file);
            $documentManager->persist($post);
            $documentManager->flush();

            return new JsonResponse(
                ['message' => 'Post successfully created'],
                200
            );
        }
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function uploadAction(Request $request)
    {
        // retrieve the file with the name given in the form.
        // do var_dump($request->files->all()); if you need to know if the file is being uploaded.
        $file = $request->files->get('upload');
        $status = ['status' => "success", "fileUploaded" => false];

        // If a file was uploaded
        if (!is_null($file)) {
            // generate a random name for the file but keep the extension
            $filename = uniqid() . "." . $file->getClientOriginalExtension();
            $path = "web/files/";
            $file->move($path, $filename); // move the file to a path
            $status = ['status' => "success", "fileUploaded" => true];
        }

        return new JsonResponse($status);
    }

    /**
     * Returns the Document Manager
     *
     * @return DocumentManager
     */
    protected function getDocumentManager()
    {
        return $this->container->get('doctrine_mongodb')->getManager();
    }

    /**
     * Returns the Thread Manager
     *
     * @return \Forum\ForumBundle\Manager\ThreadManager
     */
    protected function getThreadManager()
    {
        return $this->container->get('forum.thread.manager');
    }

    /**
     * Returns the Post Manager
     *
     * @return \Forum\ForumBundle\Manager\PostManager
     */
    protected function getPostManager()
    {
        return $this->container->get('forum.post.manager');
    }

    /**
     * Returns the main thread. By now, we  will be using only a main thread,
     * but  in  a further  version,  there  might  be an  implementation  for
     * creating multiple threads.
     *
     * @return Thread
     */
    protected function getMainThread()
    {
        return $this->getThreadManager()->getThreadByTitle("main_thread");
    }
}
