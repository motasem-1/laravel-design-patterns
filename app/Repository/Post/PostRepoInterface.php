<?php

namespace App\Repository;

interface PostRepoInterface
{

    public function index();
    public function store($request);
    public function update($request,$id);
    public function multi_delete($request);

    
}