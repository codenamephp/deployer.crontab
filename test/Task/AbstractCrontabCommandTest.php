<?php declare(strict_types=1);

namespace de\codenamephp\deployer\crontab\test\Task;

use de\codenamephp\deployer\command\iCommand;
use de\codenamephp\deployer\command\runner\iRunner;
use de\codenamephp\deployer\command\runner\WithDeployerFunctions;
use de\codenamephp\deployer\crontab\Command\CrontabCommandFactoryInterface;
use de\codenamephp\deployer\crontab\Command\WithBinaryFromDeployer;
use de\codenamephp\deployer\crontab\Task\AbstractCrontabCommand;
use de\codenamephp\deployer\crontab\Task\HasOptionsInterface;
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
    $user = 'some user';
    $command = $this->createMock(iCommand::class);

    $crontabCommandFactory = $this->createMock(CrontabCommandFactoryInterface::class);
    $crontabCommandFactory->expects(self::once())->method('build')->with(['-u some user'])->willReturn($command);

    $commandRunner = $this->createMock(iRunner::class);
    $commandRunner->expects(self::once())->method('run')->with($command);

    $sut = $this->getMockForAbstractClass(AbstractCrontabCommand::class, [$user, $crontabCommandFactory, $commandRunner]);
    $sut->__invoke();
  }
}
