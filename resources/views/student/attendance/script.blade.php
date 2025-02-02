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

            console.log("statusValue", statusValue);
            hideAll();
            switch (statusValue) {
                case 'hadir':
                    showLocation();
                    break;

                case 'pulang':
                    showPulang();
                    break;


                case 'izin':
                    showPermit();
                    break;


                case 'sakit':
                    showSick();
                    break;
                default:
                    break;
            }
        }

        function hideAll() {
            $('#fileUpload, #permit, #sendHadir, #sendPulang, #sendPermit, #sendSick, #toast-top-left')
                .hide();
            locationIframe.innerHTML = ''; // Clear iframe when status changes
        }

        function showLocation() {
            $('#sendHadir').show(); // Show the WFO button correctly
            initializeLocation('sendHadir');
        }


        function showPulang() {
            $('#sendPulang').show();
            initializeLocation('sendPulang');
        }

        function showPermit() {
            $('#permit, #sendPermit').show();
            initializePermit();
        }

        function showSick() {
            $('#fileUpload, #sendSick').show();
            initializeSick();
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

        function initializeLocation(type) {
            const btn = document.getElementById(type);
            navigator.geolocation.getCurrentPosition(
                position => {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    const formData = {
                        id: userId,
                        role: roleId,
                        latitude: latitude,
                        longitude: longitude,
                        status: type,
                    };

                    displayLocationIframe(latitude, longitude); // Show the map iframe

                    btn.onclick = function() {
                        sendFormData(formData);
                    };
                },
                error => {
                    console.error('Geolocation error:', error);
                    $('#note-error').show();
                }
            );
        }

        function displayLocationIframe(latitude, longitude) {
            const googleMapsUrl =
                `https://www.google.com/maps?q=${latitude},${longitude}&hl=es;z=14&output=embed`;
            locationIframe.innerHTML =
                `<iframe width="100%" height="300" src="${googleMapsUrl}" frameborder="0" allowfullscreen></iframe>`;
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
</script>
