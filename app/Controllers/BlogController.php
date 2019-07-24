<?php

namespace App\Controllers;

use App\Repositories\BlogRepository;
use Mvc\Http\HtmlResponse;
use Mvc\Http\Request;
use Mvc\Http\Response;

/**
 * Class BlogController
 * @package App\Controllers
 */
class BlogController
{
    /** @var BlogRepository $blogRepository */
    private $blogRepository;

    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    public function index()
    {
        $posts = $this->blogRepository->all();
        return new HtmlResponse('blog/index', ['posts' => $posts], 'base');
    }

    /**
     * @param string $slug
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function show(string $slug, int $id, Request $request)
    {
        return new HtmlResponse('blog/show', ['id' => $id, 'slug' => $slug], 'base');
    }
}
