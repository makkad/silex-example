<?php
namespace Acme\MobileNotification\Tests;

use Acme\MobileNotification\Template;

class TemplateTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->twig = $this->getMockBuilder('Twig_Environment')
            ->disableOriginalConstructor()
            ->getMock();

        $this->template = new Template($this->twig);
    }

    public function testLoad()
    {
        $template = $this->getMockBuilder('Acme\MobileNotification\Tests\Twig_TemplateTest')
            ->disableOriginalConstructor()
            ->getMock();

        $this->twig->expects($this->once())
            ->method('loadTemplate')
            ->with('fooType/fooTemplate.html.twig')
            ->will($this->returnValue($template));

        $returnedTemplate = $this->template->load('fooTemplate', 'fooType');

        $this->assertEquals($template, $returnedTemplate);
    }

    /**
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testLoadNotFound()
    {
        $this->twig->expects($this->once())
            ->method('loadTemplate')
            ->with('fooType/fooTemplate.html.twig')
            ->will($this->throwException(new \Twig_Error_Loader('foo')));

        $this->template->load('fooTemplate', 'fooType');
    }
}

class Twig_TemplateTest extends \Twig_Template
{
    protected $useExtGetAttribute = false;

    public function __construct(\Twig_Environment $env, $useExtGetAttribute = false)
    {
    }

    public function getZero()
    {
    }

    public function getEmpty()
    {
    }

    public function getString()
    {
    }

    public function getTrue()
    {
    }

    public function getTemplateName()
    {
    }

    public function getDebugInfo()
    {
    }

    protected function doGetParent(array $context)
    {
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
    }

    public function getAttribute($object, $item, array $arguments = array(), $type = \Twig_TemplateInterface::ANY_CALL, $isDefinedTest = false, $ignoreStrictCheck = false)
    {
    }
}