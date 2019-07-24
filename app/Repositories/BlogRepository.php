<?php

namespace App\Repositories;

use App\Entities\Blog;
use Mvc\Databases\Repository;

/**
 * Class BlogRepository
 * @package App\Repositories
 */
class BlogRepository extends Repository
{
    /**
     * @return array
     */
    public function all(): array
    {
        $request = $this->connection->request('SELECT id, name, slug, content, created_at FROM blog');

        $posts = [];
        while ($post = $request->fetch()) {
            $posts[] = new Blog($post);
        }

        return $posts;
    }
}
