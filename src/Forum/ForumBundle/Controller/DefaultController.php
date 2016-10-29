<?php

namespace Forum\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render(
            'ForumForumBundle::main.html.twig',
            [
                'posts' => [
                    [ 'title' => 'Foo', 'image' => 'FooImage' ],
                    [ 'title' => 'Bar', 'image' => 'BarImage' ],
                    [ 'title' => 'Baz', 'image' => 'BazImage' ],
                ]
            ]
        );
    }

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
}
