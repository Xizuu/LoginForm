<?php

namespace RaihanNih\Utils;

use Symfony\Component\Yaml\Yaml;

class Config
{

    public const YAML = 0; // .yaml, .yml files
    public const JSON = 1; // .json files

    /** @var string $file */
    private string $file;
    /** @var int $type */
    private int $type = self::YAML;
    /** @var array $config */
    private array $config = [];

    public function __construct(string $file, int $type = self::YAML)
    {
        $this->load($file, $type);
    }

    /**
     * @param string $file
     * @param int $type
     */
    private function load(string $file, int $type = self::YAML): void
    {
        $this->file = $file;
        $this->type = $type;

        $content = file_get_contents($this->file);
        $config = match ($this->type) {
            self::JSON => json_decode($content, true, JSON_THROW_ON_ERROR),
            self::YAML => Yaml::parse($content),
            default => throw new \Exception("Invalid config type specified"),
        };
        if(!is_array($config)){
            throw new \Exception("Failed to load config $this->file: Expected array for base type, but got " . get_debug_type($config));
        }
        $this->config = $config;
    }

    public function get(string $k): mixed
    {
        return $this->config[$k] ?? false;
    }
}
