<?php

namespace Juuuuuu\Silex;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Yaml\Parser;

class YamlConfigServiceProvider implements ServiceProviderInterface
{
    private $filename;
    private $parser;

    function __construct($filename) {
        $this->filename = $filename;
        $this->parser = new Parser();
    }

    public function register(Container $app)
    {
        $config = $this->getConfig();
        $this->merge($app, $config);
    }

    private function getConfig()
    {
        if (!$this->filename) {
            throw new \RuntimeException('A valid configuration file must be passed before reading the config.');
        }

        if (!file_exists($this->filename)) {
            throw new \InvalidArgumentException(
                sprintf("The config file '%s' does not exist.", $this->filename));
        }

        return $this->load($this->filename);

        throw new \InvalidArgumentException(
                sprintf("The config file '%s' appears to have an invalid format.", $this->filename));
    }

    private function load($filename)
    {
        if (!class_exists('Symfony\\Component\\Yaml\\Yaml')) {
            throw new \RuntimeException('Unable to read yaml as the Symfony Yaml Component is not installed.');
        }

        $config = $this->parser->parse(file_get_contents($this->filename));

        return $config ?: array();
    }

    private function merge(Container $app, array $config)
    {
        foreach ($config as $name => $value) {
            $app[$name] = $value;
        }
    }
}
