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

namespace de\codenamephp\deployer\crontab\test\Task;

use de\codenamephp\deployer\base\functions\iWriteln;
use de\codenamephp\deployer\command\runner\iRunner;
use de\codenamephp\deployer\crontab\Command\CrontabCommandFactoryInterface;
use de\codenamephp\deployer\crontab\Task\Show;
use PHPUnit\Framework\TestCase;

final class ShowTest extends TestCase {

  public function testGetName() : void {
    self::assertSame(Show::NAME, (new Show())->getName());
  }

  public function testGetOptions() : void {
    self::assertSame(['-l'], (new Show())->getOptions());
  }

  public function testGetDescription() : void {
    self::assertSame('Shows the crontab', (new Show())->getDescription());
  }

  public function test__invoke() : void {
    $crontabCommandFactory = $this->createMock(CrontabCommandFactoryInterface::class);
    $crontabCommandFactory->expects(self::once())->method('build')->with(['-l']);

    $writeln = $this->createMock(iWriteln::class);
    $writeln->expects(self::once())->method('writeln');

    (new Show(crontabCommandFactory: $crontabCommandFactory, commandRunner: $this->createMock(iRunner::class), writeln: $writeln))->__invoke();
  }
}
