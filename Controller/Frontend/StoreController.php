<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 05/10/16
 * Time: 08:16
 */

namespace Miky\Bundle\UserBundle\Controller\Frontend;


use Miky\Bundle\AdBundle\Entity\AdCategory;
use Miky\Bundle\AdBundle\Form\Type\Search\AdSearchType;
use Miky\Bundle\AdBundle\Model\AdSearch;
use Miky\Bundle\UserBundle\Entity\Customer;
use Miky\Bundle\UserBundle\Entity\Store;
use Miky\Bundle\UserBundle\Form\Type\Frontend\StoreType;
use Miky\Component\Resource\Repository\Exception\ExistingResourceException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StoreController extends Controller
{
    public function showAction(Request $request, Customer $user)
    {

        if (!$user->getCertified()){
            return $this->redirectToRoute("miky_app_home_index");
        }
        $paginator = $this->get('knp_paginator');
        $adSearch = new AdSearch();
        $adSearch->setUser($user);
        $adSearch->handleRequest($request);

        $form = $this->get('form.factory')
            ->createNamedBuilder('form_name', AdSearchType::class, $adSearch, array(
                "method" => "GET"
            ))
            ->getForm();

        $form->handleRequest($request);

        $adSearch = $form->getData();

        $repositoryManager = $this->container->get('fos_elastica.manager');

        /** var FOS\ElasticaBundle\Repository */
        $repository = $repositoryManager->getRepository('MikyAdBundle:Ad');
        if ($request->get("category") != null){
            $em = $this->get("doctrine.orm.entity_manager");
            $category = $em->getRepository(AdCategory::class)->find($request->get("category"));
            $adSearch->setCategory($category);
        }
        $query = $repository->search($adSearch);


        $finder = $this->get('fos_elastica.finder.ad.ad');

        $paginator = $this->get('knp_paginator');
        $pagination =  $paginator->paginate(
            $finder->createPaginatorAdapter($query),
            $this->get('request')->get('page', 1),
            10
        );
        return $this->render('MikyUserBundle:Frontend/Store:show.html.twig', array(
            'customer' => $user,
            'pagination' => $pagination,
            'form' => $form->createView()
        ));
    }

    public function listAction(Request $request)
    {
        $em = $this->get("doctrine.orm.entity_manager");
//        $customers = $em->getRepository(Customer::class)->findBy(array("certified" => true));
        $hasAd = $request->get('hasAd', false);

        if ($hasAd){
            $query = $em->getRepository(Customer::class)->createQueryBuilder('c')
                ->leftJoin('c.ads', 'ads')
                ->where('SIZE(c.ads) > 0')
                ->andWhere('c.certified = :cert')
                ->setParameter('cert', true)
                ->getQuery();
        }else{
            $query = $em->getRepository(Customer::class)->createQueryBuilder('c')
                ->where('c.certified = :cert')
                ->setParameter('cert', true)
                ->getQuery();
        }

        $customers= $query->getResult();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $customers,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('MikyUserBundle:Frontend/Store:list.html.twig', array(
            'pagination' => $pagination,
        ));

    }

}