<?php declare(strict_types=1);

namespace de\codenamephp\deployer\crontab\Task;

use de\codenamephp\deployer\base\task\iTask;
use de\codenamephp\deployer\command\runner\iRunner;
use de\codenamephp\deployer\command\runner\WithDeployerFunctions;
use de\codenamephp\deployer\crontab\Command\CrontabCommandFactoryInterface;
use de\codenamephp\deployer\crontab\Command\WithBinaryFromDeployer;

/**
 * Abstract class for crontab commands that allows an optional user. If the user is given it is set with -u to the crontab command.
 * The command to run is passed to the constructor and is executed by the command runner.
 *
 * Implementations can implement HasOptionsInterface to add additional options to the command.
 */
abstract class AbstractCrontabCommand implements iTask {

  public function __construct(
    public readonly ?string $user = null,
    public readonly CrontabCommandFactoryInterface $crontabCommandFactory = new WithBinaryFromDeployer(),
    public readonly iRunner $commandRunner = new WithDeployerFunctions()
  ) {}

  /**
   * Checks for the HasOptionsInterface and if it's implemented the return value is used as base. Then adds the user option if it is set.
   *
   * @return array<int, string> The options to pass to the crontab command
   */
  final public function getOptionsWithUser() : array {
    $options = $this instanceof HasOptionsInterface ? $this->getOptions() : [];
    !$this->user ?: $options[] = "-u $this->user";
    return $options;
  }

  final public function __invoke() : void {
    $this->commandRunner->run($this->crontabCommandFactory->build($this->getOptionsWithUser()));
  }
}