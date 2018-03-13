<?php

declare(strict_types = 1);

namespace workbenchapp\zipdecision\Loader;

use workbenchapp\zipdecision\Decision;

// phpcs:disable
require_once __DIR__ . '/__set_state.php';
// phpcs:enable

/**
 * Loads decisions dumped with var_export
 *
 * Requires some hacks with __set_state and str_replace...
 */
class VarExportDecisionLoader
{
    public function loadDecision(string $content): Decision
    {
        $content = str_replace(
            'byrokrat',
            'workbenchapp\zipdecision\byrokrat',
            $content
        );

        $tmpfname = tempnam(sys_get_temp_dir(), 'workbenchapp_zip_decision_loader');
        file_put_contents($tmpfname, $content);

        $decision = require $tmpfname;

        unlink($tmpfname);

        return $decision;
    }
}
