    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
    <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>

    <!-- morris chart -->
    <script src="{{asset('assets/libs/morris.js/morris.min.js')}}"></script>
    <script src="{{asset('assets/libs/raphael/raphael.min.js')}}"></script>

    <!-- jquery.vectormap map -->
    <script src="{{asset('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
    <script src="{{asset('assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js')}}"></script>

    <!-- Required datatable js -->
    <script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Responsive examples -->
    <script src="{{asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

    <script src="{{asset('assets/js/pages/index.init.js')}}"></script>

    <script src="{{asset('assets/js/app.js')}}"></script>


    <script>
        // Move the single filter set to offcanvas on mobile
        document.addEventListener("DOMContentLoaded", function () {
            let filters = document.getElementById("filters");
            let filterPlaceholder = document.getElementById("filterPlaceholder");

            // When the offcanvas opens, move the filters inside it
            document.getElementById("filterDrawer").addEventListener("show.bs.offcanvas", function () {
                filterPlaceholder.appendChild(filters);
                filters.style.display = "block"; // Show it inside offcanvas
            });

            // When the offcanvas closes, move the filters back to their original place
            document.getElementById("filterDrawer").addEventListener("hidden.bs.offcanvas", function () {
                document.querySelector(".filter-container").appendChild(filters);
                if (window.innerWidth <= 768) {
                    filters.style.display = "none"; // Hide it again on mobile
                }
            });
        });
    </script>