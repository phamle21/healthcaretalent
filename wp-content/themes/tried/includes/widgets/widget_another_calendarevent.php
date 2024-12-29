<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_another_calendarevent extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_another_calendarevent', 'Tried Another Calendar Event',
			array(
				'classname' => 'widget_another_calendarevent',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);

        add_action( 'wp_ajax_tried_render_calendar_events', array( $this, 'ajx_tried_render_calendar_events' ) );
        add_action( 'wp_ajax_nopriv_tried_render_calendar_events', array( $this, 'ajx_tried_render_calendar_events' ) );
        add_action( 'wp_ajax_tried_render_calendar_ids_events', array( $this, 'ajx_tried_render_calendar_ids_events' ) );
        add_action( 'wp_ajax_nopriv_tried_render_calendar_ids_events', array( $this, 'ajx_tried_render_calendar_ids_events' ) );
	}

    function widget($args, $instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' )
        );
        $instance = wp_parse_args($instance, $defaults);
        
		$title = $instance['title'];
        
		echo $args['before_widget'];
		?>
<section id="section-<?php echo $args['widget_id']; ?>" class="section-another-calendarevent">
    <div class="section-wrapper margin-auto">
        <div class="calendar-block">
            <h4><?php echo $title; ?></h4>
            <div class="calendar-wrapper">
                <div class="calendar-action">
                    <div class="year-month"></div>
                    <div class="nav-btns">
                        <a href="javascript:;" class="nav-btn go-prev"><?php _e( 'prev', 'tried' ); ?></a>
                        <a href="javascript:;" class="nav-btn go-next"><?php _e( 'next', 'tried' ); ?></a>
                    </div>
                </div>
                <div class="calendar-context">
                    <div class="days">
                        <div class="day">MON</div>
                        <div class="day">TUE</div>
                        <div class="day">WED</div>
                        <div class="day">THU</div>
                        <div class="day">FRI</div>
                        <div class="day">SAT</div>
                        <div class="day">SUN</div>
                    </div>
                    <div class="dates"></div>
                </div>
            </div>
        </div>
        <div class="listevents-block">
            <div class="events"></div>
        </div>
        <div class="modal-tried">
            <div class="modal-overlay"></div>
            <div class="modal-wrapper" style="max-width: 700px;">
                <div class="modal-head">
                    <h4 class="modal-title"><?php _e( 'Events on', 'tried' ); ?> <span class="on-date">-</span></h4>
                    <span class="box-icon--close">
                        <svg width="20px" height="20px" viewBox="0 0 19 19" role="presentation">
                            <path
                                d="M9.1923882 8.39339828l7.7781745-7.7781746 1.4142136 1.41421357-7.7781746 7.77817459 7.7781746 7.77817456L16.9705627 19l-7.7781745-7.7781746L1.41421356 19 0 17.5857864l7.7781746-7.77817456L0 2.02943725 1.41421356.61522369 9.1923882 8.39339828z"
                                fill="currentColor" fill-rule="evenodd"></path>
                        </svg>
                    </span>
                </div>
                <div class="modal-body" style="height: 100%; max-height: 400px; overflow: auto;">
                    <div class="event_dates"></div>
                </div>
            </div>
        </div>
    </div>
    <style>
    /* section calendar */

    .calendar-wrapper {
        width: 300px;
        margin: 0 auto;
        font-family: "NotoSansR";
    }

    .calendar-wrapper .calendar-action {
        display: grid;
        grid-template-columns: auto 100px;
        align-items: center;
        font-weight: 700;
        font-size: 30px;
        line-height: 78px;
    }

    .calendar-wrapper .calendar-action .year-month {
        width: 100%;
        font-size: 24px;
        font-weight: 600;
        line-height: 1;
    }

    .calendar-wrapper .calendar-action .nav-btns {
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .calendar-wrapper .calendar-action .nav {
        display: flex;
        border: 1px solid #333333;
        border-radius: 5px;
    }

    .calendar-wrapper .calendar-action .go-prev,
    .calendar-wrapper .calendar-action .go-next {
        display: block;
        width: 24px;
        height: 40px;
        font-size: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .calendar-wrapper .calendar-action .go-prev::before,
    .calendar-wrapper .calendar-action .go-next::before {
        content: "";
        display: block;
        width: 15px;
        height: 15px;
        border: 1px solid #000;
        border-width: 2px 2px 0 0;
        transition: border 0.1s;
    }

    .calendar-wrapper .calendar-action .go-prev:hover::before,
    .calendar-wrapper .calendar-action .go-next:hover::before {
        border-color: #ed2a61;
    }

    .calendar-wrapper .calendar-action .go-prev::before {
        transform: rotate(-135deg);
    }

    .calendar-wrapper .calendar-action .go-next::before {
        transform: rotate(45deg);
    }

    .calendar-wrapper .calendar-context {
        padding-top: 20px;
        position: relative;
        margin: 0 auto;
    }

    .calendar-wrapper .calendar-context .days {
        display: flex;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #ddd;
    }

    .calendar-wrapper .calendar-context::after {
        top: 368px;
    }

    .calendar-wrapper .calendar-context .day {
        display: flex;
        align-items: center;
        justify-content: center;
        width: calc(100% / 7);
        color: #999;
        font-size: 12px;
        text-align: center;
        border-radius: 5px;
        margin-bottom: 5px;
    }

    .current.today {
        background: rgb(242 242 242);
    }

    .current.active {
        background: #07317a;
        color: #fff !important;
        cursor: pointer;
    }

    .calendar-wrapper .calendar-context .dates {
        display: flex;
        flex-flow: wrap;
        height: 200px;
    }

    .calendar-wrapper .calendar-context .day:nth-child(7n -1) {
        color: #3c6ffa;
    }

    .calendar-wrapper .calendar-context .day:nth-child(7n) {
        color: #ed2a61;
    }

    .calendar-wrapper .calendar-context .day.disable {
        color: #ddd;
    }

    @media only screen and (max-width: 767px) {

        .calendar-wrapper .calendar-action .go-prev::before,
        .calendar-wrapper .calendar-action .go-next::before {
            width: 12px;
            height: 12px;
        }
    }
    </style>
    <script>
    $(document).ready(function() {
        calendarInit();
    });

    function calendarInit() {
        var date = new Date();
        var utc = date.getTime() + (date.getTimezoneOffset() * 60 * 1000);
        var kstGap = 9 * 60 * 60 * 1000;
        var today = new Date(utc + kstGap);

        var thisMonth = new Date(today.getFullYear(), today.getMonth(), today.getDate());

        var currentYear = thisMonth.getFullYear();
        var currentMonth = thisMonth.getMonth();
        var currentDate = thisMonth.getDate();

        renderCalender(thisMonth);

        renderEvents(thisMonth, false);

        function renderCalender(thisMonth) {
            currentYear = thisMonth.getFullYear();
            currentMonth = thisMonth.getMonth();
            currentDate = thisMonth.getDate();


            var startDay = new Date(currentYear, currentMonth, 0);
            var prevDate = startDay.getDate();
            var prevDay = startDay.getDay();


            var endDay = new Date(currentYear, currentMonth + 1, 0);
            var nextDate = endDay.getDate();
            var nextDay = endDay.getDay();

            function convertMonthToString(month = false) {
                if (!month) return false;
                switch (month) {
                    case 1:
                        return 'January';
                        break;
                    case 2:
                        return 'February';
                        break;
                    case 3:
                        return 'March';
                        break;
                    case 4:
                        return 'April';
                        break;
                    case 5:
                        return 'May';
                        break;
                    case 6:
                        return 'June';
                        break;
                    case 7:
                        return 'July';
                        break;
                    case 8:
                        return 'August';
                        break;
                    case 9:
                        return 'September';
                        break;
                    case 10:
                        return 'October';
                        break;
                    case 11:
                        return 'November';
                        break;
                    case 12:
                        return 'December';
                        break;
                    default:
                        return 'January';
                        break;
                }
            }
            var convertStringMonth = convertMonthToString(currentMonth + 1);

            $('.year-month').text(`${convertStringMonth} ${currentYear}`);


            calendar = document.querySelector('.dates')
            calendar.innerHTML = '';


            for (var i = prevDate - prevDay + 1; i <= prevDate; i++) {
                calendar.innerHTML = calendar.innerHTML + '<div class="day prev disable" data-day="' + i +
                    '" data-month="' +
                    (currentMonth + 1) + '">' + i +
                    '</div>'
            }

            for (var i = 1; i <= nextDate; i++) {
                calendar.innerHTML = calendar.innerHTML + '<div class="day current" data-day="' + i + '" data-month="' +
                    (currentMonth + 1) + '">' + i +
                    '</div>'
            }

            for (var i = 1; i <= (7 - nextDay == 7 ? 0 : 7 - nextDay); i++) {
                calendar.innerHTML = calendar.innerHTML + '<div class="day next disable" data-day="' + i +
                    '" data-month="' +
                    (currentMonth + 1) + '">' + i +
                    '</div>'
            }

            if (today.getMonth() == currentMonth) {
                todayDate = today.getDate();
                var currentMonthDate = document.querySelectorAll('.dates .current');
                currentMonthDate[todayDate - 1].classList.add('today');
            }
        }

        $('.go-prev').on('click', function() {
            thisMonth = new Date(currentYear, currentMonth - 1, 1);
            renderCalender(thisMonth);
            renderEvents(thisMonth);
        });

        $('.go-next').on('click', function() {
            thisMonth = new Date(currentYear, currentMonth + 1, 1);
            renderCalender(thisMonth);
            renderEvents(thisMonth);
        });

        function renderEvents(month, query = true) {
            var wrapperEvent = $('.listevents-block .events');
            if (month) {
                var args = {
                    action: 'tried_render_calendar_events'
                };
                if (query) {
                    args['month'] = month.toLocaleDateString("en-US", {
                        year: 'numeric',
                        month: 'short'
                    });
                }
                $.ajax({
                    type: "get",
                    url: tried_script.ajax_url,
                    data: args,
                    beforeSend: function() {
                        wrapperEvent.addClass('loading');
                    },
                    success: function(res) {
                        if (res.code == 200) {
                            wrapperEvent.html('');
                            if (Object.keys(res.response).length != 0) {
                                var daysOfCurrentMonth = [];
                                for (const [key, value] of Object.entries(res.response)) {
                                    let title = value['title'];
                                    value['list'].forEach((r, i) => {
                                        if (i != 0) title = '';
                                        wrapperEvent.append(
                                            `<div class="event-item">
                                                <h4>${title}</h4>
                                                <span>${r['post_date']}</span>
                                                <a href="${r['post_link']}" title="${r['post_title']}"><h5>${r['post_title']}</h5></a>
                                                <p>${r['post_location']}</p>
                                            </div>`
                                        );

                                        let dayMonth = $(
                                            `.calendar-context .day.current[data-day="${r['calendar_day']}"][data-month="${r['calendar_month']}"]`
                                        );
                                        dayMonth.addClass(function() {
                                            let currentIDs = $(this).attr('data-ids') ?? [];
                                            if (typeof currentIDs == 'string') {
                                                currentIDs = currentIDs.split(',');
                                            }
                                            currentIDs.push(String(r['post_id']));
                                            $(this).attr('data-ids', currentIDs.join(','));
                                            return 'active';
                                        });
                                    });
                                }
                            } else {
                                wrapperEvent.html(
                                    '<p class="not-found"><?php _e( "No events found!", 'tried' ); ?></p>'
                                );
                            }
                        } else {
                            console.log('Có lỗi xảy ra!');
                        }
                    },
                    complete: function() {
                        wrapperEvent.removeClass('loading');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('The following error occured: ' + textStatus, errorThrown);
                    }
                });
            }
        }

        $(document).on('click', '.calendar-context .dates > .day.active', function() {
            var wrapper = $(this).closest('.section-another-calendarevent'),
                eventDates = wrapper.find('.event_dates'),
                dayIDs = $(this).attr('data-ids') ?? false;
            if (dayIDs) {
                console.log(dayIDs);
                $.ajax({
                    type: "get",
                    url: tried_script.ajax_url,
                    data: {
                        action: 'tried_render_calendar_ids_events',
                        ids: dayIDs
                    },
                    beforeSend: function() {
                        // coding
                    },
                    success: function(res) {
                        if (res.code == 200 && res.response) {
                            eventDates.html('');
                            if (Object.keys(res.response).length != 0) {
                                for (const [key, value] of Object.entries(res.response)) {
                                    value['list'].forEach((r, i) => {
                                        console.log(r);
                                        eventDates.append(
                                            `<div class="event_date-item">
                                                <div class="wrap">
                                                    <div class="date-iconplaceholder">
                                                        <div class="dateico">
                                                            <span class="day">${r['calendar_day']}</span>
                                                            <span class="month">${r['calendar_month']}</span>
                                                        </div>
                                                    </div>
                                                    <div class="date-infocontext">
                                                        <a href="${r['post_link']}" title="${r['post_title']}">
                                                            <h4>${r['post_title']}</h4>
                                                        </a>
                                                        <ul>
                                                            <li class="calendar">${r['post_date']}</li>
                                                            <li class="location" style="${r['post_location']?'display: block;':'display: none;'}">${r['post_location']}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>`
                                        );
                                    });
                                    wrapper.find('.modal-tried .modal-title .on-date').text(value[
                                        'title']);
                                }
                            }
                            wrapper.find('.modal-tried').addClass('opened');
                        } else {
                            console.log('Có lỗi xảy ra!');
                        }
                    },
                    complete: function() {
                        // coding
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('The following error occured: ' + textStatus, errorThrown);
                    }
                });
            }
        });
    }
    </script>
</section>
<?php
		echo $args['after_widget'];
    }
	
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['title'] = ($new_instance['title']);
        return $instance;
    }

    function form($instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' )
        );
        $instance = wp_parse_args($instance, $defaults);
		?>
