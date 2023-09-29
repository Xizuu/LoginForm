<?php

namespace RaihanNih\Utils;

use Symfony\Component\Yaml\Yaml;

class Config
{

    public const YAML = 0;
    public const JSON = 1;

    /** @var string $fileName */
    private string $fileName;
    /** @var string $fileType */
    private string $fileType;

    public function __construct(string $fileName, string $fileType = self::YAML)
    {
        $this->fileName = file_get_contents($fileName);
        $this->fileType = $fileType;
    }

    public function get(string $k): mixed
    {
        if ($this->fileType == self::YAML) {
            $value = Yaml::parse($this->fileName);
            return $value[$k];
        }
        if ($this->fileType == self::JSON) {
            $value = json_decode($this->fileName, true);
            return $value[$k];
        }
    }
}
