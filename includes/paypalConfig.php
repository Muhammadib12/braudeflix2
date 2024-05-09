<?php
require_once("PayPal-PHP-SDK/autoload.php");

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'Af5wUReZNdtHBGZ6l5tspelLeJm29v7bshWMOEdCHz1PzHFxJ-qBLGSI1ksRSwbt4N-rsSNUxkY-fjsq',     // ClientID
        'EI6y95plgWA3uoCYTRLy-o6H2o8QaAg_k_-R3Mx0eIo05deGgUnnDedpKWPPv7I3KRowCV-j1_OACHun'      // ClientSecret
    )
);
