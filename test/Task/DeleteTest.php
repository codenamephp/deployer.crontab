<?php declare(strict_types=1);

namespace de\codenamephp\deployer\crontab\test\Task;

use de\codenamephp\deployer\command\runner\iRunner;
use de\codenamephp\deployer\crontab\Command\CrontabCommandFactoryInterface;
use de\codenamephp\deployer\crontab\Task\Delete;
use PHPUnit\Framework\TestCase;

final class DeleteTest extends TestCase {

  public function testGetName() : void {
    self::assertSame(Delete::NAME, (new Delete())->getName());
  }

  public function testGetDescription() : void {
    self::assertSame('Deletes the crontab', (new Delete())->getDescription());
  }

  public function testGetOptions() : void {
    self::assertSame(['-r'], (new Delete())->getOptions());
  }

  public function test__invoke() : void {
    $crontabCommandFactory = $this->createMock(CrontabCommandFactoryInterface::class);
    $crontabCommandFactory->expects(self::once())->method('build')->with(['-r']);

    (new Delete(crontabCommandFactory: $crontabCommandFactory, commandRunner: $this->createMock(iRunner::class)))->__invoke();
  }
}
