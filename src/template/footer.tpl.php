	<?php wp_footer(); ?>
	<br>
    <!-- swipe start -->
    <script src='//cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.4/jquery.touchSwipe.min.js'></script>
    <script type="text/javascript">
        jQuery(".carousel").swipe({
            swipe: function (event, direction, distance, duration, fingerCount, fingerData) {
                if (direction == 'left') jQuery(this).carousel('next');
                if (direction == 'right') jQuery(this).carousel('prev');
            },
            allowPageScroll: "vertical"
        });
    </script>

	</body>
</html>
