<?php declare(strict_types=1);

namespace de\codenamephp\deployer\crontab\Command;

use de\codenamephp\deployer\base\functions\All;
use de\codenamephp\deployer\base\functions\iGet;
use de\codenamephp\deployer\command\Command;
use de\codenamephp\deployer\command\iCommand;
use de\codenamephp\deployer\command\runConfiguration\iRunConfiguration;
use de\codenamephp\deployer\command\runConfiguration\SimpleContainer;

/**
 * Gets the crontab binary from deployer and defaults to crontab if it is not set
 *
 * @psalm-api
 */
final class WithBinaryFromDeployer implements CrontabCommandFactoryInterface {

  public function __construct(public iGet $deployer = new All()) {}

  public function build(array $options = [], string $file = null, bool $sudo = false, iRunConfiguration $runConfiguration = null) : iCommand {
    return new Command(
      (string) $this->deployer->get('crontab:binary', 'crontab'),
      $options,
      [],
      $sudo,
      $runConfiguration ?? new SimpleContainer());
  }
}