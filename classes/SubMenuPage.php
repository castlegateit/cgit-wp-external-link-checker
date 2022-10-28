<?php

declare(strict_types=1);

namespace Castlegate\ExternalLinkChecker;

class SubMenuPage
{
    /**
     * Parent menu page slug
     *
     * @var string
     */
    private const PARENT = 'tools.php';

    /**
     * Sub-menu page title
     *
     * @var string
     */
    private const TITLE = 'External Links';

    /**
     * Sub-menu page capability
     *
     * @var string
     */
    private const CAPABILITY = 'manage_options';

    /**
     * Sub-menu page slug
     *
     * @var string
     */
    private const NAME = 'cgit-wp-external-link-checker';

    /**
     * Initialization
     *
     * @return void
     */
    public static function init(): void
    {
        $sub_menu_page = new static();

        add_action('admin_menu', [$sub_menu_page, 'register']);
    }

    /**
     * Register sub-menu page
     *
     * @return void
     */
    public function register(): void
    {
        add_submenu_page(
            static::PARENT,
            static::TITLE,
            static::TITLE,
            static::CAPABILITY,
            static::NAME,
            [$this, 'render']
        );
    }

    /**
     * Render sub-menu page
     *
     * @return void
     */
    public function render(): void
    {
        $posts = LinkFinder::getPostLinksByPost();

        include CGIT_WP_EXTERNAL_LINK_CHECKER_PLUGIN_DIR . '/views/page.php';
    }
}
