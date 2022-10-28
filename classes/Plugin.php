<?php

declare(strict_types=1);

namespace Castlegate\ExternalLinkChecker;

class Plugin
{
    /**
     * Initialization
     *
     * @return void
     */
    public static function init(): void
    {
        SubMenuPage::init();
        Download::init();
    }
}
