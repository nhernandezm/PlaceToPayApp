<?php

namespace PlaceToPayBundle\Controller;

use PlaceToPay\PlaceToPay;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class BankController extends Controller
{
	public function listAction()
	{
		$listBanks = array();
	   	$login = $this->getParameter('loginplacetopay');
		$tranKey = $this->getParameter('transactionkeyplacetopay');
	    $placetopay = new PlaceToPay($login,$tranKey);
	    $listBanks  = $placetopay->getBank()->getBankList();

	    return new JsonResponse($listBanks);
	}
}