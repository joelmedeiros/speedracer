<?php


namespace App\Service;


class FileManagement
{
    /**
     * @var string
     */
    private $fileName;

    public function __construct(string $filename)
    {
        $this->fileName = $filename;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function read(): array
    {
        $handle = fopen($this->fileName, 'r');

        $pilots = [];

        $line = 0;
        while (!feof($handle)) {
            $content = fgets($handle);
            if ($line === 0 || empty($content)) {
                $line++;
                continue;
            }

            $regex = '/\s\s+/';
            if(preg_match($regex, $content) === 0) {
                throw new \Exception('Invalid file format');
            }

            $data = preg_split($regex, $content, -1, PREG_SPLIT_NO_EMPTY);
            $pilot = trim(explode("–", $data[1])[0]);
            $pilots[$pilot][] = $data;
        }

        fclose($handle);

        return $pilots;
    }
}