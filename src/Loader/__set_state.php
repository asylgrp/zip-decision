<?php
/**
 * __set_state() implementations needed to load legacy decision dumps
 *
 * Dumped classes in the byrokrat namespace needs to be moved to
 * workbenchapp\zipdecision\byrokrat prior to unpack!
 */

namespace asylgrp\workbench\Domain {
    class Decision extends \workbenchapp\zipdecision\Decision {
        public static function __set_state(array $values)
        {
            return new self(
                $values['date'],
                $values['hash'],
                $values['claims'],
                $values['fundsPre'],
                $values['fundsPost'],
                $values['ratio'],
                $values['guarantee']
            );
        }
    }

    class ClaimArray extends \workbenchapp\zipdecision\ClaimArray {
        public static function __set_state(array $values)
        {
            return new self(...$values['claims']);
        }
    }

    class Claim extends \workbenchapp\zipdecision\Claim {
        public static function __set_state(array $values)
        {
            $claim = new self(
                $values['contact'],
                $values['requested'],
                $values['account'],
                $values['comment'],
                $values['hash'],
                $values['created'],
                $values['updated']
            );

            $claim->setApprovedAmount($values['approved']);

            return $claim;
        }
    }

    class Contact extends \workbenchapp\zipdecision\Contact {
        public static function __set_state(array $values)
        {
            return new self(
                $values['name'],
                $values['account'],
                $values['mail'],
                $values['phone'],
                $values['isPayoutAllowed'],
                $values['comment'],
                $values['hash'],
                $values['created'],
                $values['updated']
            );
        }
    }

    class AccountWrapper extends \workbenchapp\zipdecision\AccountWrapper {
        public static function __set_state(array $values)
        {
            return new self(
                $values['account'],
                $values['comment'],
                $values['updated']
            );
        }
    }

    class DataWrapper extends \workbenchapp\zipdecision\DataWrapper {
        public static function __set_state(array $values)
        {
            return new self(
                $values['value'],
                $values['comment'],
                $values['updated']
            );
        }
    }
}

namespace workbenchapp\zipdecision\byrokrat\banking {
    class BaseAccount extends \byrokrat\banking\BaseAccount {
        public static function __set_state(array $values)
        {
            return new \byrokrat\banking\BaseAccount(
                $values['bankName'],
                $values['raw'],
                $values['clearing'],
                $values['clearingCheckDigit'],
                $values['serial'],
                $values['checkDigit']
            );
        }
    }

    class NordeaPersonal extends \byrokrat\banking\NordeaPersonal {
        public static function __set_state(array $values)
        {
            return new \byrokrat\banking\NordeaPersonal(
                $values['bankName'],
                $values['raw'],
                $values['clearing'],
                $values['clearingCheckDigit'],
                $values['serial'],
                $values['checkDigit']
            );
        }
    }

    class PlusGiro extends \byrokrat\banking\PlusGiro {
        public static function __set_state(array $values)
        {
            return new \byrokrat\banking\PlusGiro(
                $values['bankName'],
                $values['raw'],
                $values['clearing'],
                $values['clearingCheckDigit'],
                $values['serial'],
                $values['checkDigit']
            );
        }
    }
}

namespace workbenchapp\zipdecision\byrokrat\amount\Currency {
    class SEK extends \byrokrat\amount\Currency\SEK {
        public static function __set_state(array $values)
        {
            return new \byrokrat\amount\Currency\SEK($values['amount']);
        }
    }
}
