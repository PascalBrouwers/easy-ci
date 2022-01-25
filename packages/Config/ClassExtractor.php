<?php

declare (strict_types=1);
namespace Symplify\EasyCI\Config;

use EasyCI20220125\Nette\Neon\Encoder;
use EasyCI20220125\Nette\Neon\Neon;
use EasyCI20220125\Nette\Utils\Strings;
use Symplify\EasyCI\Neon\NeonClassExtractor;
use EasyCI20220125\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\EasyCI\Tests\Config\ClassExtractor\ClassExtractorTest
 */
final class ClassExtractor
{
    /**
     * @var string
     * @see https://regex101.com/r/1VKOxi/8
     */
    private const CLASS_NAME_REGEX = '#(?<' . self::INDENT_SPACES . '>^\\s+)?(.*?)(?<quote>["\']?)\\b(?<' . self::CLASS_NAME_PART . '>[A-Za-z](\\w+\\\\(\\\\)?)+(\\w+))(?<next_char>\\\\|\\\\:|(?&quote))?(?!:)$#m';
    /**
     * @var string
     * @see https://regex101.com/r/1IpNtV/3
     */
    private const STATIC_CALL_CLASS_REGEX = '#(?<quote>["\']?)[\\\\]*(?<class_name>[A-Za-z][\\w\\\\]+)::#';
    /**
     * @var string
     */
    private const NEXT_CHAR = 'next_char';
    /**
     * @var string
     */
    private const CLASS_NAME_PART = 'class_name';
    /**
     * @var string
     */
    private const INDENT_SPACES = 'indent_spaces';
    /**
     * @var \Symplify\EasyCI\Neon\NeonClassExtractor
     */
    private $neonClassExtractor;
    public function __construct(\Symplify\EasyCI\Neon\NeonClassExtractor $neonClassExtractor)
    {
        $this->neonClassExtractor = $neonClassExtractor;
    }
    /**
     * @return string[]
     */
    public function extractFromFileInfo(\EasyCI20220125\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : array
    {
        $classNames = [];
        $fileContent = $this->getFileContent($fileInfo);
        if ($fileInfo->getSuffix() === 'neon') {
            // use neon parser
            return $this->neonClassExtractor->extract($fileInfo);
        }
        $classNameMatches = \EasyCI20220125\Nette\Utils\Strings::matchAll($fileContent, self::CLASS_NAME_REGEX);
        foreach ($classNameMatches as $classNameMatch) {
            if (isset($classNameMatch[self::NEXT_CHAR]) && ($classNameMatch[self::NEXT_CHAR] === '\\' || $classNameMatch[self::NEXT_CHAR] === '\\:')) {
                // is Symfony autodiscovery → skip
                continue;
            }
            if ($this->shouldSkipArgument($classNameMatch)) {
                continue;
            }
            $classNames[] = $this->extractClassName($fileInfo, $classNameMatch);
        }
        $staticCallsMatches = \EasyCI20220125\Nette\Utils\Strings::matchAll($fileContent, self::STATIC_CALL_CLASS_REGEX);
        foreach ($staticCallsMatches as $staticCallMatch) {
            $classNames[] = $this->extractClassName($fileInfo, $staticCallMatch);
        }
        return $classNames;
    }
    private function getFileContent(\EasyCI20220125\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : string
    {
        if ($fileInfo->getSuffix() === 'neon') {
            $neon = \EasyCI20220125\Nette\Neon\Neon::decode($fileInfo->getContents());
            // section with no classes that resemble classes
            unset($neon['application']['mapping']);
            unset($neon['mapping']);
            return \EasyCI20220125\Nette\Neon\Neon::encode($neon, \EasyCI20220125\Nette\Neon\Encoder::BLOCK, '    ');
        }
        return $fileInfo->getContents();
    }
    /**
     * @param array<string, string> $match
     */
    private function extractClassName(\EasyCI20220125\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, array $match) : string
    {
        if ($fileInfo->getSuffix() === 'twig' && $match['quote'] !== '') {
            return \str_replace('\\\\', '\\', $match[self::CLASS_NAME_PART]);
        }
        return $match[self::CLASS_NAME_PART];
    }
    /**
     * @param array<string, mixed> $classNameMatch
     */
    private function shouldSkipArgument(array $classNameMatch) : bool
    {
        if (!isset($classNameMatch[self::INDENT_SPACES])) {
            return \false;
        }
        // indented argument
        $indentSpaces = $classNameMatch[self::INDENT_SPACES];
        if (\substr_count($indentSpaces, "\t") >= 3) {
            return \true;
        }
        // in case of spaces
        return \substr_count($indentSpaces, ' ') >= 12;
    }
}
