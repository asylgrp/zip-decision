<?php
/**
 * Script that is able to find unique contacts in a set of decision zip files
 *
 * Temporary script to find all contacts active in a year or simliar. To be
 * removed when Toolbox contains similar functionality...
 *
 * Usage: php find_contacts.php DIR-TO-SCAN
 */

//<!-- SETUP

// Where to look for decisions
$DIR_WITH_DECISIONS = $argv[1];

// How to present each unique contact
$FORMATTER = function ($contact) {
    echo $contact->getName() . "\n";
};

//-->

require 'vendor/autoload.php';

$contacts = [];
$loader = new workbenchapp\zipdecision\Loader\ZipDecisionLoader;

foreach (new DirectoryIterator($DIR_WITH_DECISIONS) as $fileInfo) {
    if (!$fileInfo->isFile()) {
        continue;
    }

    $decision = $loader->loadDecision($fileInfo->getPathname());

    foreach ($decision->getClaims() as $claim) {
        $contact = $claim->getContact();
        $contacts[$contact->getName()] = $contact;
    }
}

foreach ($contacts as $contact) {
    $FORMATTER($contact);
}
