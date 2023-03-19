<?php declare(strict_types=1);

namespace de\codenamephp\deployer\crontab\test\Task;

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
}
