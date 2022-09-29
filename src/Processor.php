<?php

declare(strict_types=1);

namespace Seferov\ComposerEnvScript;

use Composer\IO\IOInterface;
use Seferov\DotEnv\DotEnv;

class Processor
{
    private IOInterface $io;

    public function __construct(IOInterface $io)
    {
        $this->io = $io;
    }

    public function process(string $fromFile, string $toFile): void
    {
        if (!is_file($toFile)) {
            fopen($toFile, 'w');

            $this->io->write(sprintf('<info><options=bold>%s</> is created</info>', $toFile));
        }

        $toFile = realpath($toFile);

        $fromEnv = new DotEnv($fromFile);
        $toEnv = new DotEnv($toFile);

        $missingNames = array_diff(array_keys($fromEnv->asArray()), array_keys($toEnv->asArray()));
        if ([] === $missingNames) {
            return;
        }

        $this->io->write(sprintf('<info>Updating <options=bold>%s</> ...</info>', $toFile));

        foreach ($fromEnv->asArray() as $name => $default) {
            if (!in_array($name, $missingNames, true)) {
                continue;
            }

            $value = $this->io->ask(sprintf('<question>%s</question> (<comment>%s</comment>): ', $name, $default), $default);

            $toEnv->add($name, $value);
        }

        $toEnv->write();
    }
}
