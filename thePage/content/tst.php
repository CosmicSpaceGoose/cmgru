<?php
    header('HTTP/1.1 500 Internal Server Error');
    header('Content-Type: text/html');
    readfile('path/to/html/file.html');
?>