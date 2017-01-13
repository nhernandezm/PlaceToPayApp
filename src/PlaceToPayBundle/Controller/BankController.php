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
	    $placetopay = new PlaceToPay("6dd490faf9cb87a9862245da41170ff2","024h1IlD");
	    $listBanks  = $placetopay->getBankList();

	    return new JsonResponse($listBanks);
	}
}