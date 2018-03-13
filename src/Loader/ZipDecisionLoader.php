<?php

declare(strict_types = 1);

namespace workbenchapp\zipdecision\Loader;

use workbenchapp\zipdecision\Decision;

/**
 * Loads decisions from a zip
 */
class ZipDecisionLoader
{
    const DECISION_FILENAME = 'decision.php';

    /**
     * @var VarExportDecisionLoader
     */
    private $varExportDecisionLoader;

    public function __construct(VarExportDecisionLoader $varExportDecisionLoader = null)
    {
        $this->varExportDecisionLoader = $varExportDecisionLoader ?: new VarExportDecisionLoader;
    }

    public function loadDecision(string $zipFilename): Decision
    {
        return $this->varExportDecisionLoader->loadDecision(
            file_get_contents("zip://$zipFilename#" . self::DECISION_FILENAME)
        );
    }
}
