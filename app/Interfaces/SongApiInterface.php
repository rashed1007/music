<?php

namespace App\Interfaces;

interface SongApiInterface
{
    public function index(array $params = []);

    public function store(array $data);

    public function show(string $uuid);

    public function update(string $uuid, array $data);

    public function delete(string $uuid);
}
