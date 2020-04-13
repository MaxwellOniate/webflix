<?php

class BillingDetails
{
  public static function insertDetails($con, $agreement, $token, $username)
  {
    $query = $con->prepare("INSERT INTO billingDetails(agreementId, nextBillingDate, token, username)
    VALUES(:agreementId, :nextBillingDate, :token, :username)");

    $agreementDetails = $agreement->getAgreementDetails();

    return $query->execute([
      ":agreementId" => $agreement->getId(),
      ":nextBillingDate" => $agreementDetails->getNextBillingDate(),
      ":token" => $token,
      ":username" => $username
    ]);
  }
}
