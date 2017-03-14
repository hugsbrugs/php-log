<?php

# For PHP7
// declare(strict_types=1);

// namespace Hug\Tests\Log;

use PHPUnit\Framework\TestCase;

use org\bovigo\vfs\vfsStream,
    org\bovigo\vfs\vfsStreamDirectory;

use Hug\Log\Log as Log;

/**
 *
 */
final class LogTest extends TestCase
{
    /**
     * @var  vfsStreamDirectory
     */
    private $root;

    public $valid_log_level_codes;
    public $invalid_log_level_codes;

    /**
     *
     */
    function __construct()
    {
        $this->valid_log_level_codes = [1, 2, 4, 8, 16, 32, 64, 128, 256, 512, 1024, 2048, 4096, 8192, 16384, 32767];
        $this->invalid_log_level_codes = [7, 14];
    }

    /**
     * set up test environmemt
     */
    public function setUp()
    {
        # Create Virtual File System
        $this->root = vfsStream::setup('exampleDir', 0755);

        # Create Virtual Filesystem Structure
        // $structure = array(
        //     'Core' => array(
        //         'AbstractFactory' => array(
        //             'test.php' => 'some text content',
        //             'other.php' => 'Some more text content',
        //             'Invalid.csv' => 'Something else',
        //         ),
        //     'AnEmptyFolder' => array(),
        //     'badlocation.php' => 'some bad content',
        // ));
        // $this->root = vfsStream::setup('exampleDir', 0755, $structure);

        # Copy Real File Structure
        # https://github.com/mikey179/vfsStream/wiki/CopyFromFileSystem
        // vfsStream::copyFromFileSystem($path, $baseDir, $maxFileSize)
    }

    /* ************************************************* */
    /* ***************** Log::write_log **************** */
    /* ************************************************* */

    /**
     *
     */
    public function testCanWriteLogWithValidLogFile()
    {
        $message = 'Hello world ! ';
        $logfile = vfsStream::url('exampleDir/test.log');
        $result = Log::write_log($message, $logfile);
        $this->assertInternalType('array', $result);

        $file_content = file_get_contents($logfile);
        $this->assertContains($message, $file_content);        
    }

    /**
     *
     */
    public function testCannotWriteLogWithInvalidLogFile()
    {
        $message = 'Hello world ! ';
        $logfile = vfsStream::url('fakeExampleDir/test.log');
        $result = Log::write_log($message, $logfile);
        $this->assertInternalType('array', $result);

        // $file_content = file_get_contents($logfile);
        // $this->assertNotContains($message, $file_content);        

    }

    /* ************************************************* */
    /* ************* Log::decode_log_level ************* */
    /* ************************************************* */

    /**
     *
     */
    public function testCanDecodeLogLevelWithValidCode()
    {
        foreach ($this->valid_log_level_codes as $key => $log_level_code)
        {
            $log_message = Log::decode_log_level($log_level_code);
            $this->assertInternalType('string', $log_message);
        }
    }
    
    /**
     *
     */
    public function testCannotDecodeLogLevelWithValidCode()
    {
        foreach ($this->invalid_log_level_codes as $key => $log_level_code)
        {
            $log_message = Log::decode_log_level($log_level_code);
            $this->assertNull($log_message);
        }
    }


}

