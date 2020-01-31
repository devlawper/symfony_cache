<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param Stopwatch $stopwatch
     * @param CacheInterface $cache
     * @return Response
     *
     * StopWatch permet de timer et d'afficher les actions dans le profiler
     * On crée une instance de CacheInterface pour gérer le cache
     */
    public function index(Stopwatch $stopwatch, CacheInterface $cache)
    {
        $stopwatch->start('calcul-long');

        // On imagine un calcul ou un traitement long
        // $resultatCalcul = $this->fonctionQuiPrendDuTemps();

        // Avec get() si la clé déclarée n'existe pas dans le cache, on la crée
        $resultatCaclul = $cache->get('resulat-calcul-long', function (ItemInterface $item) {
            // $item représente la boite qui contient ce cache, permet par exemple de définir un temps d'expiration
            $item->expiresAfter(10);

            return $this->fonctionQuiPrendDuTemps();
        });

        $stopwatch->stop('calcul-long');

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    private function fonctionQuiPrendDuTemps(): int
    {
        sleep(2);

        return 10;
    }
}
