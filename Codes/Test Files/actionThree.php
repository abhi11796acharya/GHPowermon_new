<?php

$file_handle = fopen("reading.csv", "r");

while (!feof($file_handle) ) {

$line_of_text = fgetcsv($file_handle, 1024);

print $line_of_text[0]." " . $line_of_text[1]." ". $line_of_text[2] . " ". $line_of_text[3]." ". $line_of_text[4]." ". $line_of_text[5]."<BR>";

}

fclose($file_handle);

?>