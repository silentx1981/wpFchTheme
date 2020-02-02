<?php

namespace wpFchTheme;

class Ai1ecevent
{
    public function show($attrs = [])
    {
        $grid = $attrs['grid'] ?? 3;
        $events = $this->getEvents();
        $locale = json_decode(file_get_contents(get_template_directory().'/src/locale/de.json'), true);

        include('template/ai1ecevent.grid1.php');
    }

    private function getEvents()
    {
        global $wpdb;

        $sql = "SELECT 	e.start, 
		                e.end,
		                e.timezone_name,
		                CONVERT_TZ(FROM_UNIXTIME(e.start), '+00:00', e.timezone_name) as Von,
		                CONVERT_TZ(FROM_UNIXTIME(e.end), '+00:00', e.timezone_name) as Bis, 
		                e.instant_event,
                        p.post_title,
                        p.post_content,
                        p.post_status,
		                e.venue as beschreibung,
		                e.address as adresse,
		                e.city as ort
                FROM wp_ai1ec_events as e
                INNER JOIN wp_posts  as p
                    ON e.post_id = p.ID 
                WHERE p.post_status = 'publish'
                HAVING DATE_FORMAT(FROM_UNIXTIME(e.start), '%Y-%m-%d') > DATE_FORMAT(NOW(), '%Y-%m-%d')
                ORDER BY FROM_UNIXTIME(e.start)";
        $result = $wpdb->get_results($sql);

        return json_decode(json_encode($result), true);
    }

}
