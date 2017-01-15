<?php

namespace PlaceToPayBundle\Controller;

use PlaceToPay\PlaceToPay;
use PlaceToPayBundle\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class PersonController extends Controller
{
	public function createAction(Request $request)
	{

		$content = $request->getContent();
		$contentPerson = json_decode($content, true);


		$documentType = $contentPerson["documentType"];
		$document = $contentPerson["document"];
		$firstName = $contentPerson["firstName"];
		$lastName = $contentPerson["lastName"];
		$emailAddress = $contentPerson["emailAddress"];
		$address = $contentPerson["address"];
		$mobile = $contentPerson["mobile"];
		$phone = $contentPerson["phone"];
		$company = $contentPerson["company"];
		$city = $contentPerson["city"];
		$province = $contentPerson["province"];
		$country = $contentPerson["country"];

	   	$person = new Person();
	   	$person->setDocumentType($documentType);
		$person->setDocument($document);
		$person->setFirstName($firstName);
		$person->setLastName($lastName);
		$person->setEmailAddress($emailAddress);
		$person->setAddress($address);
		$person->setMobile($mobile);
		$person->setPhone($phone);
		$person->setCompany($company);
		$person->setCity($city);
		$person->setProvince($province);
		$person->setCountry($country);
		$person->setTypePerson("CLIENTE");

	    $em = $this->getDoctrine()->getManager();
	    $em->persist($person);
	    $em->flush();
	    $contentPerson["id"] = $person->getId();

	    return new JsonResponse($contentPerson);
	    //return new Response('Created product id mmm');
	}
}