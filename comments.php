<style>
    .flex-center {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    #comments .card .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff;
        border-bottom: none;
    }
    #comments .card {
        border-radius: 5px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        background: rgba(0, 0, 0, 0.002);
        margin-bottom: 10px;
    }
    #comments .card .card-text {
        padding: 10px;
    }
    .chip {
        display: inline-block;
        border-radius: 16px;
        font-size: 13px;
        background-color: #eceff1;
        color: rgba(0, 0, 0, 0.7);
        height: initial;
        min-height: 25px;
        line-height: 25px;
        margin-bottom: 0rem;
        margin-right: .5rem;
        padding: 0px 10px;
        box-shadow: 0 1px 1px rgba(128, 128, 128, 0.18);
        font-weight: 600;
    }
    #comments .children {
        margin-right: 20px;
    }
    #comments .children .media .card-block {
        background: rgba(0, 0, 0, 0.02);
        padding: .75rem;
    }
    #comments .media p {
        margin-bottom: .1rem;
    }
</style>

<?php

if (post_password_required())
    return;

if (have_comments()) {
    ?>
    <hr>
    <div id="comments">
        <h2>Kommentare</h2>
        <ol class="medias px-sm-0 mx-sm-0">
            <?php
            require_once('class-wp-bootstrap-comment-walker.php');

            wp_list_comments( array(
                'style'         => 'ol',
                'max_depth'     => 4,
                'short_ping'    => true,
                'avatar_size'   => '50',
                'walker'        => new Bootstrap_Comment_Walker(),
            ) );
            ?>
        </ol>

    </div>
    <?php
}

?><hr><?php
$fields = apply_filters('comment_form_default_fields', [
    'autor' => '<div class="form-group">
                    <label for="author">Autor</label> ' . ( $req ? '<span>*</span>' : '' ) .
                    '<input id="author" name="author" class="form-control" type="text" value="" size="30"' . $aria_req . ' />'.
                    '<p id="d1" class="text-danger"></p>
                </div>',
    'email'	=> '<div class="form-group">
                    <label for="email">Mail</label> ' . ( $req ? '<span>*</span>' : '' ) .
                    '<input id="email" name="email" class="form-control" type="text" value="" size="30"' . $aria_req . ' />'.
                    '<p id="d2" class="text-danger"></p>
                </div>',
    'url'		=> '',
]);
$comment_args = [
    'fields' => $fields,
    'comment_field'	=> '<div class="form-group"><label for="comment">Kommentar</label><span>*</span>' .
        '<textarea id="comment" class="form-control" name="comment" rows="3" aria-required="true"></textarea><p id="d3" class="text-danger"></p>
                        </div>',
    'comment_notes_after' 	=> ' ',
    'class_submit' => 'btn btn-primary',
];

comment_form($comment_args);
