<?php

/**
 * @file
 * Tests event dispatching.
 */
namespace EasyCI20220527\cweagans\Composer\Tests;

use EasyCI20220527\cweagans\Composer\PatchEvent;
use EasyCI20220527\cweagans\Composer\PatchEvents;
use EasyCI20220527\Composer\Package\PackageInterface;
class PatchEventTest extends \EasyCI20220527\PHPUnit_Framework_TestCase
{
    /**
     * Tests all the getters.
     *
     * @dataProvider patchEventDataProvider
     */
    public function testGetters($event_name, \EasyCI20220527\Composer\Package\PackageInterface $package, $url, $description)
    {
        $patch_event = new \EasyCI20220527\cweagans\Composer\PatchEvent($event_name, $package, $url, $description);
        $this->assertEquals($event_name, $patch_event->getName());
        $this->assertEquals($package, $patch_event->getPackage());
        $this->assertEquals($url, $patch_event->getUrl());
        $this->assertEquals($description, $patch_event->getDescription());
    }
    public function patchEventDataProvider()
    {
        $prophecy = $this->prophesize('EasyCI20220527\\Composer\\Package\\PackageInterface');
        $package = $prophecy->reveal();
        return array(array(\EasyCI20220527\cweagans\Composer\PatchEvents::PRE_PATCH_APPLY, $package, 'https://www.drupal.org', 'A test patch'), array(\EasyCI20220527\cweagans\Composer\PatchEvents::POST_PATCH_APPLY, $package, 'https://www.drupal.org', 'A test patch'));
    }
}
