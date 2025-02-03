<div class="navbar scale-95 bg-body rounded-lg  z-10 sticky top-0 transition-transform duration-300 ease-in-out"
    id="navbar">

    <div class="navbar-start ml-5 lg:ml-10">
        <x-application-logo class="w-[220px] h-16 fill-current text-gray-500 flex" />
    </div>
    <div class="navbar-center hidden lg:flex text-red-primary">
        <ul class="menu menu-horizontal px-1">
            <li><a href="{{ route('dashboard') }}">Beranda</a></li>
            @hasanyrole('admin|teacher')
                @hasrole('admin')
                    <li>
                        <details>
                            <summary class="">Master Data</summary>
                            <ul
                                class="p-2 z-10 w-52 bg-gradient-to-tr from-red-primary to-red-secondary text-white border border-white">
                                <li><a href="{{ route('karyawan.index') }}">Data Karyawan</a></li>
                                <li><a href="{{ route('acara.index') }}">Data Agenda</a></li>

                            </ul>
                        </details>
                    </li>
                @endrole
                <li><a href="{{ route('attendance.index') }}">Data Absensi</a></li>
                @hasrole('teacher')
                    <li><a href="{{ route('teacher.agenda.index') }}">Agenda</a></li>
                @endrole
                @hasrole('admin')
                    <li><a href="{{ route('time.index') }}">Waktu Absen</a></li>

                @endrole
            @else
                <li><a href="{{ route('student.attendance.index') }}">Absen</a></li>
                <li><a href="{{ route('student.siswa.profile.edit') }}">Profile</a></li>
                {{-- <li><a href="{{ route('student.subject.index') }}">Mapel</a></li> --}}
                <li><a href="{{ route('student.history.index') }}">Riwayat Absen</a></li>
            @endhasanyrole
        </ul>
    </div>
    <div class="navbar-end mr-10">
        <div class="dropdown dropdown-end">
            @hasanyrole('student|teacher')
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    @php
                        $words = explode(
                            ' ',
                            Auth::user()->student ? Auth::user()->student->name : Auth::user()->teacher->name,
                        );
                        $acronym = mb_substr($words[0] ?? 'I', 0, 1) . mb_substr($words[1] ?? 'T', 0, 1);

                        // foreach ($words as $w) {
                        //     $acronym .= mb_substr($w, 0, 1);
                        // }

                    @endphp
                    <div class="avatar placeholder">
                        <div
                            class="bg-gradient-to-tr from-red-primary to-red-secondary border border-white text-neutral-content rounded-full w-10">
                            <span class="text-xs">{{ $acronym }}</span>
                        </div>
                    </div>
                </div>
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-gradient-to-tr from-red-primary to-red-secondary text-white border border-white rounded-box w-52">
                    @hasrole('student')
                        <li>
                            <a href="{{ route('changepassword.index') }}">
                                {{ __('Change Password') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('student.siswa.profile.edit') }}">
                                {{ __('Profile') }}
                            </a>
                        </li>
                    @endhasrole
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                        this.closest('form').submit();">{{ __('Log Out') }}</a>
                        </li>

                    </form>
                </ul>
            @else
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">

                    <div class="avatar placeholder">
                        <div
                            class="bg-gradient-to-tr from-red-primary to-red-secondary border border-white text-neutral-content rounded-full w-10">
                            <span class="text-xs"><svg fill="#ffffff" height="15px" width="15px" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0 0 24 24" enable-background="new 0 0 24 24" xml:space="preserve">
                                    <g id="user-admin">
                                        <path
                                            d="M22.3,16.7l1.4-1.4L20,11.6l-5.8,5.8c-0.5-0.3-1.1-0.4-1.7-0.4C10.6,17,9,18.6,9,20.5s1.6,3.5,3.5,3.5s3.5-1.6,3.5-3.5
                                                                                                                                      c0-0.6-0.2-1.2-0.4-1.7l1.9-1.9l2.3,2.3l1.4-1.4l-2.3-2.3l1.1-1.1L22.3,16.7z M12.5,22c-0.8,0-1.5-0.7-1.5-1.5s0.7-1.5,1.5-1.5
                                                                                                                                      s1.5,0.7,1.5,1.5S13.3,22,12.5,22z" />
                                        <path
                                            d="M2,19c0-3.9,3.1-7,7-7c2,0,3.9,0.9,5.3,2.4l1.5-1.3c-0.9-1-1.9-1.8-3.1-2.3C14.1,9.7,15,7.9,15,6c0-3.3-2.7-6-6-6
                                                                                                                                      S3,2.7,3,6c0,1.9,0.9,3.7,2.4,4.8C2.2,12.2,0,15.3,0,19v5h8v-2H2V19z M5,6c0-2.2,1.8-4,4-4s4,1.8,4,4s-1.8,4-4,4S5,8.2,5,6z" />
                                    </g>
                                </svg></span>

                        </div>
                    </div>

                </div>
                <div tabindex="0"
                    class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-gradient-to-tr from-red-primary to-red-secondary text-white border border-white rounded-box w-52">
                    <ul>
                        <li><a href="{{ route('setting.index') }}">{{ __('Setting') }}</a></li>


                        <li>
                            <a href="{{ route('changepassword.index') }}">
                                {{ __('Change Password') }}
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                        this.closest('form').submit();">Logout</a>
                            </form>
                        </li>
                    </ul>
                </div>

            @endhasanyrole

        </div>

    </div>


