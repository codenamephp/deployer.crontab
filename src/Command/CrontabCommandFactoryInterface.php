<?php declare(strict_types=1);

namespace de\codenamephp\deployer\crontab\Command;

use de\codenamephp\deployer\command\iCommand;
use de\codenamephp\deployer\command\runConfiguration\iRunConfiguration;

/**
 * Interface for factories that create crontab commands, e.g. by getting the binary from deployer
 *
 * @psalm-api
 */
interface CrontabCommandFactoryInterface
{
    /**
     * Implementations MUST make sure the command gets the correct binary (e.g. from deployer) and that all parameters are passed on correctly
     *
     * @param array<int, string> $options Array of arguments to pass to the command with numerical indexes so the arguments can be expanded, e.g. ['--production', '--fund=false']
     * @param string|null $file The file to use. Defaults to null which means the default crontab file will be used
     * @param bool $sudo Flag if the command should be executed as root
     * @param iRunConfiguration|null $runConfiguration The run configuration for the command. Defaults to an empty configuration
     * @return iCommand The command to run
     */
    public function build(array $options = [], string $file = null, bool $sudo = false, iRunConfiguration $runConfiguration = null) : iCommand;
}