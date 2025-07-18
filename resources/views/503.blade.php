<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @if($allsettings->site_favicon != '')
    <link rel="apple-touch-icon" href="{{ url('/') }}/public/storage/settings/{{ $allsettings->site_favicon }}">
    <link rel="shortcut icon" href="{{ url('/') }}/public/storage/settings/{{ $allsettings->site_favicon }}">
    @endif
    <title>{{ $allsettings->m_mode_title }} - {{ $allsettings->site_title }}</title>
    <link rel="stylesheet" href="{{ URL::to('resources/views/theme/assets/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('resources/views/theme/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('resources/views/theme/assets/css/bd-coming-soon.css') }}">
    @if($allsettings->m_mode_background == "image")
	<style type="text/css">
	body {
	  background-image: url("{{ url('/') }}/public/storage/settings/{{ $allsettings->m_mode_bgimage }}");
	  background-size: cover;
	  background-repeat: no-repeat;
	  background-position: center;
	  color: #ffffff;
	  padding-bottom: 75px; 
	  }
  </style>
  @else
  <style type="text/css">
	body {
	  
	  background-size: cover;
	  background-color:{{ $allsettings->m_mode_bgcolor }};
	  background-repeat: no-repeat;
	  background-position: center;
	  color: #ffffff;
	  padding-bottom: 75px; 
	  }
  </style>
  @endif
</head>

<body class="min-vh-100 d-flex flex-column">

    <header>
        <div class="container">
            <nav class="navbar navbar-dark bg-transparenet">
                <a class="navbar-brand" href="{{ URL::to('/') }}">
                    <img src="{{ url('/') }}/public/storage/settings/{{ $allsettings->site_logo }}" alt="{{ $allsettings->site_title }}">
                </a>
                @if($allsettings->office_phone != "")
                <span class="navbar-text ml-auto d-none d-sm-inline-block">{{ $allsettings->office_phone }}</span>
                @endif
                @if($allsettings->office_email != "")
                <span class="navbar-text d-none d-sm-inline-block">{{ $allsettings->office_email }}</span>
                @endif
            </nav>
        </div>
    </header>
    <main class="my-auto">
        <div class="container">
            @if($allsettings->m_mode_title != "")
            <h1 class="page-title">{{ $allsettings->m_mode_title }}</h1>
            @endif
            @if($allsettings->m_mode_content != "")
            <p class="page-description">@php echo html_entity_decode($allsettings->m_mode_content); @endphp
            </p>
            @endif
            @if($allsettings->m_mode_social_label != "")
            <p>{{ $allsettings->m_mode_social_label }}</p>
            @endif
            <nav class="footer-social-links">
                @if($allsettings->facebook_url != '')
                <a href="{{ $allsettings->facebook_url }}" class="social-link" target="_blank"><i class="mdi mdi-facebook-box"></i></a>
                @endif
                @if($allsettings->twitter_url != '')
                <a href="{{ $allsettings->twitter_url }}" class="social-link" target="_blank"><i class="mdi mdi-twitter"></i></a>
                @endif
                @if($allsettings->pinterest_url != '')
                <a href="{{ $allsettings->pinterest_url }}" class="social-link" target="_blank"><i class="mdi mdi-pinterest"></i></a>
                @endif
                @if($allsettings->gplus_url != '')
                <a href="{{ $allsettings->gplus_url }}" class="social-link" target="_blank"><i class="mdi mdi-linkedin"></i></a>
                @endif
                @if($allsettings->instagram_url != '')
                <a href="{{ $allsettings->instagram_url }}" class="social-link" target="_blank"><i class="mdi mdi-instagram"></i></a>
                @endif
            </nav>
        </div>
    </main>
</body>
</html>