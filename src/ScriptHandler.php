<?php

declare(strict_types=1);

namespace Seferov\ComposerEnvScript;

use Composer\Script\Event;
use InvalidArgumentException;

class ScriptHandler
{
    public static function buildEnv(Event $event): void
    {
        $extras = $event->getComposer()->getPackage()->getExtra();

        $configs = $extras['seferov-env'] ?? [
                [
                    'from-file' => '.env',
                    'to-file' => '.env.local',
                ], ];

        $io = $event->getIO();
        $processor = new Processor($io);

        foreach ($configs as $config) {
            if (!isset($config['from-file']) || !isset($config['to-file'])) {
                throw new InvalidArgumentException('Please make sure "from-file" and "to-file" are configured through composer extra.seferov-env settings');
            }

            $fromFile = $config['from-file'];
            $toFile = $config['to-file'];

            if (!$fromFile = realpath($fromFile)) {
                throw new InvalidArgumentException(sprintf('Please make sure "%s" file exists. Check your composer.json extra.seferov-env settings', $config['from-file']));
            }

            $processor->process($fromFile, $toFile);
        }
    }
}
