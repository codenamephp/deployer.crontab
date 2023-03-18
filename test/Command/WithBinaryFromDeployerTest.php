<?php declare(strict_types=1);

namespace de\codenamephp\deployer\crontab\test\Command;

use de\codenamephp\deployer\base\functions\All;
use de\codenamephp\deployer\base\functions\iGet;
use de\codenamephp\deployer\command\Command;
use de\codenamephp\deployer\command\runConfiguration\iRunConfiguration;
use de\codenamephp\deployer\command\runConfiguration\SimpleContainer;
use de\codenamephp\deployer\crontab\Command\WithBinaryFromDeployer;
use PHPUnit\Framework\TestCase;

final class WithBinaryFromDeployerTest extends TestCase {

  public function test__construct() : void {
    $sut = new WithBinaryFromDeployer();

    self::assertInstanceOf(All::class, $sut->deployer);
  }

  public function test__construct_withOptionalArguments() : void {
    $deployer = $this->createMock(iGet::class);

    $sut = new WithBinaryFromDeployer($deployer);

    self::assertSame($deployer, $sut->deployer);
  }

  public function testBuild() : void {
    $deployer = $this->createMock(iGet::class);
    $deployer->expects(self::once())->method('get')->with('crontab:binary', 'crontab')->willReturn('crontab');

    $sut = new WithBinaryFromDeployer($deployer);

    $command = $sut->build();

    self::assertEquals(new Command('crontab', [], [], false, new SimpleContainer()), $command);
  }

  public function testBuild_withOptionalArguments() : void {
    $deployer = $this->createMock(iGet::class);
    $deployer->expects(self::once())->method('get')->with('crontab:binary', 'crontab')->willReturn(null);

    $sut = new WithBinaryFromDeployer($deployer);

    $runConfiguration = $this->createMock(iRunConfiguration::class);

    $command = $sut->build(['some', 'options'], 'someFile', true, $runConfiguration);

    self::assertEquals(new Command('', ['some', 'options'], [], true, $runConfiguration), $command);
  }
}
