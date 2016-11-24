<?php

use PHPUnit_Framework_TestCase as TestCase;

class StorageTest extends TestCase
{

    function testFileStorage()
    {
        $storage = new \SkypeBot\Storage\FileStorage(sys_get_temp_dir());
        $storage->set('a', 'b');
        $this->assertEquals($storage->get('a'), 'b');
        $storage->remove('a');
        $this->assertNull($storage->get('a'));
    }

    function testSimpleLogger()
    {
        $logger = new \SkypeBot\Storage\SimpleApiLogger();
        $logger->log('a');
        $this->expectOutputString("a\n");
    }
}