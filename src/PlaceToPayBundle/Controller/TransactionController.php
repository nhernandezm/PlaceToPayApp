<?php

namespace PlaceToPayBundle\Controller;

use PlaceToPay\PlaceToPay;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use PlaceToPayBundle\Entity\Transaction;


class TransactionController extends Controller
{
	public function createAction(Request $request)
	{
		$content = $request->getContent();
		$dataTansaction = json_decode($content, true);
		$documentPayer = "";
		$documentBuyer = "";
		$payerData = $dataTansaction["payer"];
		$buyerData = $dataTansaction["buyer"];
		$value = $dataTansaction["value"];
		$reference = $dataTansaction["reference"];
		$typePerson = $dataTansaction["typePerson"];
		$ipAddressClient = $dataTansaction["ipAddressClient"];
		$userAgent = $dataTansaction["userAgent"];
		$bankCode = $dataTansaction["bank"];

		$login = $this->getParameter('loginplacetopay');
		$tranKey = $this->getParameter('transactionkeyplacetopay');
		$ipServer = $this->getParameter('host_server');
		$port = $this->getParameter('host_port');

		$listBanks = array();
	    $placetopay = new PlaceToPay($login,$tranKey);

	    $payer = $placetopay->newPerson();
	    $buyer = $placetopay->newPerson();

		$PSETR = $placetopay->newPSETR();	
		$documentPayer = $payerData["document"];
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
			$documentPayer = $payerData["document"];
			$documentBuyer = $payerData["document"];
		}else{
			$documentBuyer = $buyerData["document"];
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

		$PSETR->setBankCode($bankCode);
		$PSETR->setBankInterface($typePerson);
		$PSETR->setReturnURL("http://".$ipServer.":".$port."/PlaceToPayApp/web/PSE/responseTransaction.html");
		$PSETR->setReference($reference);
		$PSETR->setDescription("Pago test");
		$PSETR->setTotalAmount($value);
		$PSETR->setTaxAmount(100);
		$PSETR->setDevolutionBase(16);
		$PSETR->setTipAmount(30);
		$PSETR->setIpAddress($ipAddressClient);
		$PSETR->setUserAgent($userAgent);

	    $transaction  = $placetopay->getTransaction()->createTransaction($PSETR);
	    $transaction = $this->saveTransaction($transaction["createTransactionResult"],$documentPayer,$documentBuyer);
	    return new JsonResponse($transaction);
	}

	private function saveTransaction($transactionResponse,$documentPayer,$documentBuyer){
		$transaction = new Transaction();
        $transaction->setBankCurrency($transactionResponse["bankCurrency"]);
        $transaction->setBankFactor($transactionResponse["bankFactor"]);
        $transaction->setBankURL($transactionResponse["bankURL"]);
        $transaction->setResponseCode($transactionResponse["responseCode"]);
        $transaction->setResponseReasonCode($transactionResponse["responseReasonCode"]);
        $transaction->setResponseReasonText($transactionResponse["responseReasonText"]);
        $transaction->setReturnCode($transactionResponse["returnCode"]);
        $transaction->setSessionID($transactionResponse["sessionID"]);
        $transaction->setTransactionCycle($transactionResponse["transactionCycle"]);
        $transaction->setTransactionID($transactionResponse["transactionID"]);
        $transaction->setTrazabilityCode($transactionResponse["trazabilityCode"]);
        $transaction->setDocumetBuyer($documentBuyer);
        $transaction->setDocumetPayer($documentPayer);

        $em = $this->getDoctrine()->getManager();
	    $em->persist($transaction);
	    $em->flush();
	    $transactionResponse["id"] = $transaction->getId();

	    return $transactionResponse;

	}

	public function getTransactionInformationAction($transactionID)
	{
		$login = $this->getParameter('loginplacetopay');
		$tranKey = $this->getParameter('transactionkeyplacetopay');
	    $placetopay = new PlaceToPay($login,$tranKey);
		$transaction  = $placetopay->getTransaction();	
		$transactionInfo  = $transaction->getTransactionInformation($transactionID);	
	    return new JsonResponse($transactionInfo);
	}
}