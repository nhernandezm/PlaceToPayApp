<?php

namespace PlaceToPayBundle\Controller;

use PlaceToPay\PlaceToPay;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class TransactionController extends Controller
{
	public function createAction(Request $request)
	{

		$content = $request->getContent();
		$dataTansaction = json_decode($content, true);

		$payerData = $dataTansaction["payer"];
		$buyerData = $dataTansaction["buyer"];

		$listBanks = array();
	    $placetopay = new PlaceToPay("6dd490faf9cb87a9862245da41170ff2","024h1IlD");

	    $payer = $placetopay->newPerson();
	    $buyer = $placetopay->newPerson();

		$PSETR = $placetopay->newPSETR();	

		$payer->setDocument($payerData["document"]);
		$payer->setDocumentType($payerData["documentType"]);
		$payer->setFirstName($payerData["firstName"]);
		$payer->setLastName($payerData["lastName"]);
		$payer->setCompany($payerData["company"]);
		$payer->setEmailAddress($payerData["emailAddress"]);
		$payer->setAddress($payerData["address"]);
		$payer->setCity($payerData["city"]);
		$payer->setProvince($payerData["province"]);
		$payer->setCountry($payerData["country"]);
		$payer->setPhone($payerData["phone"]);
		$payer->setMobile($payerData["mobile"]);

		if($payerData["document"] == $buyerData["document"] ){ 
			$PSETR->setPayer($payer);
		}else{
			$buyer->setDocument($buyerData["document"]);
			$buyer->setDocumentType($buyerData["documentType"]);
			$buyer->setFirstName($buyerData["firstName"]);
			$buyer->setLastName($buyerData["lastName"]);
			$buyer->setCompany($buyerData["company"]);
			$buyer->setEmailAddress($buyerData["emailAddress"]);
			$buyer->setAddress($buyerData["address"]);
			$buyer->setCity($buyerData["city"]);
			$buyer->setProvince($buyerData["province"]);
			$buyer->setCountry($buyerData["country"]);
			$buyer->setPhone($buyerData["phone"]);
			$buyer->setMobile($buyerData["mobile"]);
			$PSETR->setPayer($buyer);
		}

		$PSETR->setBankCode("1040");
		$PSETR->setBankInterface(0);
		$PSETR->setReturnURL("http://186.116.70.45:8080/PlaceToPayApp/web/");
		$PSETR->setReference("1104010448");
		$PSETR->setDescription("Pago test");
		$PSETR->setTotalAmount(3000);
		$PSETR->setTaxAmount(100);
		$PSETR->setDevolutionBase(16);
		$PSETR->setTipAmount(30);
		$PSETR->setIpAddress("186.116.70.45");
		//print_r($_SERVER['REMOTE_ADDR']);
	    $transaction  = $placetopay->getTransaction()->createTransaction($PSETR);
	    //https://200.1.124.236/PSEUserRegister/StartTransaction.htm?enc=tnPcJHMKlSnmRpHM8fAbu4E%2b7fr9oAembqT18Wy8nFqRlWUdUHxaCWZSMulp6lJ0
	    return new JsonResponse($transaction);
	}
}