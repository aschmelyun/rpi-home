<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;

class FileController extends Controller
{

    public function index()
    {
        $filesDir = storage_path('app/files/');

        $finder = new Finder();
        $files = $finder->files()
            ->in($filesDir)
            ->ignoreDotFiles(true)
            ->sortByModifiedTime();

        return $files;
    }

}
