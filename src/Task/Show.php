<?php declare(strict_types=1);

namespace de\codenamephp\deployer\crontab\Task;

use de\codenamephp\deployer\base\task\iTaskWithDescription;
use de\codenamephp\deployer\base\task\iTaskWithName;

/**
 * Lists the crontab ... should have been called 'List' but that is a reserved word
 *
 * @psalm-api
 */
final class Show extends AbstractCrontabCommand implements iTaskWithName, iTaskWithDescription, HasOptionsInterface {

  public const NAME = 'crontab:show';

  public function getOptions() : array {
    return ['-l'];
  }

  public function getDescription() : string {
    return 'Shows the crontab';
  }

  public function getName() : string {
    return self::NAME;
  }
}