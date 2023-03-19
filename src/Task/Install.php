<?php declare(strict_types=1);

namespace de\codenamephp\deployer\crontab\Task;

use de\codenamephp\deployer\base\task\iTaskWithDescription;
use de\codenamephp\deployer\base\task\iTaskWithName;
use de\codenamephp\deployer\command\runner\iRunner;
use de\codenamephp\deployer\command\runner\WithDeployerFunctions;
use de\codenamephp\deployer\crontab\Command\CrontabCommandFactoryInterface;
use de\codenamephp\deployer\crontab\Command\WithBinaryFromDeployer;

/**
 * Installs the given crontab file
 *
 * @psalm-api
 */
final class Install extends AbstractCrontabCommand implements iTaskWithName, iTaskWithDescription, HasOptionsInterface {

  public const NAME = 'crontab:install';

  public function __construct(
    public readonly string $file = '{{release_or_current_path}}/crontab',
    ?string $user = null,
    CrontabCommandFactoryInterface $crontabCommandFactory = new WithBinaryFromDeployer(),
    iRunner $commandRunner = new WithDeployerFunctions()
  ) {
    parent::__construct($user, $crontabCommandFactory, $commandRunner);
  }

  public function getOptions() : array {
    return [$this->file];
  }

  public function getDescription() : string {
    return 'Installs the given crontab file.';
  }

  public function getName() : string {
    return self::NAME;
  }
}