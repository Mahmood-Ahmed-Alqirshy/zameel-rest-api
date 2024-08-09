<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

function CSV($fileName): array
{
    $file = File::lines(database_path('csv/' . $fileName . '.csv'));
    $headers = explode(',', $file->first());

    foreach ($file->skip(1) as $line) {
        $data = explode(',', $line);

        $row = [];
        for ($i = 0; $i < count($headers); $i++) {
            $row[$headers[$i]] = $data[$i];
        }

        $rows[] = $row;
    }

    return $rows;
}

function starMapping($source, $sourcePath, &$destination, $destinationPath)
{
    if(substr_count($sourcePath, '*') !== substr_count($destinationPath, '*'))
        throw new Exception("unequal number of stars in \$sourcePath and \$destinationPath", 3);

    if (strpos($sourcePath, '*') == false) {
        Arr::set($destination, $destinationPath, Arr::get($source, $sourcePath, null));
        return;
    }

    $dividedPath = explode('*', $sourcePath, 2);
    $dividedPath[0] = trim($dividedPath[0], '.');
    $arrayToIter = Arr::get($source, $dividedPath[0]);

    for ($i = 0; $i < count($arrayToIter); $i++) {
        $itemSourcePath = preg_replace('/\*/', $i, $sourcePath, 1);
        $itemDestinationPath = preg_replace('/\*/', $i, $destinationPath, 1);

        starMapping($source, $itemSourcePath, $destination, $itemDestinationPath);
    }
}
