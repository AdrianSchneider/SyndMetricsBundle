<?php

namespace Synd\MetricsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Doctrine\Common\Persistence\ObjectRepository;

class MetricsController
{
    /**
     * @var    Symfony\Bundle\FrameworkBundle\Templating\EngineInterface
     */
    protected $templating;
    
    /**
     * @var    Doctrine\Common\Persistence\ObjectRepository
     */
    protected $repository;
    
    /**
     * Brings deps into scope
     * @param    Symfony\Bundle\FrameworkBundle\Templating\EngineInterface
     * @param    Doctrine\Common\Persistence\ObjectRepository
     */
    public function __construct(EngineInterface $templating, ObjectRepository $repository)
    {
        $this->templating = $templating;
        $this->repository = $repository;
    }
    
    /**
     * Lists all metrics on the dash
     * @param    Symfony\Component\HttpFoundation\Request
     * @return   Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return $this->templating->renderResponse('SyndMetricsBundle:Metrics:index.html.twig', array(
            'metrics' => $this->repository->findAll()
        ));
    }
    
    public function funnelAction($funnel, Request $request)
    {
        
    }
}