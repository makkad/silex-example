<?php
namespace Acme\MobileNotification;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig_Environment;
use Twig_Error_Loader;

class Template
{
    protected $twig;

    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function load($type, $slug)
    {
        try {
            return $this->twig->loadTemplate(sprintf('%s/%s.html.twig', $slug, $type));
        } catch (Twig_Error_Loader $e) {
            throw new NotFoundHttpException(sprintf('Template with type %s and slug %s not found.', $type, $slug), $e);
        }
    }
}
