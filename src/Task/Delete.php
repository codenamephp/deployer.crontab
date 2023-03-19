<?php declare(strict_types=1);

namespace de\codenamephp\deployer\crontab\Task;

use de\codenamephp\deployer\base\task\iTaskWithDescription;
use de\codenamephp\deployer\base\task\iTaskWithName;

/**
 * Deletes the crontab without asking for confirmation
 *
 * @psalm-api
 */
final class Delete extends AbstractCrontabCommand implements iTaskWithName, iTaskWithDescription {

  public const NAME = 'crontab:delete';

  public function getOptions() : array {
    return ['-r'];
  }

  public function getDescription() : string {
    return 'Deletes the crontab';
  }

  public function getName() : string {
    return self::NAME;
  }
}