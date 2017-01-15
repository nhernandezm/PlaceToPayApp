<?php

namespace PlaceToPayBundle\Controller;

use PlaceToPay\PlaceToPay;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class TransactionController extends Controller
{
	public function createAction()
	{
		$listBanks = array();
	    $placetopay = new PlaceToPay("6dd490faf9cb87a9862245da41170ff2","024h1IlD");

	    $payer = $placetopay->newPerson();
		$PSETR = $placetopay->newPSETR();	    

	    $payer->setDocument("1104010447");
		$payer->setDocumentType("CC");
		$payer->setFirstName("Nafer");
		$payer->setLastName("Hernandez");
		$payer->setCompany("PlaceToPay");
		$payer->setEmailAddress("naferh@hotmail.com");
		$payer->setAddress("Barrio 13 de junio UR India MG L4");
		$payer->setCity("Cartagena");
		$payer->setProvince("Bolivar");
		$payer->setCountry("Colombia");
		$payer->setPhone("6908765");
		$payer->setMobile("3215678099");


		$PSETR->setPayer($payer);
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