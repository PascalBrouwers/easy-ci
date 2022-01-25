<?php

declare (strict_types=1);
namespace Symplify\EasyCI\Testing\Autoloading;

use EasyCI20220125\PHPUnit\Framework\TestCase;
/**
 * To ease detection of dual test case classes.
 */
final class DualTestCaseAuloader
{
    /**
     * @var string
     */
    private const UNDERSCORED_TEST_CASE_CLASS = 'PHPUnit_Framework_TestCase';
    public function autoload() : void
    {
        if (!\class_exists(self::UNDERSCORED_TEST_CASE_CLASS)) {
            // alias new test case to old one
            \class_alias(\EasyCI20220125\PHPUnit\Framework\TestCase::class, self::UNDERSCORED_TEST_CASE_CLASS);
            return;
        }
        if (!\class_exists(\EasyCI20220125\PHPUnit\Framework\TestCase::class)) {
            // alias old test case to new one
            \class_alias(self::UNDERSCORED_TEST_CASE_CLASS, \EasyCI20220125\PHPUnit\Framework\TestCase::class);
        }
    }
}
