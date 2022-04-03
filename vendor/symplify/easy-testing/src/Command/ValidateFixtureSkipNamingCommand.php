<?php

declare (strict_types=1);
namespace EasyCI20220403\Symplify\EasyTesting\Command;

use EasyCI20220403\Symfony\Component\Console\Input\InputArgument;
use EasyCI20220403\Symfony\Component\Console\Input\InputInterface;
use EasyCI20220403\Symfony\Component\Console\Output\OutputInterface;
use EasyCI20220403\Symplify\EasyTesting\Finder\FixtureFinder;
use EasyCI20220403\Symplify\EasyTesting\MissplacedSkipPrefixResolver;
use EasyCI20220403\Symplify\EasyTesting\ValueObject\Option;
use EasyCI20220403\Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand;
final class ValidateFixtureSkipNamingCommand extends \EasyCI20220403\Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand
{
    /**
     * @var \Symplify\EasyTesting\MissplacedSkipPrefixResolver
     */
    private $missplacedSkipPrefixResolver;
    /**
     * @var \Symplify\EasyTesting\Finder\FixtureFinder
     */
    private $fixtureFinder;
    public function __construct(\EasyCI20220403\Symplify\EasyTesting\MissplacedSkipPrefixResolver $missplacedSkipPrefixResolver, \EasyCI20220403\Symplify\EasyTesting\Finder\FixtureFinder $fixtureFinder)
    {
        $this->missplacedSkipPrefixResolver = $missplacedSkipPrefixResolver;
        $this->fixtureFinder = $fixtureFinder;
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setName('validate-fixture-skip-naming');
        $this->addArgument(\EasyCI20220403\Symplify\EasyTesting\ValueObject\Option::SOURCE, \EasyCI20220403\Symfony\Component\Console\Input\InputArgument::REQUIRED | \EasyCI20220403\Symfony\Component\Console\Input\InputArgument::IS_ARRAY, 'Paths to analyse');
        $this->setDescription('Check that skipped fixture files (without `-----` separator) have a "skip" prefix');
    }
    protected function execute(\EasyCI20220403\Symfony\Component\Console\Input\InputInterface $input, \EasyCI20220403\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $source = (array) $input->getArgument(\EasyCI20220403\Symplify\EasyTesting\ValueObject\Option::SOURCE);
        $fixtureFileInfos = $this->fixtureFinder->find($source);
        $incorrectAndMissingSkips = $this->missplacedSkipPrefixResolver->resolve($fixtureFileInfos);
        foreach ($incorrectAndMissingSkips->getIncorrectSkipFileInfos() as $incorrectSkipFileInfo) {
            $errorMessage = \sprintf('The file "%s" should drop the "skip/keep" prefix', $incorrectSkipFileInfo->getRelativeFilePathFromCwd());
            $this->symfonyStyle->note($errorMessage);
        }
        foreach ($incorrectAndMissingSkips->getMissingSkipFileInfos() as $missingSkipFileInfo) {
            $errorMessage = \sprintf('The file "%s" should start with "skip/keep" prefix', $missingSkipFileInfo->getRelativeFilePathFromCwd());
            $this->symfonyStyle->note($errorMessage);
        }
        $countError = $incorrectAndMissingSkips->getFileCount();
        if ($incorrectAndMissingSkips->getFileCount() === 0) {
            $message = \sprintf('All %d fixture files have valid names', \count($fixtureFileInfos));
            $this->symfonyStyle->success($message);
            return self::SUCCESS;
        }
        $errorMessage = \sprintf('Found %d test file fixtures with wrong prefix', $countError);
        $this->symfonyStyle->error($errorMessage);
        return self::FAILURE;
    }
}
