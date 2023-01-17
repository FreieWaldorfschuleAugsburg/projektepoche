<?php

namespace App\Helpers;

use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\HTTP\IncomingRequest;
use RecursiveDirectoryIterator;

function storeFile(IncomingRequest $request): ?string
{
    $file = $request->getFile('userUploadFile');
    if ($file->isValid() && !$file->hasMoved()) {
        $fileName = getFileName($file);
        $file->move(getUserUploadsFolder(), $fileName);
        return getFilePath($fileName);
    }
    return null;
}

function readCsvToArray(string $fileName): array
{

    $csv = [];
    $file = fopen($fileName, 'r', false);
    while (($row = fgetcsv($file)) !== false) {
        if (empty($keys)) {
            $keys = explode(';', $row[0]);
        } else {
            $row = mb_convert_encoding($row, 'UTF-8', mb_list_encodings());
            $row = explode(';', $row[0]);
            if (count($row) > count($keys)) {
                $row = array_slice($row, 0, count($keys));
            } else {
                $row = array_pad($row, count($keys), '');
            }
            $csv[] = array_combine($keys, $row);
        }
    }
    fclose($file);
    unlink($fileName);
    return $csv;
}


function getFileName(\CodeIgniter\HTTP\Files\UploadedFile $file): string
{
    return $file->getRandomName();
}

function getUserUploadsFolder(): string
{
    return WRITEPATH . "uploads/users/";
}

function deleteDirectoryRecursively(string $path): void
{
    if (file_exists($path)) {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                unlink($filePath);
            } else {
                rmdir($file);
            }
        }
        rmdir($path);
    }
}

function getFilePath(string $fileName): string
{
    return getUserUploadsFolder() . $fileName;
}


//THE DOWNLOAD SCRIPT
function downloadFile($filePath)
{
    if (!empty($filePath)) {
        log_message(2, "Starting download");
        $fileInfo = pathinfo($filePath);
        $fileName = $fileInfo['basename'];
        $fileExtentsion = $fileInfo['extension'];
        $default_contentType = "application/zip";
        $content_types_list = mimeTypes();
        // to find and use specific content type, check out this IANA page : http://www.iana.org/assignments/media-types/media-types.xhtml
        if (array_key_exists($fileExtentsion, $content_types_list)) {
            $contentType = $content_types_list[$fileExtentsion];
        } else {
            $contentType = $default_contentType;
        }
        if (file_exists($filePath)) {
            $size = filesize($filePath);
            $offset = 0;
            $length = $size;
            //HEADERS FOR PARTIAL DOWNLOAD FACILITY BEGINS
            if (isset($_SERVER['HTTP_RANGE'])) {
                preg_match('/bytes=(\d+)-(\d+)?/', $_SERVER['HTTP_RANGE'], $matches);
                $offset = intval($matches[1]);
                $length = intval($matches[2]) - $offset;
                $fhandle = fopen($filePath, 'r');
                fseek($fhandle, $offset); // seek to the requested offset, this is 0 if it's not a partial content request
                $data = fread($fhandle, $length);
                fclose($fhandle);
                header('HTTP/1.1 206 Partial Content');
                header('Content-Range: bytes ' . $offset . '-' . ($offset + $length) . '/' . $size);
            }//HEADERS FOR PARTIAL DOWNLOAD FACILITY BEGINS
            //USUAL HEADERS FOR DOWNLOAD
            header("Content-Disposition: attachment;filename=" . $fileName);
            header('Content-Type: ' . $contentType);
            header("Accept-Ranges: bytes");
            header("Pragma: public");
            header("Expires: -1");
            header("Cache-Control: no-cache");
            header("Cache-Control: public, must-revalidate, post-check=0, pre-check=0");
            header("Content-Length: " . filesize($filePath));
            $chunksize = 8 * (1024 * 1024); //8MB (highest possible fread length)
            if ($size > $chunksize) {
                $handle = fopen($filePath, 'rb');
                $buffer = '';
                while (!feof($handle) && (connection_status() === CONNECTION_NORMAL)) {
                    $buffer = fread($handle, $chunksize);
                    print $buffer;
                    ob_flush();
                    flush();
                }
                if (connection_status() !== CONNECTION_NORMAL) {
                    echo "Connection aborted";
                }
                fclose($handle);
            } else {
                ob_clean();
                flush();
                readfile($filePath);
            }
        } else {
            echo 'File does not exist!';
        }
    } else {
        echo 'There is no file to download!';
    }
}


/* Function to get correct MIME type for download */
function mimeTypes()
{
    /* Just add any required MIME type if you are going to download something not listed here.*/
    $mime_types = [
        "zip" => "application/zip"];
    return $mime_types;
}
