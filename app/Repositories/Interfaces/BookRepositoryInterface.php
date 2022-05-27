<?php

namespace App\Repositories\Interfaces;

interface BookRepositoryInterface
{
    public function all($request);
    public function one($id);
    public function attach($bookId, $genreId);
    public function detach($bookId, $genreId);
}