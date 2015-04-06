<?php

namespace Klever\ComposerVersion;

use Composer\Package\Version\VersionParser;
use Composer\Repository\RepositoryInterface;

class PackageVersion
{
    protected $repository;
    protected $versionParser;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function getVersionParser()
    {
        if ($this->versionParser === null) {
            $this->versionParser = new VersionParser();
        }
        return $this->versionParser;
    }

    /**
     * @param VersionParser $versionParser
     */
    public function setVersionParser(VersionParser $versionParser)
    {
        $this->versionParser = $versionParser;
    }

    public function hasPackage($packageName)
    {
        $package = $this->getPackage($packageName);
        if ($package) {
            return true;
        }
        return false;
    }

    public function versionCompare($packageName, $version, $operator = null)
    {
        $package = $this->getPackage($packageName);
        if (!$package) {
            throw new \InvalidArgumentException('Package not found in repository');
        }

        $parser = $this->getVersionParser();
        $version = $parser->normalize($version);

        if ($operator) {
            $comparison = version_compare($package->getVersion(), $version, $operator);
            if ($comparison === null) {
                throw new \InvalidArgumentException('Invalid operator provided');
            }
            return $comparison;
        }

        return version_compare($package->getVersion(), $version);
    }

    protected function getPackage($packageName)
    {
        $packages = $this->repository->findPackages($packageName);
        if(count($packages) === 0) {
            return;
        }

        return array_shift($packages);
    }
}
