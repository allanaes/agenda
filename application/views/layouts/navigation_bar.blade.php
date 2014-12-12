<div class="navbar">
	<div class="control">
		<div class="menu">{{ HTML::decode(HTML::link_to_route('beranda', '<i class="icon-home icon-white"></i> Beranda')) }}</div>	
		
		<div class="menu">{{ HTML::decode(HTML::link_to_route('suratmasuk', '<i class="icon-inbox icon-white"></i> Input surat masuk')) }}</div>	
		<div class="menu">{{ HTML::decode(HTML::link_to_route('search_suratmasuk', '<i class="icon-search icon-white"></i> Cari / print surat masuk')) }}</div>		

		<div class="menu">{{ HTML::decode(HTML::link_to_route('suratkeluar', '<i class="icon-list-alt icon-white"></i> Input surat keluar')) }}</div>
		<div class="menu">{{ HTML::decode(HTML::link_to_route('search_suratkeluar', '<i class="icon-search icon-white"></i> Cari / print surat keluar')) }}</div>

		<div class="menu">{{ HTML::decode(HTML::link_to_route('settings', '<i class="icon-cog icon-white"></i> Settings')) }}</div>

		@if (Auth::check())
		<div class="menu"><span class="muted username">{{ User::filtered_fullname() }}</span>{{ HTML::decode(HTML::link('logout', '<i class="icon-off icon-white"></i> Logout')) }}</div>
		@endif
	</div>
	<div class="control-left">
		<div class="header-img">{{ HTML::image('img/header.png', "Agenda Surat") }}</div>
	</div>
</div>