<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

function CSV($fileName): array
{
    $file = File::lines(database_path('csv/'.$fileName.'.csv'));
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

/**
 * Recursively maps values from a source array to a destination array based on a source path and destination path.
 *
 * The source path and destination path can contain a wildcard (`*`) character to indicate that the value should be mapped
 * to an array index in the destination. The number of wildcards in the source path and destination path must be equal.
 *
 * If the source path does not contain a wildcard, the value is directly set in the destination array using the destination path.
 *
 * @param  array  $source  The source array to map values from.
 * @param  string  $sourcePath  The path in the source array to map values from, using a wildcard (`*`) to indicate array indices.
 * @param  array  $destination  The destination array to map values to.
 * @param  string  $destinationPath  The path in the destination array to map values to, using a wildcard (`*`) to indicate array indices.
 *
 * @throws Exception If the number of wildcards in the source path and destination path are not equal.
 */
function starMapping($source, $sourcePath, &$destination, $destinationPath)
{
    if (substr_count($sourcePath, '*') !== substr_count($destinationPath, '*')) {
        throw new Exception('unequal number of stars in $sourcePath and $destinationPath', 3);
    }

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
