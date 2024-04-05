<div style="background-color: {{ $firstValue ?? '#3c4b64' }} "
    class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show {{ request()->routeIs('app.pos.*') ? 'c-sidebar-minimized' : '' }}"
    id="sidebar">
    <div class="c-sidebar-brand d-md-down-none">
        <a href="{{ route('home') }}">
            @php
                $userSetting = auth()->user()->setting;
                $logoPath = $userSetting
                    ? ($userSetting->image != 'avatar.png'
                        ? asset('storage/' . $userSetting->image)
                        : asset('images/logo.png'))
                    : asset('images/logo.png');
            @endphp

            <img class="c-sidebar-brand-full"
                src="{{ auth()->user()->hasRole('Super Admin') ? asset('images/logo.png') : $logoPath }}" alt="Site Logo"
                width="200">
            <img class="c-sidebar-brand-minimized" src="{{ asset('images/logo-minimize.png') }}" alt="Site Logo"
                width="40">
        </a>
    </div>

    <ul class="c-sidebar-nav">
        @include('layouts.menu')


        <div class="ps__rail-x" style="left: 0; bottom: 0;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0; width: 0;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0; height: 692px; right: 0;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0; height: 369px;"></div>
        </div>
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
        data-class="c-sidebar-minimized"></button>
</div>
