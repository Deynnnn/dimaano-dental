<div class="container-fluid text-light p-3 d-flex align-items-center justify-content-between sticky-top" style="background-color: rgb(165,16,18);">
    <h3 class="mb-0">DentalPal - ADMIN DASHBOARD</h3>
    <a href="logout.php" class="btn btn-light btn-sm">LOG OUT</a>
</div>

<div class="col-lg-2" id="dashboard-menu" style="background-color: rgb(165,16,18);">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid flex-lg-column align-items-stretch">
            <h4 class="mt-2 text-light">ADMIN PANEL</h4>
            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#adminPanelDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-column mt-2 align-items-stretch" id="adminPanelDropdown">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center" href="dashboard.php">
                        <span class="material-symbols-outlined">
                            grid_view
                        </span>
                        Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <button class="btn text-white px-3 w-100 shadow-none text-start d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#bookingLinks">
                            <div class="d-flex align-items-center">
                                <span class="material-symbols-outlined text-white">
                                    import_contacts
                                </span>
                                <span>Bookings</span>
                            </div>
                            <span><i class="bi bi-caret-down-fill"></i></span>
                        </button>
                        <div class="collapse show px-3 small mb-1" id="bookingLinks">
                            <ul class="nav nav-pills flex-column rounded border border-secondary">
                                <li class="nav-item">
                                    <a class="nav-link text-white d-flex align-items-center" href="new_bookings.php">
                                        New Bookings
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white d-flex align-items-center" href="refund_bookings.php">
                                        Refund Bookings
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white d-flex align-items-center" href="booking_records.php">
                                        Booking Records
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white d-flex align-items-center" href="print.php">
                                        <span class="material-symbols-outlined">
                                            print
                                        </span>
                                        Print
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center" href="features_facilities.php">
                            <span class="material-symbols-outlined">
                                concierge
                            </span>    
                            Features and Facilities
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="guests.php" class="nav-link text-white d-flex align-items-center">
                            <span class="material-symbols-outlined">
                                groups
                            </span>
                            Guest
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center" href="rooms.php">
                            <span class="material-symbols-outlined">
                                hotel
                            </span>
                            Rooms
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center" href="guest_queries.php">
                            <span class="material-symbols-outlined">
                                contact_support
                            </span>
                            Guest Queries
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center" href="rate_review.php">
                            <span class="material-symbols-outlined">
                            hotel_class 
                            </span> 
                            Rating and Review
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center" href="carousel.php">
                            <span class="material-symbols-outlined">
                                view_carousel
                            </span>    
                            Carousel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center" href="settings.php">
                            <span class="material-symbols-outlined">
                                settings
                            </span>
                            Settings
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
