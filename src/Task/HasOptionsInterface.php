<?php declare(strict_types=1);

namespace de\codenamephp\deployer\crontab\Task;

/**
 * Interface for tasks that have additional options
 */
interface HasOptionsInterface {

  /**
   * Returns the options for the task
   *
   * @return array<int, string> The options for the task
   */
  public function getOptions() : array;
}