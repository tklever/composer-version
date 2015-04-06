<?php

namespace KleverTest\ComposerVersion;

use Composer\Package\Version\VersionParser;
use Klever\ComposerVersion\PackageVersionFactory;

class PackageVersionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Klever\ComposerVersion\PackageVersion
     */
    protected $packageVersion;

    protected function setUp()
    {
        $this->packageVersion = PackageVersionFactory::factory(
            array('vendor-dir' => __DIR__ . '/TestAssets')
        );
    }

    public function testVersionParserAccessorMethods()
    {
        $versionParser = $this->packageVersion->getVersionParser();
        $this->assertInstanceOf('Composer\Package\Version\VersionParser', $versionParser);

        $versionParser2 = new VersionParser();
        $this->packageVersion->setVersionParser($versionParser2);
        $this->assertSame($versionParser2, $this->packageVersion->getVersionParser());
    }

    public function testHasPackageReturnsTrueOnValidPackage()
    {
        $this->assertTrue(
            $this->packageVersion->hasPackage('testvendor/fake-package')
        );
    }

    public function testHasPackageReturnsFalseOnInvalidPackage()
    {
        $this->assertFalse(
            $this->packageVersion->hasPackage('awfulnamespace/invalid-package')
        );
    }

    public function testVersionCompareReturnsOneOnInstalledVersionOnePointOne()
    {
        $this->assertEquals(
            1,
            $this->packageVersion->versionCompare('testvendor/fake-package', '1.1')
        );
    }

    public function testVersionCompareReturnsNegativeOneOnInstalledVersionOnePointNine()
    {
        $this->assertEquals(
            -1,
            $this->packageVersion->versionCompare('testvendor/fake-package', '1.9')
        );
    }

    public function testVersionCompareReturnsZeroOnInstalledVersionOnePointFivePointOne()
    {
        $this->assertEquals(
            0,
            $this->packageVersion->versionCompare('testvendor/fake-package', '1.5.1')
        );
    }

    public function testVersionCompareReturnsFalseOnInstalledVersionLessThanOnePointOne()
    {
        $this->assertFalse(
            $this->packageVersion->versionCompare('testvendor/fake-package', '1.1', '<')
        );
    }

    public function testVersionCompareReturnsTrueOnInstalledVersionGreaterThanOnePointOne()
    {
        $this->assertTrue(
            $this->packageVersion->versionCompare('testvendor/fake-package', '1.1', '>')
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsExceptionOnBadComparisonOperator()
    {
        $this->packageVersion->versionCompare('testvendor/fake-package', '1.1', 'INVALID');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsExceptionOnInvalidPackage()
    {
        $this->packageVersion->versionCompare('awfulnamespace/invalid-package', '1.5');
    }
}
