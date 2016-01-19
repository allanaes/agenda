<div id='headermenu'>
	{{ HTML::image('img/header.png', "Agenda Surat") }}
</div>

<div id='cssmenu'>
	<ul>
		<li>{{ HTML::decode(HTML::link_to_route('beranda', '<i class="icon-home icon-white"></i> Beranda')) }}</li>
		<li class='active has-sub'><a href='#'><span><i class="icon-inbox icon-white"></i> Surat Masuk</span></a>
			<ul>
			<li>{{ HTML::decode(HTML::link_to_route('suratmasuk', '<i class="icon-pencil icon-white"></i> Input surat masuk')) }}</a></li>
			<li>{{ HTML::decode(HTML::link_to_route('search_suratmasuk', '<i class="icon-search icon-white"></i> Cari / print surat masuk')) }}</a></li>
			<li class='last'>{{ HTML::decode(HTML::link_to_route('pengawasan_suratmasuk', '<i class="icon-tag icon-white"></i> Pengawasan surat masuk')) }}</a></li>
			</ul>
		</li>
		<li class='active has-sub'><a href='#'><span><i class="icon-list-alt icon-white"></i> Surat Keluar</span></a>
			<ul>
			<li>{{ HTML::decode(HTML::link_to_route('suratkeluar', '<i class="icon-pencil icon-white"></i> Input surat keluar')) }}</a></li>
			<li class='last'>{{ HTML::decode(HTML::link_to_route('search_suratkeluar', '<i class="icon-search icon-white"></i> Cari / print surat keluar')) }}</a></li>
			</ul>
		</li>
		<li>{{ HTML::decode(HTML::link_to_route('settings', '<i class="icon-cog icon-white"></i> Settings')) }}</li>
		
		@if (Auth::check())	
			<li class='active has-sub last'><a href='#'><span><i class="icon-user icon-white"></i> {{ User::filtered_fullname() }}</span></a>
				<ul>
					<li>{{ HTML::decode(HTML::link('logout', '<i class="icon-off icon-white"></i> Logout')) }}</li>
				</ul>
			</li>
		@endif
	</ul>
</div>