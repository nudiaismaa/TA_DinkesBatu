document.addEventListener("DOMContentLoaded", function () {
    const sidebarItems = document.querySelectorAll(".sidebar-item.has-sub");
    const sidebar = document.getElementById("sidebar");
    const burgerBtn = document.getElementById("burger-btn");
    const sidebarBackdrop = document.createElement('div');
    sidebarBackdrop.className = 'sidebar-backdrop';
    document.body.appendChild(sidebarBackdrop);

    sidebarItems.forEach((item) => {
        const submenu = item.querySelector(".submenu");
        const link = item.querySelector(".sidebar-link");

        // Jika ada submenu yang aktif, tetap terbuka
        const activeSubmenu = submenu.querySelector(".submenu-item.active");
        if (activeSubmenu) {
            submenu.style.maxHeight = submenu.scrollHeight + "px";
            item.classList.add("submenu-open"); // Tambah class untuk styling
        }

        link.addEventListener("click", function (e) {
            e.preventDefault(); // Hindari reload halaman

            // Jika submenu sedang terbuka, tutup
            if (submenu.style.maxHeight) {
                submenu.style.maxHeight = null;
                item.classList.remove("submenu-open");
            } else {
                // Tutup semua submenu lain sebelum membuka yang diklik
                sidebarItems.forEach((otherItem) => {
                    if (otherItem !== item) {
                        otherItem.classList.remove("submenu-open");
                        otherItem.querySelector(".submenu").style.maxHeight = null;
                    }
                });

                // Buka submenu yang diklik
                submenu.style.maxHeight = submenu.scrollHeight + "px";
                item.classList.add("submenu-open");
            }
        });
    });

    // Highlight active submenu item
    const activeSubmenuItem = document.querySelector(".submenu-item.active");
    if (activeSubmenuItem) {
        activeSubmenuItem.closest(".submenu").style.maxHeight = activeSubmenuItem.closest(".submenu").scrollHeight + "px";
        activeSubmenuItem.closest(".sidebar-item.has-sub").classList.add("submenu-open");
    }

    // Toggle sidebar on burger button click
    burgerBtn.addEventListener("click", function () {
        sidebar.classList.toggle("active");
        sidebarBackdrop.classList.toggle("active");
    });

    // Hide sidebar when clicking outside of it
    sidebarBackdrop.addEventListener("click", function () {
        sidebar.classList.remove("active");
        sidebarBackdrop.classList.remove("active");
    });
});