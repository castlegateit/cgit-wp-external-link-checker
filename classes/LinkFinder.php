<?php

declare(strict_types=1);

namespace Castlegate\ExternalLinkChecker;

class LinkFinder
{
    /**
     * Return a list of all the external links on the site grouped by post
     *
     * This method searches for external URLs in post content, post excerpts,
     * and post meta for all published posts of all post types.
     *
     * @return array
     */
    public static function getPostLinksByPost(): array
    {
        $items = static::getPostItems();
        $posts = [];

        foreach ($items as $item) {
            if (!$item->content) {
                continue;
            }

            $urls = static::getExternalLinks($item->content);

            if (!$urls) {
                continue;
            }

            $posts[$item->post_id] = [
                'post_title' => $item->post_title,
                'post_type' => $item->post_type,
                'urls' => $urls,
            ];
        }

        return $posts;
    }

    /**
     * Return a list of all the external links on the site
     *
     * @return array
     */
    public static function getPostLinks(): array
    {
        $posts = static::getPostLinksByPost();
        $links = [];

        foreach ($posts as $post_id => $post) {
            foreach ($post['urls'] as $url) {
                $links[] = [
                    'post_id' => $post_id,
                    'post_title' => $post['post_title'],
                    'post_type' => $post['post_type'],
                    'url' => $url,
                ];
            }
        }

        return $links;
    }

    /**
     * Return combined content for all posts on the site
     *
     * @return array
     */
    private static function getPostItems(): array
    {
        global $wpdb;

        $items = $wpdb->get_results("SELECT
                p.ID AS post_id,
                p.post_title,
                p.post_type,
                CONCAT(p.post_content, p.post_excerpt, GROUP_CONCAT(m.meta_value)) AS content
            FROM `{$wpdb->posts}` AS p
            LEFT JOIN `{$wpdb->postmeta}` AS m ON p.ID = m.post_id
            WHERE p.post_status = 'publish'
            GROUP BY p.ID
            ORDER BY ID ASC");

        if ($items) {
            return $items;
        }

        return [];
    }

    /**
     * Return all external URLs in a string
     *
     * @param string $content
     * @return array|null
     */
    private static function getExternalLinks(string $content): ?array
    {
        // https://stackoverflow.com/questions/6038061
        preg_match_all('/(?:https?:)?\/\/(?:[\w_-]+(?:(?:\.[\w_-]+)+))(?:[\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-])?/iu', $content, $matches);

        $urls = $matches[0] ?? null;

        if (!$urls) {
            return null;
        }

        $urls = array_filter($urls, static::class . '::isExternalUrl');

        if (!$urls) {
            return null;
        }

        return $urls;
    }

    /**
     * Check whether string is an external URL
     *
     * @param string $url
     * @return bool
     */
    private static function isExternalUrl(string $url): bool
    {
        $current_host = parse_url(get_bloginfo('url'), PHP_URL_HOST);
        $host = parse_url($url, PHP_URL_HOST);

        return $current_host !== $host;
    }
}
