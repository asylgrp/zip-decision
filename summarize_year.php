<?php
/**
 * Script that is able to create summaries from a set of decision zip files
 *
 * To be removed when Toolbox contains similar functionality...
 *
 * Usage: php summarize_year.php DIR-TO-SCAN
 */

use byrokrat\amount\Amount;

// Where to look for decisions
$DIR_WITH_DECISIONS = $argv[1];

require 'vendor/autoload.php';


$formatter = new NumberFormatter('sv_SE', NumberFormatter::CURRENCY);
$SEK = function ($amount) use ($formatter) {
    return $formatter->formatCurrency($amount->getFloat(), 'sek');;
};

$loader = new workbenchapp\zipdecision\Loader\ZipDecisionLoader;

$sumRequested = new Amount('0');
$sumApproved = new Amount('0');
$count = 0;

foreach (new DirectoryIterator($DIR_WITH_DECISIONS) as $fileInfo) {
    if (!$fileInfo->isFile()) {
        continue;
    }

    $decision = $loader->loadDecision($fileInfo->getPathname());
    $claims = $decision->getClaims();

    $sumRequested = $sumRequested->add($claims->sumRequestedAmounts());
    $sumApproved = $sumApproved->add($claims->sumApprovedAmounts());
    $count += count($claims);

    printf(
        "%s: (%s st) %s ansökt, %s beviljat\n",
        $decision->getCreated()->format('Y-m-d'),
        count($claims),
        $SEK($claims->sumRequestedAmounts()),
        $SEK($claims->sumApprovedAmounts())
    );
}

echo "\n";
echo "Antal ansökningar: $count\n";
echo "Sammanlagt ansökt: ".$SEK($sumRequested)."\n";
echo "Sammanlagt beviljat: ".$SEK($sumApproved)."\n";
echo "Procent beviljat: ", $sumApproved->divideBy($sumRequested)->multiplyWith('100')->getString(0), '%', PHP_EOL;
echo "Snitt ansökan: ", $SEK($sumRequested->divideBy($count)), PHP_EOL;
echo "Snitt beviljat per ansökan: ", $SEK($sumApproved->divideBy($count)), PHP_EOL;
