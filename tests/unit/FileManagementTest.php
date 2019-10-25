<?php

namespace App\Tests;

use App\Service\FileManagement;

class FileManagementTest extends \Codeception\Test\Unit
{
    /**
     * @var \App\Tests\UnitTester
     */
    protected $tester;


    /**
     * @throws \Exception
     */
    public function testDoNotReadFileWithWrongFormat()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid file format');

        $fileManagement = new FileManagement('tests/_data/wrong_format.log');

        $fileManagement->read();
    }

    /**
     * @throws \Exception
     */
    public function testReadFile()
    {
        $fileManagement = new FileManagement('tests/_data/race.log');

        $file = $fileManagement->read();

        $this->assertIsArray($file);
    }
}