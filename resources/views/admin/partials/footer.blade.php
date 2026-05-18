<footer class="admin-footer">
    <div class="admin-footer-text">&copy; <script>document.write(new Date().getFullYear())</script> BroNix</div>
</footer>

<script src="{{ asset('assets/admin/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/app.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var body = document.body;
        var toggleButtons = document.querySelectorAll('.admin-sidebar-toggle');

        toggleButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                if (window.innerWidth < 992) {
                    body.classList.toggle('admin-sidebar-open');
                    return;
                }

                body.classList.toggle('admin-sidebar-collapsed');
            });
        });

        document.querySelectorAll('[data-auto-submit="booking-status"]').forEach(function (form) {
            var select = form.querySelector('.admin-status-select');

            if (!select) {
                return;
            }

            select.addEventListener('change', function () {
                form.submit();
            });
        });

        document.addEventListener('click', function (event) {
            if (window.innerWidth >= 992 || !body.classList.contains('admin-sidebar-open')) {
                return;
            }

            var sidebar = document.querySelector('.app-sidebar-menu');
            var toggle = event.target.closest('.admin-sidebar-toggle');

            if (toggle || (sidebar && sidebar.contains(event.target))) {
                return;
            }

            body.classList.remove('admin-sidebar-open');
        });

        if (window.feather) {
            window.feather.replace();
        }
    });

    document.querySelectorAll('.schedule-row').forEach(function (row) {
        var checkbox = row.querySelector('.day-off');
        var start = row.querySelector('.start-time');
        var end = row.querySelector('.end-time');

        if (!checkbox || !start || !end) {
            return;
        }

        function toggle() {
            if (checkbox.checked) {
                start.disabled = false;
                end.disabled = false;
                row.style.opacity = '0.5';
            } else {
                start.disabled = false;
                end.disabled = false;
                row.style.opacity = '1';
            }
        }

        function switchToWorkDayIfTimeEntered() {
            if (start.value || end.value) {
                checkbox.checked = false;
                start.disabled = false;
                end.disabled = false;
                row.style.opacity = '1';
            }
        }

        checkbox.addEventListener('change', toggle);
        start.addEventListener('input', switchToWorkDayIfTimeEntered);
        end.addEventListener('input', switchToWorkDayIfTimeEntered);

        toggle();
    });
</script>
@stack('admin_scripts')
