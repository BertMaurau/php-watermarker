<?php

use PHPUnit\Framework\TestCase;

/**
 *  WatermarkTest
 *
 *  @author Bert Maurau
 */
class WatermarkTest extends TestCase
{

    /**
     * Just check if the Watermark has no syntax error
     */
    public function testIsThereAnySyntaxError()
    {
        $var = new BertMaurau\Watermarker\Watermark;
        $this -> assertTrue(is_object($var));
        unset($var);
    }

}
