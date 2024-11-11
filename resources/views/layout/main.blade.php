<!--
=========================================================
* Soft UI Dashboard Tailwind - v1.0.5
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard-tailwind
* Copyright 2023 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="logo-polban" sizes="16x16" href="{{ asset('assets/img/polban.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/polban.png') }}" />
    <title>Pengajuan Sarana dan Prasarana</title>
    @include('layout.partial.link')
  </head>

<body class="overflow-hidden">
      @yield('content')
  </body>
  @include('layout.partial.script')
</html>
