<?php

use Castlegate\ExternalLinkChecker\Download;

if (!isset($posts) || !is_array($posts)) {
    $posts = [];
}

$post_types = get_post_types();

foreach ($post_types as $key => $name) {
    $post_types[$key] = get_post_type_object($name);
}

?>

<div class="wrap">
    <h1>External Links</h1>

    <?php

    if ($posts) {
        ?>

        <table class="wp-list-table fixed striped widefat" style="margin: 1em 0;">
            <colgroup>
                <col style="width: 4em;">
                <col style="width: 25%;">
                <col style="width: auto;">
                <col style="width: 8em;">
                <col style="width: 6em;">
                <col style="width: 6em;">
            </colgroup>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Links</th>
                    <th>Post type</th>
                    <th>View</th>
                    <th>Edit</th>
                </tr>
            </thead>

            <tbody>
                <?php

                foreach ($posts as $post_id => $post) {
                    $title = $post['post_title'] ?? $post_id;
                    $type_key = $post['post_type'] ?? '';
                    $urls = (array) ($post['urls'] ?? []);

                    $links = [];

                    $view_url = get_permalink($post_id);
                    $edit_url = get_edit_post_link($post_id);

                    $type = '';
                    $view = '';
                    $edit = '';

                    foreach ($urls as $url) {
                        $links[] = '<a href="' . $url . '" title="' . $url . '">' . parse_url($url, PHP_URL_HOST) . '</a>';
                    }

                    if ($type_key) {
                        $type_object = $post_types[$type_key] ?? null;
                        $type = $type_object->labels->singular_name ?? '';

                        if ($type_object->show_ui ?? null) {
                            $type_url = add_query_arg('post_type', $type_key, admin_url('edit.php'));
                            $type = '<a href="' . $type_url . '">' . $type . '</a>';
                        }
                    }

                    if ($view_url) {
                        $title = '<a href="' . $view_url . '">' . $title . '</a>';
                        $view = '<a href="' . $view_url . '">View</a>';
                    }

                    if ($edit_url) {
                        $edit = '<a href="' . $edit_url . '">Edit</a>';
                    }

                    ?>

                    <tr>
                        <td><?= $post_id ?></td>
                        <td><?= $title ?></td>
                        <td><?= implode('<br>', $links) ?></td>
                        <td><?= $type ?></td>
                        <td><?= $view ?></td>
                        <td><?= $edit ?></td>
                    </tr>

                    <?php
                }

                ?>
            </tbody>
        </table>

        <?php
    } else {
        echo "<p><i>No external links found.</i></p>";
    }

    ?>

    <p><a href="<?= Download::url() ?>" class="button button-primary">Download as CSV</a></p>
</div>
