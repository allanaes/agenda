<div class="navbar">
	<div class="control">
		<div class="menu"><i class="icon-home"></i> {{ HTML::decode(HTML::link_to_route('beranda', 'Beranda')) }}</div>	
		
		<div class="menu"><span class="nav-divider">·</span></div>
		<div class="menu"><i class="icon-search"></i> {{ HTML::decode(HTML::link_to_route('search_suratmasuk', 'Cari / print daftar surat masuk')) }}</div>		

		<div class="menu"><span class="nav-divider">·</span></div>
		<div class="menu"><i class="icon-search"></i> {{ HTML::decode(HTML::link_to_route('search_suratkeluar', 'Cari / print daftar surat keluar')) }}</div>

		@if (Auth::check())
		<div class="menu"><span class="nav-divider">·</span></div>
		<div class="menu"><span class="muted">{{ User::filtered_fullname() }}</span> {{ HTML::decode(HTML::link('logout', '[ Logout ]')) }}</div>
		@endif
	</div>
</div>