<?php

// PHP Script to insert metas from CSV file
function run()
{

    // Define files and CSV route
    $p = glob("files/*.html");
    $csvRoute = 'example.csv';

    // Parse CSV and converts to array with headers
    $rows = array_map('str_getcsv', file($csvRoute));
    $header = array_shift($rows);
    $csv = array();
    foreach ($rows as $row) {
        $csv[] = array_combine($header, $row);
    }

    $count = 0;

    // Bucle to replace metas if they match the url name
    foreach ($p as $fileName) {
        $content = file_get_contents($fileName);
        foreach ($csv as $key => $array) {
            if ($fileName == array_values($array)[0]) {
                $count++;
                $title = array_values($array)[1];
                $metaDescription = array_values($array)[2];
                $content = preg_replace('/<title>(.+)<\/title>/i',
                    '<title>' . $title . '</title><meta name="description" content="' . $metaDescription . '">',
                    $content);
                file_put_contents($fileName, $content);
                echo 'Modificando el archivo ' . $fileName . ' <br/>';
            }
        }
    }

    echo '¡Script terminado! Se han modificado '.$count.' archivos';
}

run();