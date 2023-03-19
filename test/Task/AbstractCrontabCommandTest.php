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
use de\codenamephp\deployer\command\iCommand;
use de\codenamephp\deployer\command\runner\iRunner;
use de\codenamephp\deployer\command\runner\WithDeployerFunctions;
use de\codenamephp\deployer\crontab\Command\CrontabCommandFactoryInterface;
use de\codenamephp\deployer\crontab\Command\WithBinaryFromDeployer;
use de\codenamephp\deployer\crontab\Task\AbstractCrontabCommand;
use de\codenamephp\deployer\crontab\Task\HasOptionsInterface;
use de\codenamephp\deployer\crontab\Task\HasOutputInteface;
use Mockery;
use PHPUnit\Framework\TestCase;

final class AbstractCrontabCommandTest extends TestCase {

  use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

  public function testGetOptionsWithUser() : void {
    $sut = $this->getMockForAbstractClass(AbstractCrontabCommand::class);

    self::assertSame([], $sut->getOptionsWithUser());
  }

  public function testGetOptionsWithUser_withSetUser() : void {
    $sut = $this->getMockForAbstractClass(AbstractCrontabCommand::class, ['some user']);

    self::assertSame(['-u some user'], $sut->getOptionsWithUser());
  }

  public function testGetOptionsWithUser_withSetUser_andOptions() : void {
    $sut = Mockery::mock(AbstractCrontabCommand::class, HasOptionsInterface::class, ['some user'])->makePartial();
    $sut->allows('getOptions')->once()->andReturn(['some option']);

    self::assertSame(['some option', '-u some user'], $sut->getOptionsWithUser());
  }

  public function test__construct() : void {
    $sut = $this->getMockForAbstractClass(AbstractCrontabCommand::class);

    self::assertNull($sut->user);
    self::assertInstanceOf(WithBinaryFromDeployer::class, $sut->crontabCommandFactory);
    self::assertInstanceOf(WithDeployerFunctions::class, $sut->commandRunner);
  }

  public function test__construct_withOptionalArguments() : void {
    $user = 'some user';
    $crontabCommandFactory = $this->createMock(CrontabCommandFactoryInterface::class);
    $commandRunner = $this->createMock(iRunner::class);

    $sut = $this->getMockForAbstractClass(AbstractCrontabCommand::class, [$user, $crontabCommandFactory, $commandRunner]);

    self::assertSame($user, $sut->user);
    self::assertSame($crontabCommandFactory, $sut->crontabCommandFactory);
    self::assertSame($commandRunner, $sut->commandRunner);
  }

  public function test__invoke() : void {
    $command = $this->createMock(iCommand::class);

    $crontabCommandFactory = $this->createMock(CrontabCommandFactoryInterface::class);
    $crontabCommandFactory->expects(self::once())->method('build')->with(['-u some user'])->willReturn($command);

    $commandRunner = $this->createMock(iRunner::class);
    $commandRunner->expects(self::once())->method('run')->with($command);

    $writeln = $this->createMock(iWriteln::class);
    $writeln->expects(self::never())->method('writeln');

    $sut = $this->getMockForAbstractClass(AbstractCrontabCommand::class, ['some user', $crontabCommandFactory, $commandRunner, $writeln]);
    $sut->__invoke();
  }

  public function test__invoke_canOutput() : void {
    $commandRunner = $this->createMock(iRunner::class);
    $commandRunner->expects(self::once())->method('run')->willReturn('some output');

    $writeln = $this->createMock(iWriteln::class);
    $writeln->expects(self::once())->method('writeln')->with(PHP_EOL . 'some output');

    $sut = Mockery::mock(AbstractCrontabCommand::class, HasOutputInteface::class, ['some user', $this->createMock(CrontabCommandFactoryInterface::class), $commandRunner, $writeln])->makePartial();
    $sut->__invoke();
  }
}
