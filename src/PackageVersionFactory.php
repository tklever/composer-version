<?php

namespace Klever\ComposerVersion;

use Composer\Json\JsonFile;
use Composer\Repository\InstalledFilesystemRepository;

abstract class PackageVersionFactory
{
    public static function factory(array $config = array())
    {
        $defaultConfig = array(
            'vendor-dir' => "vendor"
        );

        $config = array_merge($defaultConfig, $config);
        $installedFile = $config['vendor-dir'] . '/composer/installed.json';

        $jsonFile = new JsonFile($installedFile);
        $repo = new InstalledFilesystemRepository($jsonFile);
        return new PackageVersion($repo);
    }
}
