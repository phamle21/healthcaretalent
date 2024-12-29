<?php
    defined( 'ABSPATH' ) || exit;

    $title = '';
    if (!empty($args['title'])) :
        $title = $args['title'];
    endif;
    $messages = $args['messages'];
?>

<div id="tried-header" class="tried-layout__header">
    <div class="tried-layout__header-wrapper">
        <h1 class="tried-layout__header-heading"><?php echo $title; ?></h1>
        <div>
            <aside id="tried-activity-panel" class="tried-layout__activity-panel">
                <div class="tried-layout__tabs">
                    <button type="button" id="activity-panel-tab-inbox" class="components-button tried-layout__activity-panel-tab">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" role="img" aria-hidden="true" focusable="false">
                            <path fill-rule="evenodd" d="M6 5.5h12a.5.5 0 01.5.5v7H14a2 2 0 11-4 0H5.5V6a.5.5 0 01.5-.5zm-.5 9V18a.5.5 0 00.5.5h12a.5.5 0 00.5-.5v-3.5h-3.337a3.5 3.5 0 01-6.326 0H5.5zM4 13V6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2v-5z" clip-rule="evenodd"></path>
                        </svg><?php _e( 'Thư báo', 'tried' ); ?>
                    </button>
                </div>
                <div class="tried-layout__activity-panel-wrapper">
                    <div class="tried-wrapper">
                        <div role="menu">
                            <?php
                                if (!empty($messages)) :
                                    foreach ($messages as $message) :
                            ?>
                                        <section class="tried-inbox-message plain">
                                            <div class="tried-inbox-message__wrapper">
                                                <div class="tried-inbox-message__content">
                                                    <span class="tried-inbox-message__date"><?php echo $message['content']['date']; ?></span>
                                                    <h4 class="tried-inbox-message__title"><?php echo $message['content']['title']; ?></h4>
                                                    <div class="tried-inbox-message__text">
                                                        <span><?php echo $message['content']['text']; ?></span>
                                                    </div>
                                                </div>
                                                <div class="tried-inbox-message__actions">
                                                    <a href="" class="components-button"><?php _e( 'Xem ngay', 'tried' ); ?></a>
                                                    <div class="components-dropdown">
                                                        <button type="button" class="components-button non-border"><?php _e( 'Từ chối', 'tried' ); ?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                            <?php
                                    endforeach;
                                endif;
                            ?>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
