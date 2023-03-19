<?php declare(strict_types=1);

namespace de\codenamephp\deployer\crontab\test\Task;

use de\codenamephp\deployer\command\runner\iRunner;
use de\codenamephp\deployer\command\runner\WithDeployerFunctions;
use de\codenamephp\deployer\crontab\Command\CrontabCommandFactoryInterface;
use de\codenamephp\deployer\crontab\Command\WithBinaryFromDeployer;
use de\codenamephp\deployer\crontab\Task\Install;
use PHPUnit\Framework\TestCase;

final class InstallTest extends TestCase {

  public function testGetName() : void {
    self::assertSame(Install::NAME, (new Install())->getName());
  }

  public function testGetOptions() : void {
    self::assertSame(['some file'], (new Install('some file'))->getOptions());
  }

  public function testGetDescription() : void {
    self::assertSame('Installs the given crontab file.', (new Install())->getDescription());
  }

  public function test__construct() : void {
    $sut = new Install();

    self::assertSame('{{release_or_current_path}}/crontab', $sut->file);
    self::assertNull($sut->user);
    self::assertInstanceOf(WithBinaryFromDeployer::class, $sut->crontabCommandFactory);
    self::assertInstanceOf(WithDeployerFunctions::class, $sut->commandRunner);
  }
  public function test__construct_WithOptionalArguments() : void {
    $commandFactory = $this->createMock(CrontabCommandFactoryInterface::class);
    $commandRunner = $this->createMock(iRunner::class);

    $sut = new Install('some file', 'some user', $commandFactory, $commandRunner);

    self::assertSame('some file', $sut->file);
    self::assertSame('some user', $sut->user);
    self::assertSame($commandFactory, $sut->crontabCommandFactory);
    self::assertSame($commandRunner, $sut->commandRunner);
  }
}
