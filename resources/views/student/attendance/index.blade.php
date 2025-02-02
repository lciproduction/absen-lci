<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div id="toast-top-left" class="hidden toast toast-top toast-start z-[999] top-16 left-0">
                <div class="alert alert-info">
                    <span id="notif"></span>
                </div>
            </div>
            <div
                class="bg-gradient-to-tr from-red-primary to-red-secondary rounded-lg shadow-inner shadow-white p-2 mx-auto w-[90%]">
                <div class="pb-2 px-2 border-b-2 border-white text-white">
                    <h1 class="text-[18px] font-semibold">Form Absensi</h1>
                    <p class="text-[12px] italic text-white/80">Silahkan pilih status kehadiran anda</p>
                </div>
                <div class="flex flex-col p-2 lg:p-6 text-center w-full ">

                    @include('student.attendance.selector')
                    {{-- <p id="demo"></p>
                    <button onclick="getNavigator()">klik</button> --}}
                    <div id="locationIframe"></div>

                    <div id="skeletonMap" class="hidden">

                        <iframe class="bg-gray-200 skeleton " width="100%" height="300" frameborder="0"
                            allowfullscreen></iframe>
                        <button
                            class="btn bg-red-secondary hover:bg-red-primary/80 text-white skeleton  mt-5 w-full"></button>
                    </div>
                    <span class="loading loading-spinner text-primary hidden" id="loading"></span>

                    <!-- Buttons for Absen Masuk (Hadir) and Absen Pulang -->
                    <x-button.primary-button id="AbsenHadir" class="mt-3 hidden">Absen Hadir
                    </x-button.primary-button>
                    <x-button.primary-button id="AbsenPulang" class="mt-3 hidden">Absen Pulang</x-button.primary-button>


                    <button id="sendPermit" class="mt-3 btn bg-[#ffad01] hover:bg-[#ffad01]/90 hidden text-white">Absen
                        Izin</button>
                    <x-button.warning-button id="sendSick" class="mt-3 hidden">Absen Sakit</x-button.warning-button>

                    <!-- Error message for location permission -->
                    <p id="note-error" class="hidden font-light text-gray-500 sm:text-lg dark:text-gray-400">
                        Anda Tidak Bisa Melakukan Absen, Silahkan Refresh Browser Lalu Aktifkan / Izinkan / Allow Lokasi
                        Anda.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const status = document.getElementById('status');
            const userId = '{{ auth()->user()->student?->id }}';
            const apiUrl = '{{ route('student.attendance.store') }}';
            const roleId = '{{ auth()->user()->role }}';
            const locationIframe = document.getElementById('locationIframe');

            status.addEventListener('change', handleStatusChange);

            function handleStatusChange() {
                const statusValue = status.value;
                hideAll();
                switch (statusValue) {
                    case 'AbsenHadir':
                        showLocation();
                        break;

                    case 'AbsenPulang':
                        showLocationPulang();
                        break;


                    case 'Izin':
                        showPermit();
                        break;


                    case 'Sakit':
                        showSick();
                        break;
                    default:
                        break;
                }
            }

            function hideAll() {
                $('#fileUpload, #permit, #AbsenHadir,#skeletonMap, #AbsenPulang, #sendPermit, #sendSick, #toast-top-left')
                    .hide();
                locationIframe.innerHTML = '';
            }

            function showLocation() {
                // $('#AbsenHadir').show(); // Show the WFO button correctly
                $('#skeletonMap').show(); // Show the WFO button correctly
                initializeLocation();
            }


            function showLocationPulang() {
                $('#skeletonMap').show();
                initializeLocationPulang();
            }

            function showPermit() {
                $('#permit, #sendPermit').show();
                initializePermit();
            }

            function showSick() {
                $('#fileUpload, #sendSick').show();
                initializeSick();
            }

            function initializeLocation() {
                const btn = document.getElementById('AbsenHadir');
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        position => {
                            const latitude = position.coords.latitude;
                            const longitude = position.coords.longitude;
                            const formData = {
                                id: userId,
                                role: roleId,
                                latitude: latitude,
                                longitude: longitude,
                                status: status.value,
                            };

                            displayLocationIframe(latitude, longitude); // Show the map iframe

                            console.log("Latitude: " + latitude);
                            $('#skeletonMap').hide();

                            $('#AbsenHadir').show();
                            btn.onclick = function() {
                                sendFormData(formData);
                            };
                        },
                        error => {
                            console.error('Geolocation error:', error);
                            $('#note-error').show();
                        }, {
                            maximumAge: 600_000
                        }
                    );
                } else {
                    $('#note-error').show();
                    console.log('Geolocation is not supported by this browser.');
                }
            }

            function initializeLocationPulang() {
                const btn = document.getElementById('AbsenPulang');
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        position => {
                            const latitude = position.coords.latitude;
                            const longitude = position.coords.longitude;
                            const formData = {
                                id: userId,
                                role: roleId,
                                latitude: latitude,
                                longitude: longitude,
                                status: status.value,
                            };

                            displayLocationIframe(latitude, longitude); // Show the map iframe

                            $('#skeletonMap').hide();
                            $('#AbsenPulang').show();
                            btn.onclick = function() {
                                sendFormData(formData);
                            };
                        },
                        error => {
                            console.error('Geolocation error:', error);
                            $('#note-error').show();
                        }
                    );
                } else {
                    $('#note-error').show();
                }
            }


            function initializePermit() {
                const btnIzin = document.getElementById('sendPermit');
                btnIzin.onclick = function() {
                    sendFormData({
                        id: userId,
                        status: status.value,
                        izin: document.getElementById('izin').value
                    });
                };
            }

            function initializeSick() {
                const btnSakit = document.getElementById('sendSick');
                btnSakit.onclick = function() {
                    const formData = new FormData();
                    const fileInput = document.getElementById('sickFile');
                    formData.append('id', userId);
                    formData.append('status', status.value);
                    if (fileInput.files.length > 0) {
                        formData.append('file', fileInput.files[0]);
                    }
                    sendFormData(formData, true);
                };
            }


            function displayLocationIframe(latitude, longitude) {

                console.log("Latitude: " + latitude + " Longitude: " + longitude);
                const googleMapsUrl =
                    `https://www.google.com/maps?q=${latitude},${longitude}&hl=es;z=14&output=embed`;
                locationIframe.innerHTML =
                    `<iframe width="100%" height="300" src="${googleMapsUrl}" allow="geolocation" frameborder="0" a allowfullscreen></iframe>`;
            }

            function sendFormData(data, isFile = false) {
                hideAll();
                $('#loading').show();
                $.ajax({
                    url: apiUrl,
                    method: 'POST',
                    data: data,
                    processData: !isFile,
                    contentType: isFile ? false : 'application/x-www-form-urlencoded; charset=UTF-8',

                    success: function(response) {
                        console.log('Response:', response); // Log response
                        $('#notif').text(response.message);
                        $('#toast-top-left').addClass("block").removeClass("hidden").show();
                    },
                    error: function(error) {
                        console.error('Error:', error);
                        $('#notif').text(error.responseJSON.message);
                        $('#toast-top-left').addClass("block").removeClass("hidden").show();
                    },
                    complete: function() {
                        $('#loading').hide();
                        status.value = '';
                        document.getElementById('izin').value = '';
                    }
                });
            }
        });
        const x = document.getElementById("demo");

        function getNavigator() {
            console.log("Initialize Location");

            const a = navigator.geolocation;

            console.log(a);
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition)
            }
        }

        function showPosition(position) {
            console.log("Latitude: " + position.coords.latitude);
            x.innerHTML = "Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords
                .longitude;
        }
    </script>
</x-app-layout>