</div>
<div class="btm-nav lg:hidden shadow-sm z-10 bg-gradient-to-tr from-red-primary to-red-secondary">
    @hasanyrole('admin|teacher|student')
        <a href="{{ route('dashboard') }}" class="{{ Request::is('/') ? 'active bg-red-secondary' : '' }}">
            <i class="fa-solid fa-house text-white" class="h-5 w-5"></i>
            <span class="btm-nav-label text-xs text-white">Beranda</span>
        </a>
        @hasrole('admin')
            <div class="{{ Request::is('student') ? 'active bg-red-secondary' : '' }} dropdown dropdown-top relative ">
                <div tabindex="0" class="flex flex-col justify-center items-center mt-[0.80rem] gap-1">
                    <i class="fa-solid fa-house text-white" class="h-5 w-5"></i>
                    <span class="btm-nav-label text-xs text-white">Data Master</span>
                </div>
                <ul tabindex="0"
                    class="dropdown-content menu text-white rounded-box z-[1] w-52 p-2 bg-red-secondary border border-white">
                    <li><a href="{{ route('karyawan.index') }}">Data Karyawan {{ Request::is('attendance') }}</a></li>
                    <li><a href="{{ route('karyawan.index') }}">Data Agenda {{ Request::is('attendance') }}</a></li>
                </ul>
            </div>
        @endrole
        @hasanyrole('admin|teacher')
            <a href="{{ route('attendance.index') }}"
                class="{{ Request::is('attendance') ? 'active bg-red-secondary' : '' }}">
                <i class="fa-solid fa-clock text-white" class="h-5 w-5"></i>
                <span class="btm-nav-label text-xs text-white">Data Absensi</span>
            </a>
        @endhasanyrole
        @hasrole('teacher')
            <a href="{{ route('teacher.agenda.index') }}"
                class="{{ Request::is('guru/agenda') ? 'active bg-red-secondary' : '' }}">
                <i class="fa-solid fa-house text-white" class="h-5 w-5"></i>
                <span class="btm-nav-label text-xs text-white">Agenda</span>
            </a>
        @endrole
        @hasrole('student')
            <a href="{{ route('student.attendance.index') }}"
                class="{{ Request::is('siswa/attendance') ? 'active bg-red-secondary' : '' }}">
                <i class="fa-solid  fa-calendar text-white" class="h-5 w-5"></i>
                <span class="btm-nav-label text-xs text-white">Absen</span>
            </a>

            <a href="{{ route('student.history.index') }}"
                class="{{ Request::is('siswa/history') ? 'active bg-red-secondary' : '' }}">
                <i class="fa-solid fa-clock text-white" class="h-5 w-5"></i>
                <span class="btm-nav-label text-xs text-white">Riwayat Absen</span>
            </a>
        @endrole
    @endhasanyrole

</div>

<script>
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 0) {
            navbar.classList.remove('scale-95');
            navbar.classList.add('scale-100');
            navbar.classList.add('shadow-lg');
        } else {
            navbar.classList.remove('scale-100');
            navbar.classList.add('scale-95');
            navbar.classList.remove('shadow-lg');

        }
    });
</script>
