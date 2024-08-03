<?php

use Illuminate\Support\Facades\File;

function CSV($fileName): array
{
    $file = File::lines(database_path('csv\\'.$fileName.'.csv'));
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
