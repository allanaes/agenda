<div class="row morevspace field">
	<hr />
	<?php
		$help_link = Auth::check() ? '<span class="divider">//</span> ' . 
			HTML::link_to_route('bantuan', 'Bantuan') . ' <i class="icon-question-sign"></i>' : '';
	?>
	<span class="muted">&copy; 2013, {{ Konfigurasi::find(1)->config_value }} &ndash; {{ Konfigurasi::find(2)->config_value }} {{ $help_link }}</span>
</div>