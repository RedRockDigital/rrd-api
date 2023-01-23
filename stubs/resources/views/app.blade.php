<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @viteReactRefresh
    @vite(['resources/js/Components/AppClient.jsx'])

    <script>
        window.asset_url = '{{ config('app.asset_url') }}';
        window.app = @json($app);
    </script>

    @if(config("rewardful.api_key"))
        <script>(function(w,r){w._rwq=r;w[r]=w[r]||function(){(w[r].q=w[r].q||[]).push(arguments)}})(window,'rewardful');</script>
        <script async src="//r.wdfl.co/rw.js" data-rewardful="{{ config("rewardful.api_key") }}"></script>
    @endif

    @if(config("helpscout.beacon_key"))
        <script type="text/javascript">!function(e,t,n){function a(){var e=t.getElementsByTagName("script")[0],n=t.createElement("script");n.type="text/javascript",n.async=!0,n.src="https://beacon-v2.helpscout.net",e.parentNode.insertBefore(n,e)}if(e.Beacon=n=function(t,n,a){e.Beacon.readyQueue.push({method:t,options:n,data:a})},n.readyQueue=[],"complete"===t.readyState)return a();e.attachEvent?e.attachEvent("onload",a):e.addEventListener("load",a,!1)}(window,document,window.Beacon||function(){});
        </script><script type="text/javascript">window.Beacon('init', '{{ config("helpscout.beacon_key") }}')</script>
    @endif
</head>

<body>
{!! ssr(vite('resources/js/Components/AppServer.jsx'))
    ->fallback('<div id="app"></div>')
    ->render() !!}
</body>
</html>
