<?php

namespace App\Http\Middleware;

use Closure;
use Doctrine\ORM\EntityManagerInterface;

class FlushEntityManagerMiddleware
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Create a new filter instance.
     *
     * @param  EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $this->entityManager->flush();

        return $response;
    }
}