<h4><?php _e( 'Info', 'tried' ); ?></h4>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
</p>
<?php
    }
    
    function ajx_tried_render_calendar_events() {
        $result = array(
            'code' => 400,
            'response' => false
        );
            $events = get_posts(array (
                'post_type' => 'calevents',
                'orderby' => 'date',
                'order'=> 'ASC', 
                'post_status' => 'publish',
                'posts_per_page' => -1
            ));
            $newEvents = array();
            if ( !empty( $events ) ) {
                foreach ( $events as $event ) {
                    $publish = get_post_meta( $event->ID, 'publish', true );
                    $newPostDate = date_create( $publish );
                    $longMonth = date_format( $newPostDate, 'M Y' );
                    $slugPostDate = convert_slug( $longMonth );
                    $location = get_post_meta( $event->ID, 'location', true );
                    $args = array(
                        'post_id' => $event->ID,
                        'post_title' => get_the_title( $event->ID ),
                        'post_date' => date_format( $newPostDate, 'M d, Y h:i A' ),
                        'post_location' => $location,
                        'post_publish' => $publish,
                        'calendar_day' => date_format( $newPostDate, 'j' ),
                        'calendar_month' => date_format( $newPostDate, 'n' ),
                        'post_link' => get_permalink( $event->ID )
                    );
                    if ( !empty( $publish ) ) {
                        $publishYear = date_format( $newPostDate, 'Y' );
                        $currentYear = current_datetime()->format( 'Y' );
                        if ( $publishYear != $currentYear ) continue;
                        
                        $publishMonth = intval( date_format( $newPostDate, 'n' ) );
                        $currentMonth = intval( current_datetime()->format( 'N' ) );
                        $args['zpublishMonth'] = $publishMonth;
                        $args['zcurrentMonth'] = $currentMonth;
                        if ( $publishMonth < $currentMonth) continue;
                    }
                    if ( isset( $_GET['month'] ) && $_GET['month'] != $longMonth ) continue;
                    $newEvents[$slugPostDate]['title'] = $longMonth;
                    $newEvents[$slugPostDate]['list'][] = $args;
                }
                $result['code'] = 200;
                $result['response'] = array_reverse( $newEvents );
            }

        wp_send_json( $result);
    }
    
    function ajx_tried_render_calendar_ids_events() {
        $result = array(
            'code' => 400,
            'response' => false
        );
        if ( isset( $_GET['ids'] ) ) {
            $ids = explode( ',', $_GET['ids'] );
            $events = get_posts( array (
                'post_type' => 'calevents',
                'orderby' => 'date',
                'order'=> 'ASC', 
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'post__in' => $ids
            ) );
            $result['response'] = $events;
            $newEvents = array();
            if ( !empty( $events ) ) {
                foreach ( $events as $event ) {
                    $publish = get_post_meta( $event->ID, 'publish', true );
                    $newPostDate = date_create( $publish );
                    $longMonth = date_format( $newPostDate, 'F d, Y' );
                    $slugPostDate = convert_slug( $longMonth );
                    $location = get_post_meta( $event->ID, 'location', true );
                    $args = array(
                        'post_id' => $event->ID,
                        'post_title' => get_the_title( $event->ID ),
                        'post_date' => date_format( $newPostDate, 'd M Y' ),
                        'post_publish' => $publish,
                        'post_location' => $location,
                        'calendar_day' => date_format( $newPostDate, 'd' ),
                        'calendar_month' => date_format( $newPostDate, 'M' ),
                        'post_link' => get_permalink( $event->ID )
                    );
                    $newEvents[$slugPostDate]['title'] = $longMonth;
                    $newEvents[$slugPostDate]['list'][] = $args;
                }
                $result['code'] = 200;
                $result['response'] = $newEvents;
            }
        }
        wp_send_json( $result);
    }
}