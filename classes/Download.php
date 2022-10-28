<?php

declare(strict_types=1);

namespace Castlegate\ExternalLinkChecker;

class Download
{
    /**
     * Download request key
     *
     * @var string
     */
    public const REQUEST_KEY = 'cgit_wp_elc_download';

    /**
     * Initialization
     *
     * @return void
     */
    public static function init(): void
    {
        add_action('init', static::class . '::maybeDownload');
    }

    /**
     * Send download if requested
     *
     * @return void
     */
    public static function maybeDownload(): void
    {
        $request = $_GET[static::REQUEST_KEY] ?? null;

        if (!current_user_can('manage_options') || !$request) {
            return;
        }

        static::download();
    }

    /**
     * Send download
     *
     * @return void
     */
    protected static function download(): void
    {
        $items = LinkFinder::getPostLinks();
        $url = parse_url(get_bloginfo('url'), PHP_URL_HOST);
        $url = preg_replace('/[^[:alnum:]]+/', '-', strtolower($url));
        $date = date('Y-m-d');
        $name = "$url-external-links-$date.csv";

        header('Content-Type: text/csv');
        header("Content-Disposition: attachment; filename=$name");

        $file = fopen('php://output', 'a');

        $columns = [
            'post_id' => 'Post ID',
            'post_title' => 'Post title',
            'post_type' => 'Post type',
            'post_url' => 'Post URL',
            'url' => 'Link URL',
        ];

        $default = array_combine(array_keys($columns), array_fill(0, count($columns), null));

        fputcsv($file, $columns);

        foreach ($items as $item) {
            $item['post_url'] = get_permalink($item['post_id']);
            $item = array_merge($default, $item);

            fputcsv($file, $item);
        }

        fclose($file);

        exit;
    }

    /**
     * Return download URL
     *
     * @return string
     */
    public static function url(): string
    {
        return add_query_arg(static::REQUEST_KEY, 1, home_url('/'));
    }
}
