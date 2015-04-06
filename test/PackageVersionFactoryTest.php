<?php

namespace KleverTest\ComposerVersion;

use Klever\ComposerVersion\PackageVersionFactory;

class PackageVersionFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreatesPackageVersion()
    {
        $packageVersion = PackageVersionFactory::factory();
        $this->assertInstanceOf('Klever\ComposerVersion\PackageVersion', $packageVersion);
    }
}
