<?php

namespace RcmI18nTest\Entity;

require_once __DIR__ . '/../../autoload.php';

use RcmHtmlPurifier\Api\Purify;
use RcmI18n\ViewHelper\TranslateHtml;

class TranslateHtmlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \RcmI18n\ViewHelper\TranslateHtml
     */
    public function testInvoke()
    {
        $translator = $this->getMockBuilder(
            'Zend\I18n\Translator\TranslatorInterface'
        )->getMock();
        $translator->expects($this->once())
            ->method('translate')
            ->will(
                $this->returnValue(
                    'Translateidora!<br>ya!<script>alert(123)</script>'
                )
            );

        $purifier = $this->getMockBuilder(Purify::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $purifier->expects($this->once())
            ->method('__invoke')
            ->will($this->returnValue('Translateidora!<br>ya!'));

        $unit = new TranslateHtml($purifier);
        $unit->setTranslator($translator);
        $this->assertEquals(
            'Translateidora!<br>ya!',
            $unit->__invoke(
                'translate'
            )
        );
    }
} 
