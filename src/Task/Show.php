<?php declare(strict_types=1);
/*
 *   Copyright 2023 Bastian Schwarz <bastian@codename-php.de>.
 *
 *   Licensed under the Apache License, Version 2.0 (the "License");
 *   you may not use this file except in compliance with the License.
 *   You may obtain a copy of the License at
 *
 *         http://www.apache.org/licenses/LICENSE-2.0
 *
 *   Unless required by applicable law or agreed to in writing, software
 *   distributed under the License is distributed on an "AS IS" BASIS,
 *   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *   See the License for the specific language governing permissions and
 *   limitations under the License.
 */

namespace de\codenamephp\deployer\crontab\Task;

use de\codenamephp\deployer\base\task\iTaskWithDescription;
use de\codenamephp\deployer\base\task\iTaskWithName;

/**
 * Lists the crontab ... should have been called 'List' but that is a reserved word
 *
 * @psalm-api
 */
final class Show extends AbstractCrontabCommand implements iTaskWithName, iTaskWithDescription, HasOptionsInterface, HasOutputInteface {

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