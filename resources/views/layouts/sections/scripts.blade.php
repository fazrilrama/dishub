<!-- BEGIN: Vendor JS-->
<script src="{{ asset(mix('assets/vendor/libs/jquery/jquery.js')) }}"></script>
<script src="{{ asset(mix('assets/vendor/libs/popper/popper.js')) }}"></script>
<script src="{{ asset(mix('assets/vendor/js/bootstrap.js')) }}"></script>
<script src="{{ asset(mix('assets/vendor/libs/node-waves/node-waves.js')) }}"></script>
<script src="{{ asset(mix('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')) }}"></script>
<script src="{{ asset(mix('assets/vendor/js/menu.js')) }}"></script>
@yield('vendor-script')
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="{{ asset(mix('assets/js/main.js')) }}"></script>

<!-- END: Theme JS-->
<!-- Pricing Modal JS-->
@stack('pricing-script')
<!-- END: Pricing Modal JS-->
<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('.AuthLogout').on('click', function() {
            let formData = new FormData();
            formData.append("_token", $('meta[name="csrf-token"]').attr('content'));

            Swal.fire({
                title: "Anda yakin?",
                text: "Anda akan logout dari akun tersebut!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, logout sekarang!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url("auth/Veriflogout") }}',
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json', 
                        success: function(data) {
                            Swal.fire({
                                title: "Congratulations",
                                text: "Anda berhasil Logout",
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "{{ route('auth-login-basic') }}";
                                }
                            });
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                }
            });
        });
    })

    function getFormatDate(date) {
        const tanggalSended = new Date(date);

        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sept', 'Okt', 'Nov', 'Des'];

        const dayName = days[tanggalSended.getDay()];

        const day = tanggalSended.getDate();
        const month = months[tanggalSended.getMonth()];
        const year = tanggalSended.getFullYear();
        const hours = tanggalSended.getHours().toString().padStart(2, '0'); // Menambahkan nol jika jam kurang dari 10
        const minutes = tanggalSended.getMinutes().toString().padStart(2, '0');

        // Hasil
        const formattedDate = `${dayName}, ${day}-${month}-${year} (${hours}:${minutes})`;
        return formattedDate;
    }
</script>