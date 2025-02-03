@section('title', 'Change Password')

<x-app-layout>
    <div
        class="bg-gradient-to-tr from-red-primary to-red-secondary overflow-hidden shadow-sm sm:rounded-lg mt-5 xl:w-[80%] mx-auto rounded-lg">
        <div class="p-6 bg-gradient-to-tr from-red-primary to-red-secondary border-b border-gray-200">
            <div class="border-b border-white">
                <h2 class="font-semibold text-xl leading-tight text-white ">
                    Ubah Password
                </h2>
                <p class="text-[12px] italic text-white/80">Silahkan Ubah password anda dan lakukan login ulang</p>
            </div>
            <form method="POST" action="{{ route('changepassword.store') }}" onsubmit="return validatePasswords()">
                @csrf
                <div class="mt-5 space-y-5">
                    <div>
                        <label for="new-password" class="text-white text-sm">New Password</label>
                        <label class="input input-bordered input-info flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                class="h-4 w-4 opacity-70">
                                <path fill-rule="evenodd"
                                    d="M14 6a4 4 0 0 1-4.899 3.899l-1.955 1.955a.5.5 0 0 1-.353.146H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2.293a.5.5 0 0 1 .146-.353l3.955-3.955A4 4 0 1 1 14 6Zm-4-2a.75.75 0 0 0 0 1.5.5.5 0 0 1 .5.5.75.75 0 0 0 1.5 0 2 2 0 0 0-2-2Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <input type="password" id="new-password"
                                class="grow border-none focus:ring-0 focus:ring-offset-0" name="new_password" />
                            <span class="cursor-pointer w-[35px]"
                                onclick="togglePasswordVisibility('new-password', this)">
                                <svg id="eye-open-new" xmlns="http://www.w3.org/2000/svg"
                                    enable-background="new 0 0 32 32" viewBox="0 0 32 32" class="h-10 w-[30px] ">
                                    <path
                                        d="M31.29883,15.25C28.15088,9.7998,22.28906,6.41406,16,6.41406S3.84912,9.7998,0.70117,15.25c-0.26807,0.46387-0.26807,1.03613,0,1.5C3.84912,22.2002,9.71094,25.58594,16,25.58594S28.15088,22.2002,31.29883,16.75C31.56689,16.28613,31.56689,15.71387,31.29883,15.25z M16,22.58594c-4.92578,0-9.53662-2.50244-12.23682-6.58594C6.46338,11.9165,11.07422,9.41406,16,9.41406S25.53662,11.9165,28.23682,16C25.53662,20.0835,20.92578,22.58594,16,22.58594z">
                                    </path>
                                    <path
                                        d="M16,10.44629c-3.0625,0-5.55371,2.49121-5.55371,5.55371S12.9375,21.55371,16,21.55371S21.55371,19.0625,21.55371,16S19.0625,10.44629,16,10.44629z M16,18.55371c-1.4082,0-2.55371-1.14551-2.55371-2.55371S14.5918,13.44629,16,13.44629S18.55371,14.5918,18.55371,16S17.4082,18.55371,16,18.55371z">
                                    </path>
                                </svg>
                                <svg id="eye-closed-new" xmlns="http://www.w3.org/2000/svg" width="5"
                                    height="24" class="h-9 p-1 w-10 text-black flex items-center justify-center"
                                    style="display:none;">
                                    <g fill="none" fill-rule="evenodd" stroke="#000" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="3" class="w-5 h-5 stroke-current">
                                        <path
                                            d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24M1 1l22 22">
                                        </path>
                                    </g>
                                </svg>
                            </span>
                        </label>
                    </div>
                    <div>
                        <label for="confirm-password" class="text-white text-sm">Confirm New Password</label>
                        <label class="input input-bordered input-info flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                class="h-4 w-4 opacity-70">
                                <path fill-rule="evenodd"
                                    d="M14 6a4 4 0 0 1-4.899 3.899l-1.955 1.955a.5.5 0 0 1-.353.146H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2.293a.5.5 0 0 1 .146-.353l3.955-3.955A4 4 0 1 1 14 6Zm-4-2a.75.75 0 0 0 0 1.5.5.5 0 0 1 .5.5.75.75 0 0 0 1.5 0 2 2 0 0 0-2-2Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <input type="password" id="confirm-password"
                                class="grow border-none w-full focus:ring-0 focus:ring-offset-0 "
                                name="confirm_password" />
                            <span class="cursor-pointer w-[35px]"
                                onclick="togglePasswordVisibility('confirm-password', this)">
                                <svg id="eye-open-confirm" xmlns="http://www.w3.org/2000/svg"
                                    enable-background="new 0 0 32 32" viewBox="0 0 32 32" class="h-10 w-[30px] ">
                                    <path
                                        d="M31.29883,15.25C28.15088,9.7998,22.28906,6.41406,16,6.41406S3.84912,9.7998,0.70117,15.25c-0.26807,0.46387-0.26807,1.03613,0,1.5C3.84912,22.2002,9.71094,25.58594,16,25.58594S28.15088,22.2002,31.29883,16.75C31.56689,16.28613,31.56689,15.71387,31.29883,15.25z M16,22.58594c-4.92578,0-9.53662-2.50244-12.23682-6.58594C6.46338,11.9165,11.07422,9.41406,16,9.41406S25.53662,11.9165,28.23682,16C25.53662,20.0835,20.92578,22.58594,16,22.58594z">
                                    </path>
                                    <path
                                        d="M16,10.44629c-3.0625,0-5.55371,2.49121-5.55371,5.55371S12.9375,21.55371,16,21.55371S21.55371,19.0625,21.55371,16S19.0625,10.44629,16,10.44629z M16,18.55371c-1.4082,0-2.55371-1.14551-2.55371-2.55371S14.5918,13.44629,16,13.44629S18.55371,14.5918,18.55371,16S17.4082,18.55371,16,18.55371z">
                                    </path>
                                </svg>
                                <svg id="eye-closed-confirm" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24"class="h-9 p-1 w-10 text-black flex items-center justify-center"
                                    style="display:none;">
                                    <g fill="none" fill-rule="evenodd" stroke="#000" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="3">
                                        <path
                                            d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24M1 1l22 22">
                                        </path>
                                    </g>
                                </svg>
                            </span>
                        </label>
                    </div>
                    <div id="error-message" class="text-red-800 hidden font-semibold">Password yang anda masukan tidak
                        sesuai</div>
                    <div>
                        <button type="submit" class="btn bg-red-secondary text-white">Save Change</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    function togglePasswordVisibility(passwordId, icon) {
        const passwordInput = document.getElementById(passwordId);
        const eyeOpen = icon.querySelector('[id^="eye-open"]');
        const eyeClosed = icon.querySelector('[id^="eye-closed"]');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeOpen.style.display = 'none';
            eyeClosed.style.display = 'block';
        } else {
            passwordInput.type = 'password';
            eyeOpen.style.display = 'block';
            eyeClosed.style.display = 'none';
        }
    }

    function validatePasswords() {
        const newPassword = document.getElementById('new-password').value;
        const confirmPassword = document.getElementById('confirm-password').value;
        const errorMessage = document.getElementById('error-message');

        if (newPassword !== confirmPassword) {
            errorMessage.classList.remove('hidden');
            return false; // Prevent form submission
        } else {
            errorMessage.classList.add('hidden');
            return true; // Allow form submission
        }
    }
</script>
