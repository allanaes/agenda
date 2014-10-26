<!DOCTYPE html>
<html>
<head>
<title>{{ $title }}</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="{{ URL::to_asset('css/disposisi.css') }}" media="all" type="text/css" rel="stylesheet">
<link href="{{ URL::to_asset('css/glyphicons.css') }}" media="all" type="text/css" rel="stylesheet">
</head>

<body>
<table border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="13%" rowspan="4">{{ HTML::image('img/logo.png', 'Logo', array('class' => 'logo')); }}</td>
    <td colspan="4"><h1>Direktorat Jenderal Pajak</h1></td>
  </tr>
  <tr> 
    <td colspan="4"><h2>{{ $suratmasuk->nama_kpp }}</h2></td>
  </tr>
  <tr> 
    <td colspan="4"><h3>{{ $suratmasuk->nama_seksi }}</h3></td>
  </tr>
  <tr> 
    <td colspan="4" class="header">LEMBAR DISPOSISI</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr> 
    <td class="label">Nomor Agenda</td>
    <td class="border-bottom content">{{ $suratmasuk->nomor_agenda_seksi }}</td>
    <td class="center-divider">&nbsp;</td>
    <td class="label2">Nomor Agenda Sekre</td>
    <td class="border-bottom content">{{ $suratmasuk->nomor_agenda_sekre }}</td>
  </tr>
  <tr> 
    <td>Tanggal diterima</td>
    <td class="border-bottom content">{{ $suratmasuk->tgl_diterima }}</td>
    <td>&nbsp;</td>
    <td>Nomor Surat</td>
    <td class="border-bottom content">{{ $suratmasuk->nomor_surat }}</td>
  </tr>
  <tr> 
    <td>Nama Pengirim</td>
    <td class="border-bottom content">{{ $suratmasuk->pengirim }}</td>
    <td>&nbsp;</td>
    <td>Tanggal Surat</td>
    <td class="border-bottom content">{{ $suratmasuk->tgl_surat }}</td>
  </tr>
  <tr> 
    <td class="vtop">Perihal</td>
    <td class="border-bottom vtop content duoline" colspan="4">{{ $suratmasuk->hal }}</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="4"><em>PERHATIAN: Dilarang memisahkan sehelai surat pun dari berkas 
      yang telah disusun</em></td>
  </tr>
  <tr> 
    <td class="bordered-top" colspan="2">SIFAT:</td>
    <td>&nbsp;</td>
    <td class="bordered-top" colspan="2">DITUJUKAN KEPADA:</td>
  </tr>
  <tr> 
    <td class="bordered-bottom vtop" colspan="2">
      @foreach ($suratmasuk->daftar_sifat as $key => $value)
        @if (in_array($key, $suratmasuk->sifat))
          <b class="checkbox"><span class="ok">&#x2713;</span></b>{{ e($value) }}<br />
        @else
          <b class="checkbox"><span class="ok">&nbsp;</span></b>{{ e($value) }}<br />
        @endif
      @endforeach

      <span>PETUNJUK:<br /></span>
      @foreach ($suratmasuk->daftar_petunjuk as $row)
        @if (in_array($row->id, $suratmasuk->petunjuk))
          <b class="checkbox"><span class="ok">&#x2713;</span></b>{{ e($row->petunjuk) }}<br />
        @else
          <b class="checkbox"><span class="ok">&nbsp;</span></b>{{ e($row->petunjuk) }}<br />
        @endif
      @endforeach
    </td>
    <td>&nbsp;</td>
    <td class="bordered-bottom vtop" colspan="2">
      @foreach ($suratmasuk->daftar_disposisi as $row)
        @if (in_array($row->id, $suratmasuk->disposisi))
          <b class="checkbox"><span class="ok">&#x2713;</span></b>{{ e($row->nama) }}<br />
        @else            
          <b class="checkbox"><span class="ok">&nbsp;</span></b>{{ e($row->nama) }}<br />
        @endif
      @endforeach

      @if(!empty($suratmasuk->lain_lain))
          <b class="checkbox"><span class="ok">&#x2713;</span></b>{{ e($suratmasuk->lain_lain) }}<br />
      @endif
    </td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td class="bordered vtop triline" colspan="5">CATATAN: <span class="content">{{ $suratmasuk->catatan}}</span></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
